<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;
use RuntimeException;

class MidtransPaymentService
{
    private function configure(): void
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = (bool) config(
            'services.midtrans.is_production',
            false
        );
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createSnapToken(Order $order): string
    {
        if ($order->status !== 'pending') {
            throw new RuntimeException(
                'Pesanan ini tidak sedang menunggu pembayaran.'
            );
        }

        if (
            $order->expires_at &&
            now()->greaterThanOrEqualTo($order->expires_at)
        ) {
            throw new RuntimeException(
                'Batas waktu pembayaran pesanan telah berakhir.'
            );
        }

        $order->loadMissing(['event', 'items.ticketType']);

        if ($order->items->isEmpty() || $order->total_amount < 1) {
            throw new RuntimeException('Rincian pesanan tidak valid.');
        }

        $itemDetails = $order->items->map(function ($item) {
            return [
                'id' => (string) $item->ticket_type_id,
                'price' => (int) $item->unit_price,
                'quantity' => (int) $item->quantity,
                'name' => substr(
                    $item->ticketType->name,
                    0,
                    50
                ),
            ];
        })->values()->all();

        $itemTotal = collect($itemDetails)->sum(
            fn ($item) => $item['price'] * $item['quantity']
        );

        if ($itemTotal !== (int) $order->total_amount) {
            throw new RuntimeException(
                'Total tiket tidak sesuai dengan total pesanan.'
            );
        }

        $this->configure();

        $params = [
            'transaction_details' => [
                'order_id' => $order->order_code,
                'gross_amount' => (int) $order->total_amount,
            ],
            'item_details' => $itemDetails,
            'customer_details' => [
                'first_name' => $order->buyer_name,
                'email' => $order->buyer_email,
                'phone' => $order->buyer_phone ?? '',
            ],
            'expiry' => [
                'start_time' => now()->format('Y-m-d H:i:s O'),
                'unit' => 'minute',
                'duration' => 15,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        DB::transaction(function () use ($order, $snapToken) {
            Payment::updateOrCreate(
                [
                    'provider_order_id' => $order->order_code,
                ],
                [
                    'order_id' => $order->id,
                    'provider' => 'midtrans',
                    'transaction_status' => 'pending',
                    'gross_amount' => $order->total_amount,
                    'raw_status' => [
                        'snap_token' => $snapToken,
                    ],
                ]
            );
        });

        return $snapToken;
    }

    
    public function createSnapRedirectUrl(Order $order): string
    {
        if ($order->status !== 'pending') {
            throw new RuntimeException(
                'Pesanan tidak sedang menunggu pembayaran.'
            );
        }

        if (
            $order->expires_at &&
            now()->greaterThanOrEqualTo($order->expires_at)
        ) {
            throw new RuntimeException(
                'Batas waktu pembayaran telah berakhir.'
            );
        }

        $order->loadMissing(['event', 'items.ticketType']);

        if ($order->items->isEmpty() || $order->total_amount < 1) {
            throw new RuntimeException('Rincian pesanan tidak valid.');
        }

        $itemDetails = $order->items->map(function ($item) {
            return [
                'id' => (string) $item->ticket_type_id,
                'price' => (int) $item->unit_price,
                'quantity' => (int) $item->quantity,
                'name' => substr($item->ticketType->name, 0, 50),
            ];
        })->values()->all();

        $itemTotal = collect($itemDetails)->sum(
            fn ($item) => $item['price'] * $item['quantity']
        );

        if ($itemTotal !== (int) $order->total_amount) {
            throw new RuntimeException(
                'Total pesanan tidak sesuai.'
            );
        }

        $this->configure();

        $params = [
            'transaction_details' => [
                'order_id' => $order->order_code,
                'gross_amount' => (int) $order->total_amount,
            ],
            'item_details' => $itemDetails,
            'customer_details' => [
                'first_name' => $order->buyer_name,
                'email' => $order->buyer_email,
                'phone' => $order->buyer_phone ?? '',
            ],
            'callbacks' => [
                'finish' => route('orders.success', [
                    'order_code' => $order->order_code,
                ]),
            ],
            'expiry' => [
                'start_time' => now()->format('Y-m-d H:i:s O'),
                'unit' => 'minute',
                'duration' => 15,
            ],
        ];

        $transaction = \Midtrans\Snap::createTransaction($params);

        $paymentUrl = $transaction->redirect_url ?? null;

        if (!is_string($paymentUrl) ||
            !str_starts_with($paymentUrl, 'https://')) {
            throw new RuntimeException(
                'Midtrans tidak mengembalikan URL pembayaran yang valid.'
            );
        }

        \App\Models\Payment::updateOrCreate(
            ['provider_order_id' => $order->order_code],
            [
                'order_id' => $order->id,
                'provider' => 'midtrans',
                'transaction_status' => 'pending',
                'gross_amount' => $order->total_amount,
            ]
        );

        return $paymentUrl;
    }
}
