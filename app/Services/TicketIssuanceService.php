<?php

namespace App\Services;

use App\Mail\TicketConfirmationMail;
use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use RuntimeException;

class TicketIssuanceService
{
    public function issueAndSend(int $orderId): void
    {
        // Buat tiket satu kali di dalam transaksi database.
        $order = DB::transaction(function () use ($orderId) {
            $order = Order::query()
                ->with('items.ticketType')
                ->lockForUpdate()
                ->findOrFail($orderId);

            if ($order->status !== 'paid') {
                throw new RuntimeException(
                    'Tiket hanya dapat diterbitkan untuk pesanan yang sudah dibayar.'
                );
            }

            foreach ($order->items as $item) {
                $existing = Ticket::query()
                    ->where('order_item_id', $item->id)
                    ->count();

                $needed = (int) $item->quantity - $existing;

                for ($i = 0; $i < $needed; $i++) {
                    $token = Str::random(64);

                    Ticket::create([
                        'order_item_id' => $item->id,
                        'ticket_code' => 'SNC-' . Str::upper(Str::random(12)),
                        'qr_token_hash' => hash('sha256', $token),
                        'qr_token' => $token,
                        'status' => 'valid',
                    ]);
                }
            }

            return $order->fresh('items.tickets');
        });

        // Jangan kirim email berulang jika sudah berhasil.
        if ($order->email_sent_at !== null) {
            return;
        }

        $qrService = app(TicketQrService::class);
        $ticketImages = [];

        foreach ($order->items as $item) {
            foreach ($item->tickets as $ticket) {
                $ticketImages[] = [
                    'ticket_code' => $ticket->ticket_code,
                    'qr_cid' => 'qr_' . $ticket->id,
                    'qr_png' => $qrService->generate($ticket->qr_token),
                ];
            }
        }

        try {
            Mail::to($order->buyer_email)->send(
                new TicketConfirmationMail($order, $ticketImages)
            );

            $order->forceFill(['email_sent_at' => now()])->save();
        } catch (\Throwable $e) {
            Log::error('Gagal mengirim email tiket SNC', [
                'order_code' => $order->order_code,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
