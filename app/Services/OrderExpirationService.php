<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use App\Models\TicketType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class OrderExpirationService
{
    public function expireDue(
        ?int $orderId = null,
        ?string $normalizedPhone = null,
        int $limit = 1000
    ): int {
        $now = now();
        $legacyCutoff = $now->copy()->subMinutes(15);

        $query = Order::query()
            ->where('status', 'pending')
            ->where(function (Builder $query) use ($now, $legacyCutoff): void {
                $query->where('expires_at', '<=', $now)
                    ->orWhere(function (Builder $query) use ($legacyCutoff): void {
                        $query->whereNull('expires_at')
                            ->where('created_at', '<=', $legacyCutoff);
                    });
            });

        if ($orderId !== null) {
            $query->whereKey($orderId);
        }

        if ($normalizedPhone !== null) {
            $query->where('buyer_phone_normalized', $normalizedPhone);
        }

        $orderIds = $query
            ->orderBy('id')
            ->limit($limit)
            ->pluck('id');

        $expiredCount = 0;

        foreach ($orderIds as $id) {
            if ($this->expire((int) $id)) {
                $expiredCount++;
            }
        }

        return $expiredCount;
    }

    private function expire(int $orderId): bool
    {
        return DB::transaction(function () use ($orderId): bool {
            $order = Order::query()
                ->lockForUpdate()
                ->find($orderId);

            if (! $order || $order->status !== 'pending' || ! $this->isDue($order)) {
                return false;
            }

            $items = $order->items()
                ->orderBy('ticket_type_id')
                ->get();

            foreach ($items as $item) {
                $ticketType = TicketType::query()
                    ->whereKey($item->ticket_type_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ((int) $ticketType->reserved_quantity < (int) $item->quantity) {
                    throw new RuntimeException('Jumlah reservasi tiket tidak sesuai saat pesanan kedaluwarsa.');
                }

                $ticketType->reserved_quantity -= (int) $item->quantity;
                $ticketType->save();
            }

            $expiredAt = now();
            $order->status = 'expired';
            $order->save();

            $payments = Payment::query()
                ->where('order_id', $order->id)
                ->lockForUpdate()
                ->get();

            foreach ($payments as $payment) {
                $payment->transaction_status = 'expired';
                $payment->raw_status = array_merge(
                    $payment->raw_status ?? [],
                    ['expired_at' => $expiredAt->toISOString()]
                );
                $payment->save();
            }

            return true;
        }, 3);
    }

    private function isDue(Order $order): bool
    {
        if ($order->expires_at !== null) {
            return $order->expires_at->lte(now());
        }

        return $order->created_at !== null
            && $order->created_at->lte(now()->subMinutes(15));
    }
}
