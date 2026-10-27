<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\TicketType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request): JsonResponse
    {
        $notification = $request->all();

        $orderCode = $notification['order_id'] ?? null;
        $statusCode = $notification['status_code'] ?? null;
        $grossAmount = $notification['gross_amount'] ?? null;
        $signatureKey = $notification['signature_key'] ?? null;

        if (
            !is_string($orderCode) ||
            !is_string($statusCode) ||
            !is_string($grossAmount) ||
            !is_string($signatureKey)
        ) {
            return response()->json([
                'message' => 'Notifikasi tidak lengkap.',
            ], 400);
        }

        $serverKey = config('services.midtrans.server_key');

        if (!is_string($serverKey) || $serverKey === '') {
            Log::error('Midtrans server key belum dikonfigurasi.');

            return response()->json([
                'message' => 'Konfigurasi pembayaran bermasalah.',
            ], 500);
        }

        $expectedSignature = hash(
            'sha512',
            $orderCode . $statusCode . $grossAmount . $serverKey
        );

        if (!hash_equals($expectedSignature, $signatureKey)) {
            return response()->json([
                'message' => 'Signature tidak valid.',
            ], 403);
        }

        try {
            DB::transaction(function () use ($notification, $orderCode, $grossAmount) {
                $order = Order::query()
                    ->where('order_code', $orderCode)
                    ->lockForUpdate()
                    ->firstOrFail();

                // Samakan nominal sebagai string desimal rupiah.
                $receivedAmount = number_format(
                    (float) $grossAmount,
                    2,
                    '.',
                    ''
                );

                $expectedAmount = number_format(
                    (float) $order->total_amount,
                    2,
                    '.',
                    ''
                );

                if ($receivedAmount !== $expectedAmount) {
                    throw new \RuntimeException(
                        'Nominal pembayaran tidak sesuai.'
                    );
                }

                $transactionStatus =
                    $notification['transaction_status'] ?? '';

                $fraudStatus = $notification['fraud_status'] ?? null;

                $payment = Payment::query()
                    ->where('provider_order_id', $orderCode)
                    ->lockForUpdate()
                    ->first();

                if (!$payment) {
                    $payment = new Payment();
                    $payment->order_id = $order->id;
                    $payment->provider = 'midtrans';
                    $payment->provider_order_id = $orderCode;
                }

                $payment->transaction_id =
                    $notification['transaction_id']
                    ?? $payment->transaction_id;

                $payment->payment_type =
                    $notification['payment_type']
                    ?? $payment->payment_type;

                $payment->gross_amount = $order->total_amount;
                $payment->raw_status = $notification;

                // Status paid tidak boleh diturunkan oleh notifikasi lama.
                if ($order->status === 'paid') {
                    $payment->transaction_status = 'settlement';
                    $payment->paid_at ??= $order->paid_at ?? now();
                    $payment->save();

                    return;
                }

                $isPaid = $transactionStatus === 'settlement'
                    || (
                        $transactionStatus === 'capture'
                        && $fraudStatus === 'accept'
                    );

                if ($isPaid) {
                    // Jangan tandai pembayaran berhasil jika pesanan
                    // sudah dibatalkan atau kedaluwarsa.
                    if ($order->status !== 'pending') {
                        throw new \RuntimeException(
                            'Pembayaran berhasil diterima untuk pesanan yang sudah berakhir; perlu pemeriksaan manual.'
                        );
                    }

                    $items = $order->items()->get();

                    if ($items->isEmpty()) {
                        throw new \RuntimeException(
                            'Pesanan tidak memiliki rincian tiket.'
                        );
                    }

                    foreach ($items as $item) {
                        $ticketType = TicketType::query()
                            ->whereKey($item->ticket_type_id)
                            ->lockForUpdate()
                            ->firstOrFail();

                        if (
                            (int) $ticketType->reserved_quantity
                            < (int) $item->quantity
                        ) {
                            throw new \RuntimeException(
                                'Jumlah reservasi tiket tidak sesuai.'
                            );
                        }

                        $ticketType->reserved_quantity -=
                            (int) $item->quantity;

                        $ticketType->sold_quantity +=
                            (int) $item->quantity;

                        $ticketType->save();
                    }

                    $order->status = 'paid';
                    $order->paid_at = now();

                    $payment->transaction_status = $transactionStatus;
                    $payment->paid_at = now();
                } elseif (
                    in_array(
                        $transactionStatus,
                        ['expire', 'cancel', 'deny', 'failure'],
                        true
                    )
                    && $order->status === 'pending'
                ) {
                    // Lepaskan reservasi di transaksi database yang sama.
                    $items = $order->items()->get();

                    foreach ($items as $item) {
                        $ticketType = TicketType::query()
                            ->whereKey($item->ticket_type_id)
                            ->lockForUpdate()
                            ->firstOrFail();

                        $ticketType->reserved_quantity = max(
                            0,
                            (int) $ticketType->reserved_quantity
                                - (int) $item->quantity
                        );

                        $ticketType->save();
                    }

                    $order->status = in_array(
                        $transactionStatus,
                        ['expire'],
                        true
                    ) ? 'expired' : 'cancelled';

                    $payment->transaction_status = $transactionStatus;
                } else {
                    $payment->transaction_status = $transactionStatus;
                }

                $order->save();
                $payment->save();
            });

            return response()->json([
                'message' => 'Notifikasi diproses.',
            ]);
        } catch (\Throwable $e) {
            Log::error('Webhook Midtrans gagal diproses', [
                'order_id' => $orderCode,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Notifikasi gagal diproses.',
            ], 500);
        }
    }
}
