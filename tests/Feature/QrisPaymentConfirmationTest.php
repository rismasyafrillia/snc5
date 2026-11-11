<?php

namespace Tests\Feature;

use App\Mail\TicketConfirmationMail;
use App\Models\Event;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\User;
use App\Services\QrisPaymentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class QrisPaymentConfirmationTest extends TestCase
{
    use RefreshDatabase;

    public function test_ticket_confirmation_email_displays_swatantra_wordmark(): void
    {
        $email = (new TicketConfirmationMail(new Order, []))->render();

        $this->assertStringContainsString('Ticketing by', $email);
        $this->assertStringContainsString('SWATANTRA', $email);
        $this->assertStringNotContainsString('data:image/jpeg;base64,', $email);
        $this->assertStringContainsString('Penukaran tiket', $email);
        $this->assertStringContainsString('12.00–19.00 WIB', $email);
        $this->assertStringContainsString('Stadion Anjuk Ladang', $email);
    }

    public function test_guest_cannot_download_check_in_export(): void
    {
        $this->get(route('admin.check-ins.export'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_admin_confirmation_marks_payment_paid_and_moves_reserved_tickets_to_sold(): void
    {
        $event = Event::query()->create([
            'name' => 'SNC #5',
            'slug' => 'snc-5',
            'status' => 'published',
        ]);
        $ticketType = TicketType::query()->create([
            'event_id' => $event->id,
            'name' => 'Regular',
            'code' => 'REG',
            'price' => 12000,
            'quota' => 10,
            'reserved_quantity' => 2,
            'sold_quantity' => 0,
            'status' => 'active',
        ]);
        $order = Order::query()->create([
            'event_id' => $event->id,
            'order_code' => 'SNC-TEST-ORDER',
            'buyer_name' => 'Buyer',
            'buyer_email' => 'buyer@example.com',
            'quantity' => 2,
            'total_amount' => 24000,
            'status' => 'pending',
        ]);
        $order->items()->create([
            'ticket_type_id' => $ticketType->id,
            'quantity' => 2,
            'unit_price' => 12000,
            'subtotal' => 24000,
        ]);

        $service = app(QrisPaymentService::class);
        $service->confirmPayment($order->id, 7);
        $service->confirmPayment($order->id, 7);

        $this->assertSame('paid', $order->fresh()->status);
        $this->assertSame(0, $ticketType->fresh()->reserved_quantity);
        $this->assertSame(2, $ticketType->fresh()->sold_quantity);
        $this->assertSame('qris', Payment::query()->sole()->provider);
        $this->assertSame('paid', Payment::query()->sole()->transaction_status);
        $this->assertSame(7, Payment::query()->sole()->raw_status['confirmed_by']);
    }

    public function test_admin_cannot_confirm_payment_after_the_fifteen_minute_deadline(): void
    {
        $this->travelTo('2026-11-11 12:15:00');

        $event = Event::query()->create([
            'name' => 'SNC #5',
            'slug' => 'snc-5-expired',
            'status' => 'published',
        ]);
        $ticketType = TicketType::query()->create([
            'event_id' => $event->id,
            'name' => 'Regular',
            'code' => 'REG',
            'price' => 12000,
            'quota' => 10,
            'reserved_quantity' => 1,
            'sold_quantity' => 0,
            'status' => 'active',
        ]);
        $order = Order::query()->create([
            'event_id' => $event->id,
            'order_code' => 'SNC-EXPIRED-ORDER',
            'buyer_name' => 'Buyer',
            'buyer_email' => 'buyer@example.com',
            'quantity' => 1,
            'total_amount' => 12000,
            'status' => 'pending',
            'expires_at' => '2026-11-11 12:15:00',
        ]);
        $order->items()->create([
            'ticket_type_id' => $ticketType->id,
            'quantity' => 1,
            'unit_price' => 12000,
            'subtotal' => 12000,
        ]);
        Payment::query()->create([
            'order_id' => $order->id,
            'provider' => 'qris',
            'provider_order_id' => $order->order_code,
            'transaction_status' => 'pending',
            'gross_amount' => 12000,
        ]);
        $admin = User::factory()->create();
        $admin->forceFill(['role' => 'admin'])->save();

        $this->from(route('admin.dashboard'))
            ->actingAs($admin)
            ->post(route('admin.orders.confirm-payment', $order))
            ->assertRedirect(route('admin.dashboard'))
            ->assertSessionHasErrors('payment');

        $this->assertSame('expired', $order->fresh()->status);
        $this->assertSame('expired', Payment::query()->sole()->transaction_status);
        $this->assertSame(0, $ticketType->fresh()->reserved_quantity);
        $this->assertDatabaseCount('tickets', 0);
    }

    public function test_admin_can_confirm_a_late_payment_after_verifying_funds_and_available_quota(): void
    {
        [$order, $ticketType] = $this->createExpiredOrder(quantity: 2);
        $admin = User::factory()->create();
        $admin->forceFill(['role' => 'admin'])->save();
        Mail::fake();

        $this->from(route('admin.dashboard'))
            ->actingAs($admin)
            ->post(route('admin.orders.confirm-expired-payment', $order), [
                'payment_verified' => '1',
            ])
            ->assertRedirect(route('admin.dashboard'))
            ->assertSessionHas(
                'success',
                'Pembayaran terlambat dikonfirmasi dan tiket telah diterbitkan.'
            );

        $payment = Payment::query()->sole();

        $this->assertSame('paid', $order->fresh()->status);
        $this->assertSame(2, $ticketType->fresh()->sold_quantity);
        $this->assertSame(0, $ticketType->fresh()->reserved_quantity);
        $this->assertSame('paid', $payment->transaction_status);
        $this->assertSame('manual_late_override', $payment->raw_status['confirmation_method']);
        $this->assertSame($admin->id, $payment->raw_status['confirmed_by']);
        $this->assertDatabaseCount('tickets', 2);
        Mail::assertSent(TicketConfirmationMail::class);
    }

    public function test_admin_cannot_override_an_expired_payment_when_ticket_quota_is_no_longer_available(): void
    {
        [$order, $ticketType] = $this->createExpiredOrder(quota: 1, soldQuantity: 1);
        $admin = User::factory()->create();
        $admin->forceFill(['role' => 'admin'])->save();

        $this->from(route('admin.dashboard'))
            ->actingAs($admin)
            ->post(route('admin.orders.confirm-expired-payment', $order), [
                'payment_verified' => '1',
            ])
            ->assertRedirect(route('admin.dashboard'))
            ->assertSessionHasErrors([
                'payment' => 'Kuota tiket tidak lagi mencukupi. Pesanan tidak dikonfirmasi agar tidak terjadi penjualan melebihi kuota.',
            ]);

        $this->assertSame('expired', $order->fresh()->status);
        $this->assertSame(1, $ticketType->fresh()->sold_quantity);
        $this->assertSame('expired', Payment::query()->sole()->transaction_status);
        $this->assertDatabaseCount('tickets', 0);
    }

    public function test_admin_must_acknowledge_payment_verification_before_late_confirmation(): void
    {
        [$order, $ticketType] = $this->createExpiredOrder();
        $admin = User::factory()->create();
        $admin->forceFill(['role' => 'admin'])->save();

        $this->from(route('admin.dashboard'))
            ->actingAs($admin)
            ->post(route('admin.orders.confirm-expired-payment', $order))
            ->assertRedirect(route('admin.dashboard'))
            ->assertSessionHasErrors([
                'payment_verified' => 'Konfirmasi bahwa dana sudah diverifikasi di riwayat transaksi merchant.',
            ]);

        $this->assertSame('expired', $order->fresh()->status);
        $this->assertSame(0, $ticketType->fresh()->sold_quantity);
        $this->assertSame('expired', Payment::query()->sole()->transaction_status);
        $this->assertDatabaseCount('tickets', 0);
    }

    public function test_admin_can_confirm_from_the_dashboard_and_issue_tickets(): void
    {
        $event = Event::query()->create([
            'name' => 'SNC #5',
            'slug' => 'sparkling-nganjuk-carnival-5',
            'status' => 'published',
        ]);
        $ticketType = TicketType::query()->create([
            'event_id' => $event->id,
            'name' => 'Regular',
            'code' => 'REG',
            'price' => 12000,
            'quota' => 10,
            'reserved_quantity' => 2,
            'sold_quantity' => 0,
            'status' => 'active',
        ]);
        $order = Order::query()->create([
            'event_id' => $event->id,
            'order_code' => 'SNC-ADMIN-ORDER',
            'buyer_name' => 'Buyer',
            'buyer_email' => 'buyer@example.com',
            'quantity' => 2,
            'total_amount' => 24000,
            'status' => 'pending',
        ]);
        $order->items()->create([
            'ticket_type_id' => $ticketType->id,
            'quantity' => 2,
            'unit_price' => 12000,
            'subtotal' => 24000,
        ]);

        $admin = User::factory()->create();
        $admin->forceFill(['role' => 'admin'])->save();
        Mail::fake();

        $this->actingAs($admin)
            ->post(route('admin.orders.confirm-payment', $order))
            ->assertRedirect(route('admin.dashboard'))
            ->assertSessionHas('success', 'Pembayaran dikonfirmasi dan tiket telah diterbitkan.');

        $this->assertSame('paid', $order->fresh()->status);
        $this->assertDatabaseCount('tickets', 2);
        Mail::assertSent(TicketConfirmationMail::class);
    }

    public function test_admin_dashboard_shows_confirmed_order_and_admin_name(): void
    {
        $event = Event::query()->create([
            'name' => 'SNC #5',
            'slug' => 'sparkling-nganjuk-carnival-5',
            'status' => 'published',
        ]);
        $admin = User::factory()->create([
            'name' => 'Admin Konfirmasi',
        ]);
        $admin->forceFill(['role' => 'admin'])->save();
        $order = Order::query()->create([
            'event_id' => $event->id,
            'order_code' => 'SNC-CONFIRMED-ORDER',
            'buyer_name' => 'Buyer',
            'buyer_email' => 'buyer@example.com',
            'quantity' => 1,
            'total_amount' => 24000,
            'status' => 'paid',
            'paid_at' => '2026-11-08 12:34:00',
        ]);
        Payment::query()->create([
            'order_id' => $order->id,
            'provider' => 'qris',
            'provider_order_id' => $order->order_code,
            'payment_type' => 'QRIS',
            'transaction_status' => 'paid',
            'gross_amount' => 24000,
            'raw_status' => [
                'confirmation_method' => 'manual',
                'confirmed_by' => $admin->id,
                'confirmed_at' => '2026-11-08T12:34:00+00:00',
            ],
            'paid_at' => '2026-11-08 12:34:00',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('SNC-CONFIRMED-ORDER')
            ->assertSee('Admin Konfirmasi')
            ->assertSee('08 Nov 2026 19:34 WIB');
    }

    public function test_admin_can_download_checked_in_tickets_as_csv(): void
    {
        $event = Event::query()->create([
            'name' => 'SNC #5',
            'slug' => 'sparkling-nganjuk-carnival-5',
            'status' => 'published',
        ]);
        $admin = User::factory()->create(['name' => 'Admin Check In']);
        $admin->forceFill(['role' => 'admin'])->save();
        $ticketType = TicketType::query()->create([
            'event_id' => $event->id,
            'name' => 'VIP',
            'code' => 'VIP',
            'price' => 50000,
            'quota' => 10,
            'status' => 'active',
        ]);
        $order = Order::query()->create([
            'event_id' => $event->id,
            'order_code' => 'SNC-CHECKIN-ORDER',
            'buyer_name' => 'Buyer Check In',
            'buyer_email' => 'checkin@example.com',
            'buyer_phone' => '08123456789',
            'quantity' => 2,
            'total_amount' => 100000,
            'status' => 'paid',
        ]);
        $orderItem = $order->items()->create([
            'ticket_type_id' => $ticketType->id,
            'quantity' => 2,
            'unit_price' => 50000,
            'subtotal' => 100000,
        ]);
        Ticket::query()->create([
            'order_item_id' => $orderItem->id,
            'ticket_code' => 'SNC-CHECKED-IN',
            'qr_token_hash' => hash('sha256', 'checked-in-token'),
            'qr_token' => 'checked-in-token',
            'status' => 'used',
            'checked_in_at' => '2026-11-21 12:30:00',
        ]);
        Ticket::query()->create([
            'order_item_id' => $orderItem->id,
            'ticket_code' => 'SNC-NOT-CHECKED-IN',
            'qr_token_hash' => hash('sha256', 'unused-token'),
            'qr_token' => 'unused-token',
            'status' => 'valid',
        ]);

        $response = $this->actingAs($admin)
            ->get(route('admin.check-ins.export'))
            ->assertOk()
            ->assertStreamed()
            ->assertHeader('content-type', 'text/csv; charset=UTF-8');

        $csv = $response->streamedContent();
        $this->assertStringContainsString('SNC-CHECKED-IN', $csv);
        $this->assertStringContainsString('SNC-CHECKIN-ORDER', $csv);
        $this->assertStringContainsString('VIP', $csv);
        $this->assertStringContainsString('21/11/2026 19:30', $csv);
        $this->assertStringNotContainsString('SNC-NOT-CHECKED-IN', $csv);
    }

    public function test_admin_dashboard_lists_checked_in_barcodes_only(): void
    {
        $event = Event::query()->create([
            'name' => 'SNC #5',
            'slug' => 'sparkling-nganjuk-carnival-5',
            'status' => 'published',
        ]);
        $admin = User::factory()->create(['role' => 'admin']);
        $ticketType = TicketType::query()->create([
            'event_id' => $event->id,
            'name' => 'VIP',
            'code' => 'VIP',
            'price' => 50000,
            'quota' => 10,
            'status' => 'active',
        ]);
        $order = Order::query()->create([
            'event_id' => $event->id,
            'order_code' => 'SNC-CHECKIN-ORDER',
            'buyer_name' => 'Buyer Check In',
            'buyer_email' => 'checkin@example.com',
            'buyer_phone' => '08123456789',
            'quantity' => 2,
            'total_amount' => 100000,
            'status' => 'paid',
        ]);
        $orderItem = $order->items()->create([
            'ticket_type_id' => $ticketType->id,
            'quantity' => 2,
            'unit_price' => 50000,
            'subtotal' => 100000,
        ]);
        Ticket::query()->create([
            'order_item_id' => $orderItem->id,
            'ticket_code' => 'SNC-CHECKED-IN',
            'qr_token_hash' => hash('sha256', 'checked-in-dashboard-token'),
            'qr_token' => 'checked-in-dashboard-token',
            'status' => 'used',
            'checked_in_at' => '2026-11-21 12:30:00',
        ]);
        Ticket::query()->create([
            'order_item_id' => $orderItem->id,
            'ticket_code' => 'SNC-NOT-CHECKED-IN',
            'qr_token_hash' => hash('sha256', 'unused-dashboard-token'),
            'qr_token' => 'unused-dashboard-token',
            'status' => 'valid',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('role="tablist"', false)
            ->assertSee('data-admin-tab="konfirmasi"', false)
            ->assertSee('data-admin-tab="checkin"', false)
            ->assertSee('data-admin-tab="tiket"', false)
            ->assertSee('id="admin-panel-checkin"', false)
            ->assertSee('SNC-CHECKED-IN')
            ->assertSee('Buyer Check In')
            ->assertSee('08123456789')
            ->assertSee('21 Nov 2026 19:30 WIB')
            ->assertDontSee('SNC-NOT-CHECKED-IN');
    }

    /**
     * @return array{Order, TicketType}
     */
    private function createExpiredOrder(
        int $quantity = 1,
        int $quota = 10,
        int $soldQuantity = 0
    ): array {
        $event = Event::query()->create([
            'name' => 'SNC #5',
            'slug' => 'snc-expired-'.$quantity.'-'.$quota.'-'.$soldQuantity,
            'status' => 'published',
        ]);
        $ticketType = TicketType::query()->create([
            'event_id' => $event->id,
            'name' => 'Regular',
            'code' => 'REG',
            'price' => 12000,
            'quota' => $quota,
            'reserved_quantity' => 0,
            'sold_quantity' => $soldQuantity,
            'status' => 'active',
        ]);
        $order = Order::query()->create([
            'event_id' => $event->id,
            'order_code' => 'SNC-LATE-'.$quantity.'-'.$quota.'-'.$soldQuantity,
            'buyer_name' => 'Buyer',
            'buyer_email' => 'buyer@example.com',
            'quantity' => $quantity,
            'total_amount' => 12000 * $quantity,
            'status' => 'expired',
        ]);
        $order->items()->create([
            'ticket_type_id' => $ticketType->id,
            'quantity' => $quantity,
            'unit_price' => 12000,
            'subtotal' => 12000 * $quantity,
        ]);
        Payment::query()->create([
            'order_id' => $order->id,
            'provider' => 'qris',
            'provider_order_id' => $order->order_code,
            'transaction_status' => 'expired',
            'gross_amount' => 12000 * $quantity,
            'raw_status' => ['expired_at' => now()->toISOString()],
        ]);

        return [$order, $ticketType];
    }
}
