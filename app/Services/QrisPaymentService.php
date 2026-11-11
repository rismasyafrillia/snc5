<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use App\Models\TicketType;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class QrisPaymentService
{
    public function __construct(
        private OrderExpirationService $orderExpirationService
    ) {}

    public function createDynamicPayload(Order $order): string
    {
        if ($order->status !== 'pending' || (int) $order->total_amount < 1) {
            throw new RuntimeException('Pesanan tidak valid untuk pembayaran QRIS.');
        }

        $merchantPayload = config('services.qris.merchant_payload');

        if (! is_string($merchantPayload) || trim($merchantPayload) === '') {
            throw new RuntimeException('Payload QRIS merchant belum dikonfigurasi.');
        }

        $fields = $this->parseMerchantPayload(trim($merchantPayload));

        if (($fields['01'] ?? null) !== '11') {
            throw new RuntimeException('Payload QRIS harus menggunakan QRIS statis merchant.');
        }

        if (isset($fields['54'])) {
            throw new RuntimeException('Payload QRIS merchant tidak boleh memuat nominal tetap.');
        }

        if (($fields['53'] ?? null) !== '360' || ($fields['58'] ?? null) !== 'ID') {
            throw new RuntimeException('Payload QRIS merchant tidak memiliki mata uang atau negara yang valid.');
        }

        $hasMerchantAccount = false;

        foreach (array_keys($fields) as $tag) {
            if ((int) $tag >= 26 && (int) $tag <= 51) {
                $hasMerchantAccount = true;
                break;
            }
        }

        if (! $hasMerchantAccount) {
            throw new RuntimeException('Payload QRIS merchant tidak memiliki data merchant.');
        }

        $fields['01'] = '12';
        $amount = (string) $order->total_amount;

        $payload = '';

        foreach ($fields as $tag => $value) {
            $payload .= $this->encodeField($tag, $value);

            if ((string) $tag === '53') {
                $payload .= $this->encodeField('54', $amount);
            }
        }

        $payload .= '6304';

        return $payload.strtoupper(sprintf('%04X', $this->crc16($payload)));
    }

    public function recordPendingPayment(Order $order): void
    {
        Payment::query()->updateOrCreate(
            ['provider_order_id' => $order->order_code],
            [
                'order_id' => $order->id,
                'provider' => 'qris',
                'payment_type' => 'QRIS',
                'transaction_status' => 'pending',
                'gross_amount' => $order->total_amount,
                'raw_status' => ['confirmation_method' => 'manual'],
            ]
        );
    }

    public function confirmPayment(int $orderId, int $adminId): int
    {
        $this->orderExpirationService->expireDue(orderId: $orderId);

        return DB::transaction(function () use ($orderId, $adminId): int {
            $order = Order::query()
                ->with('items')
                ->lockForUpdate()
                ->findOrFail($orderId);

            if ($order->status === 'paid') {
                return $order->id;
            }

            if ($order->status !== 'pending') {
                throw new RuntimeException(
                    $order->status === 'expired'
                        ? 'Pesanan telah kedaluwarsa.'
                        : 'Hanya pesanan yang menunggu pembayaran yang dapat dikonfirmasi.'
                );
            }

            if (
                ($order->expires_at !== null && $order->expires_at->lte(now())) ||
                ($order->expires_at === null && $order->created_at?->lte(now()->subMinutes(15)))
            ) {
                throw new RuntimeException('Pesanan telah kedaluwarsa.');
            }

            if ($order->items->isEmpty()) {
                throw new RuntimeException('Pesanan tidak memiliki rincian tiket.');
            }

            foreach ($order->items as $item) {
                $ticketType = TicketType::query()
                    ->whereKey($item->ticket_type_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ((int) $ticketType->reserved_quantity < (int) $item->quantity) {
                    throw new RuntimeException('Jumlah reservasi tiket tidak sesuai.');
                }

                $ticketType->reserved_quantity -= (int) $item->quantity;
                $ticketType->sold_quantity += (int) $item->quantity;
                $ticketType->save();
            }

            $confirmedAt = now();
            $order->status = 'paid';
            $order->paid_at = $confirmedAt;
            $order->save();

            $payment = Payment::query()
                ->where('provider_order_id', $order->order_code)
                ->lockForUpdate()
                ->first() ?? new Payment([
                    'order_id' => $order->id,
                    'provider_order_id' => $order->order_code,
                ]);

            $payment->fill([
                'order_id' => $order->id,
                'provider' => 'qris',
                'payment_type' => 'QRIS',
                'transaction_status' => 'paid',
                'gross_amount' => $order->total_amount,
                'raw_status' => [
                    'confirmation_method' => 'manual',
                    'confirmed_by' => $adminId,
                    'confirmed_at' => $confirmedAt->toISOString(),
                ],
                'paid_at' => $confirmedAt,
            ]);
            $payment->save();

            return $order->id;
        }, 3);
    }

    public function confirmExpiredPayment(int $orderId, int $adminId): int
    {
        return DB::transaction(function () use ($orderId, $adminId): int {
            $order = Order::query()
                ->with('items')
                ->lockForUpdate()
                ->findOrFail($orderId);

            if ($order->status !== 'expired') {
                throw new RuntimeException('Hanya pesanan kedaluwarsa yang dapat dikonfirmasi melalui override.');
            }

            if ($order->items->isEmpty()) {
                throw new RuntimeException('Pesanan tidak memiliki rincian tiket.');
            }

            foreach ($order->items as $item) {
                $ticketType = TicketType::query()
                    ->whereKey($item->ticket_type_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $available = (int) $ticketType->quota
                    - (int) $ticketType->reserved_quantity
                    - (int) $ticketType->sold_quantity;

                if ($available < (int) $item->quantity) {
                    throw new RuntimeException(
                        'Kuota tiket tidak lagi mencukupi. Pesanan tidak dikonfirmasi agar tidak terjadi penjualan melebihi kuota.'
                    );
                }

                $ticketType->sold_quantity += (int) $item->quantity;
                $ticketType->save();
            }

            $confirmedAt = now();
            $order->status = 'paid';
            $order->paid_at = $confirmedAt;
            $order->save();

            $payment = Payment::query()
                ->where('provider_order_id', $order->order_code)
                ->lockForUpdate()
                ->first() ?? new Payment([
                    'order_id' => $order->id,
                    'provider_order_id' => $order->order_code,
                ]);
            $rawStatus = $payment->raw_status ?? [];
            $rawStatus['confirmation_method'] = 'manual_late_override';
            $rawStatus['confirmed_by'] = $adminId;
            $rawStatus['confirmed_at'] = $confirmedAt->toISOString();

            $payment->fill([
                'order_id' => $order->id,
                'provider' => 'qris',
                'payment_type' => 'QRIS',
                'transaction_status' => 'paid',
                'gross_amount' => $order->total_amount,
                'raw_status' => $rawStatus,
                'paid_at' => $confirmedAt,
            ]);
            $payment->save();

            return $order->id;
        }, 3);
    }

    private function parseMerchantPayload(string $payload): array
    {
        if (strlen($payload) < 12 || substr($payload, -8, 4) !== '6304') {
            throw new RuntimeException('Payload QRIS merchant tidak valid.');
        }

        $providedCrc = strtoupper(substr($payload, -4));
        $expectedCrc = strtoupper(sprintf('%04X', $this->crc16(substr($payload, 0, -4))));

        if (! ctype_xdigit($providedCrc) || ! hash_equals($expectedCrc, $providedCrc)) {
            throw new RuntimeException('CRC payload QRIS merchant tidak valid.');
        }

        $data = substr($payload, 0, -8);
        $offset = 0;
        $fields = [];

        while ($offset < strlen($data)) {
            if ($offset + 4 > strlen($data)) {
                throw new RuntimeException('Struktur payload QRIS merchant tidak valid.');
            }

            $tag = substr($data, $offset, 2);
            $lengthText = substr($data, $offset + 2, 2);

            if (! ctype_digit($tag) || ! ctype_digit($lengthText) || isset($fields[$tag])) {
                throw new RuntimeException('Struktur payload QRIS merchant tidak valid.');
            }

            $length = (int) $lengthText;
            $offset += 4;

            if ($offset + $length > strlen($data)) {
                throw new RuntimeException('Struktur payload QRIS merchant tidak valid.');
            }

            $fields[$tag] = substr($data, $offset, $length);
            $offset += $length;
        }

        return $fields;
    }

    private function encodeField(string $tag, string $value): string
    {
        $length = strlen($value);

        if ($length > 99) {
            throw new RuntimeException('Data payload QRIS terlalu panjang.');
        }

        return $tag.str_pad((string) $length, 2, '0', STR_PAD_LEFT).$value;
    }

    private function crc16(string $data): int
    {
        $crc = 0xFFFF;

        for ($index = 0, $length = strlen($data); $index < $length; $index++) {
            $crc ^= ord($data[$index]) << 8;

            for ($bit = 0; $bit < 8; $bit++) {
                $crc = ($crc & 0x8000) !== 0
                    ? (($crc << 1) ^ 0x1021)
                    : ($crc << 1);
                $crc &= 0xFFFF;
            }
        }

        return $crc;
    }
}
