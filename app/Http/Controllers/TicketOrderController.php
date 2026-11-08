<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Order;
use App\Models\TicketType;
use App\Services\QrisPaymentService;
use App\Services\TicketOrderService;
use App\Services\TicketQrService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

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
        TicketOrderService $ticketOrderService
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

        return redirect()->route('orders.payment', [
            'order_code' => $order->order_code,
        ]);
    }

    public function success(string $order_code): RedirectResponse
    {
        return redirect()->route('orders.payment', [
            'order_code' => $order_code,
        ]);
    }

    public function payment(
        string $order_code,
        QrisPaymentService $qrisPaymentService,
        TicketQrService $ticketQrService
    ): View {
        $order = Order::query()
            ->with(['event', 'items.ticketType'])
            ->where('order_code', $order_code)
            ->firstOrFail();

        $paymentQrImage = null;
        $paymentError = null;

        if ($order->status === 'pending') {
            try {
                $payload = $qrisPaymentService->createDynamicPayload($order);
                $qrisPaymentService->recordPendingPayment($order);
                $paymentQrImage = base64_encode($ticketQrService->generate($payload));
            } catch (\Throwable $e) {
                Log::error('Gagal menyiapkan pembayaran QRIS', [
                    'order_code' => $order->order_code,
                    'error' => $e->getMessage(),
                ]);

                $paymentError = 'Pembayaran QRIS belum tersedia. Silakan hubungi penyelenggara.';
            }
        }

        return view('orders.success', compact(
            'order',
            'paymentQrImage',
            'paymentError'
        ));
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
