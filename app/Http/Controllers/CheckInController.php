<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckInController extends Controller
{
    public function index(): View
    {
        return view('check-in');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'qr_token' => ['required', 'string'],
        ]);

        $token = trim($request->input('qr_token'));

        $result = DB::transaction(function () use ($token) {
            $ticket = Ticket::query()
                ->where('qr_token_hash', hash('sha256', $token))
                ->lockForUpdate()
                ->first();

            if (!$ticket) {
                return ['result' => 'invalid'];
            }

            if ($ticket->status !== 'valid') {
                return [
                    'result' => 'used',
                    'ticket' => $ticket,
                ];
            }

            $order = $ticket->orderItem?->order;

            if (!$order || $order->status !== 'paid') {
                return ['result' => 'unpaid'];
            }

            $ticket->update([
                'status' => 'used',
                'checked_in_at' => now(),
            ]);

            return [
                'result' => 'success',
                'ticket' => $ticket,
            ];
        });

        return back()->with('checkin_result', $result);
    }
}
