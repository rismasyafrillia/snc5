<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Order;
use App\Models\TicketType;
use App\Services\TicketOrderService;
use App\Services\MidtransPaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class TicketOrderController extends Controller
{
    public function create(): View
    {
        $event = Event::query()
            ->where('slug', 'sparkling-nganjuk-carnival-5')
            ->where('status', 'published')
            ->firstOrFail();

        $ticketTypes = TicketType::query()
            ->where('event_id', $event->id)
            ->where('status', 'active')
            ->orderBy('price', 'desc')
            ->get();

        return view('orders.create', compact(
            'event',
            'ticketTypes'
        ));
    }

    public function store(
        Request $request,
        TicketOrderService $ticketOrderService,
        MidtransPaymentService $midtransPaymentService
    ): RedirectResponse {
        $data = $request->validate([
            'event_id' => [
                'required',
                'integer',
                'exists:events,id',
            ],
            'buyer_name' => [
                'required',
                'string',
                'max:255',
            ],
            'buyer_email' => [
                'required',
                'email',
                'max:255',
            ],
            'buyer_phone' => [
                'nullable',
                'string',
                'max:30',
            ],
            'items' => [
                'required',
                'array',
                'min:1',
            ],
            'items.*.ticket_type_id' => [
                'required',
                'integer',
                'distinct',
                'exists:ticket_types,id',
            ],
            'items.*.quantity' => [
                'required',
                'integer',
                'min:0',
                'max:10',
            ],
        ]);

        $order = $ticketOrderService->create($data);

        try {
            $paymentUrl = $midtransPaymentService
                ->createSnapRedirectUrl($order);

            return redirect()->away($paymentUrl);
        } catch (\Throwable $e) {
            Log::error('Gagal membuat URL pembayaran Midtrans', [
                'order_code' => $order->order_code,
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->route('orders.success', [
                    'order_code' => $order->order_code,
                ])
                ->with(
                    'payment_error',
                    'Pembayaran belum dapat dibuka. Silakan coba lagi melalui halaman pesanan.'
                );
        }
    }

    public function success(string $order_code): View
    {
        $order = Order::query()
            ->with(['event', 'items.ticketType'])
            ->where('order_code', $order_code)
            ->firstOrFail();

        return view('orders.success', compact('order'));
    }

    public function checkStatus(string $order_code)
    {
        $order = Order::query()
            ->where('order_code', $order_code)
            ->firstOrFail();

        return response()->json([
            'status' => $order->status,
        ]);
    }
}