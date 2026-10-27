<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\TicketType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class TicketOrderService
{
    public function create(array $data): Order
    {
        return DB::transaction(function () use ($data) {
            $event = Event::query()
                ->whereKey($data['event_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($event->status !== 'published') {
                throw ValidationException::withMessages([
                    'event_id' => 'Acara belum tersedia untuk pemesanan.',
                ]);
            }

            $items = collect($data['items'])
                ->filter(fn ($row) => (int) $row['quantity'] > 0)
                ->groupBy('ticket_type_id')
                ->map(fn ($rows) => [
                    'ticket_type_id' => (int) $rows->first()['ticket_type_id'],
                    'quantity' => $rows->sum(
                        fn ($row) => (int) $row['quantity']
                    ),
                ])
                ->values();

            $totalQuantity = $items->sum('quantity');

            if ($totalQuantity < 1) {
                throw ValidationException::withMessages([
                    'items' => 'Pilih minimal satu tiket.',
                ]);
            }

            $order = Order::create([
                'event_id' => $event->id,
                'order_code' => 'SNC-' . Str::upper(Str::random(12)),
                'buyer_name' => $data['buyer_name'],
                'buyer_email' => $data['buyer_email'],
                'buyer_phone' => $data['buyer_phone'] ?? null,
                'quantity' => $totalQuantity,
                'total_amount' => 0,
                'status' => 'pending',
                'expires_at' => now()->addMinutes(15),
            ]);

            $totalAmount = 0;

            foreach ($items as $item) {
                $ticketType = TicketType::query()
                    ->whereKey($item['ticket_type_id'])
                    ->where('event_id', $event->id)
                    ->lockForUpdate()
                    ->first();

                if (
                    ! $ticketType ||
                    $ticketType->status !== 'active'
                ) {
                    throw ValidationException::withMessages([
                        'items' => 'Jenis tiket tidak tersedia.',
                    ]);
                }

                $now = now();

                if (
                    ($ticketType->sales_start_at &&
                        $now->lt($ticketType->sales_start_at)) ||
                    ($ticketType->sales_end_at &&
                        $now->gt($ticketType->sales_end_at))
                ) {
                    throw ValidationException::withMessages([
                        'items' => 'Periode penjualan tiket tidak aktif.',
                    ]);
                }

                $available = $ticketType->quota
                    - $ticketType->reserved_quantity
                    - $ticketType->sold_quantity;

                if (
                    $item['quantity'] < 1 ||
                    $item['quantity'] > $available
                ) {
                    throw ValidationException::withMessages([
                        'items' => 'Kuota tiket tidak mencukupi.',
                    ]);
                }

                $subtotal = $ticketType->price * $item['quantity'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'ticket_type_id' => $ticketType->id,
                    'quantity' => $item['quantity'],
                    'checked_in_quantity' => 0,
                    'unit_price' => $ticketType->price,
                    'subtotal' => $subtotal,
                ]);

                $ticketType->increment(
                    'reserved_quantity',
                    $item['quantity']
                );

                $totalAmount += $subtotal;
            }

            $order->update([
                'total_amount' => $totalAmount,
            ]);

            return $order->load('items');
        }, 3);
    }
}