<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\User;
use App\Services\QrisPaymentService;
use App\Services\TicketIssuanceService;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    public function login(): View
    {
        return view('admin.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => 'Email atau password tidak sesuai.',
            ]);
        }

        $request->session()->regenerate();

        if (Auth::user()->role !== 'admin') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'Akun ini tidak memiliki akses admin.',
            ]);
        }

        return redirect()->route('admin.dashboard');
    }

    public function dashboard(): View
    {
        $event = Event::query()
            ->where('slug', 'sparkling-nganjuk-carnival-5')
            ->firstOrFail();

        $ticketTypes = $event->ticketTypes()
            ->orderBy('price', 'desc')
            ->get();

        $pendingOrders = Order::query()
            ->where('event_id', $event->id)
            ->where('status', 'pending')
            ->with(['items.ticketType', 'payments'])
            ->oldest()
            ->get();

        $confirmedOrders = Order::query()
            ->where('event_id', $event->id)
            ->where('status', 'paid')
            ->whereHas('payments', function ($query) {
                $query->where('provider', 'qris')
                    ->where('transaction_status', 'paid');
            })
            ->with([
                'items.ticketType',
                'payments' => function ($query) {
                    $query->where('provider', 'qris')
                        ->where('transaction_status', 'paid');
                },
            ])
            ->latest('paid_at')
            ->get();

        $confirmedAdminIds = $confirmedOrders
            ->flatMap(fn (Order $order) => $order->payments->map(
                fn (Payment $payment) => data_get($payment->raw_status, 'confirmed_by')
            ))
            ->filter()
            ->unique()
            ->values();

        $confirmedAdminNames = User::query()
            ->whereKey($confirmedAdminIds)
            ->pluck('name', 'id');

        $confirmedOrders = $confirmedOrders->map(function (Order $order) use ($confirmedAdminNames) {
            $payment = $order->payments->first();
            $confirmedBy = data_get($payment?->raw_status, 'confirmed_by');
            $confirmedAt = data_get($payment?->raw_status, 'confirmed_at')
                ?? $payment?->paid_at;

            return [
                'order' => $order,
                'admin_name' => $confirmedAdminNames->get($confirmedBy, 'Tidak tercatat'),
                'confirmed_at' => $confirmedAt
                    ? Carbon::parse($confirmedAt)
                    : null,
            ];
        });

        $checkedInTickets = $this->checkedInTicketsForEvent($event);

        return view('admin.dashboard', compact(
            'event',
            'ticketTypes',
            'pendingOrders',
            'confirmedOrders',
            'checkedInTickets'
        ));
    }

    public function exportCheckedInTickets(): StreamedResponse
    {
        $event = Event::query()
            ->where('slug', 'sparkling-nganjuk-carnival-5')
            ->firstOrFail();

        $tickets = $this->checkedInTicketsForEvent($event);

        $filename = 'tiket-check-in-'.now('Asia/Jakarta')->format('Ymd-His').'.csv';

        return response()->streamDownload(function () use ($tickets): void {
            $stream = fopen('php://output', 'wb');
            fwrite($stream, "\xEF\xBB\xBF");
            fputcsv($stream, [
                'Kode Tiket',
                'Kode Pesanan',
                'Nama Pemesan',
                'WhatsApp',
                'Email',
                'Kategori Tiket',
                'Waktu Check-In (WIB)',
            ], ',', '"', '\\');

            foreach ($tickets as $ticket) {
                $orderItem = $ticket->orderItem;
                $order = $orderItem->order;

                fputcsv($stream, [
                    $this->spreadsheetText($ticket->ticket_code),
                    $this->spreadsheetText($order->order_code),
                    $this->spreadsheetText($order->buyer_name),
                    $this->spreadsheetPhone($order->buyer_phone),
                    $this->spreadsheetText($order->buyer_email),
                    $this->spreadsheetText($orderItem->ticketType->name),
                    $ticket->checked_in_at->timezone('Asia/Jakarta')->format('d/m/Y H:i'),
                ], ',', '"', '\\');
            }

            fclose($stream);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    private function checkedInTicketsForEvent(Event $event): EloquentCollection
    {
        return Ticket::query()
            ->where('status', 'used')
            ->whereNotNull('checked_in_at')
            ->whereHas('orderItem.order', function ($query) use ($event) {
                $query->where('event_id', $event->id)
                    ->where('status', 'paid');
            })
            ->with(['orderItem.order', 'orderItem.ticketType'])
            ->latest('checked_in_at')
            ->get();
    }

    private function spreadsheetText(string $value): string
    {
        return preg_match('/^[\t\r\n ]*[=+\-@]/', $value) === 1
            ? "'".$value
            : $value;
    }

    private function spreadsheetPhone(?string $phone): string
    {
        $phone = trim($phone ?? '');

        if (preg_match('/^0[0-9]+$/', $phone) === 1) {
            return '="'.$phone.'"';
        }

        return $this->spreadsheetText($phone);
    }

    public function updateTicket(Request $request, TicketType $ticketType): RedirectResponse
    {
        $data = $request->validate([
            'quota' => ['required', 'integer', 'min:0'],
            'price' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        if (
            $data['quota'] <
            ($ticketType->reserved_quantity + $ticketType->sold_quantity)
        ) {
            return back()->withErrors([
                'quota' => 'Kuota tidak boleh lebih kecil daripada jumlah tiket yang sudah dipesan dan terjual.',
            ]);
        }

        $ticketType->update($data);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Pengaturan tiket berhasil diperbarui.');
    }

    public function confirmPayment(
        Order $order,
        QrisPaymentService $qrisPaymentService,
        TicketIssuanceService $ticketIssuanceService
    ): RedirectResponse {
        try {
            $orderId = $qrisPaymentService->confirmPayment(
                $order->id,
                (int) Auth::id()
            );
        } catch (\Throwable $e) {
            Log::error('Gagal mengonfirmasi pembayaran QRIS', [
                'order_code' => $order->order_code,
                'admin_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);

            return back()->withErrors([
                'payment' => 'Pembayaran tidak dapat dikonfirmasi. Periksa status pesanan dan reservasi tiket.',
            ]);
        }

        try {
            $ticketIssuanceService->issueAndSend($orderId);
        } catch (\Throwable $e) {
            Log::error('Pembayaran QRIS terkonfirmasi tetapi email tiket gagal dikirim', [
                'order_code' => $order->order_code,
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->route('admin.dashboard')
                ->with('success', 'Pembayaran dikonfirmasi, tetapi email tiket gagal dikirim. Periksa log aplikasi.');
        }

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Pembayaran dikonfirmasi dan tiket telah diterbitkan.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
