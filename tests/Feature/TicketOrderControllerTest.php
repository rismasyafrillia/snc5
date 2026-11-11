<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Order;
use App\Models\Payment;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketOrderControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_form_omits_ticket_ids_for_sold_out_ticket_types(): void
    {
        $event = Event::query()->create([
            'name' => 'SNC #5',
            'slug' => 'sparkling-nganjuk-carnival-5',
            'status' => 'published',
        ]);

        TicketType::query()->create([
            'event_id' => $event->id,
            'name' => 'Sold Out',
            'code' => 'SOLD',
            'price' => 12000,
            'quota' => 1,
            'reserved_quantity' => 1,
            'status' => 'active',
        ]);

        $this->get(route('orders.create'))
            ->assertOk()
            ->assertDontSee('name="items[0][ticket_type_id]"', false);
    }

    public function test_order_form_does_not_show_available_ticket_count(): void
    {
        $event = Event::query()->create([
            'name' => 'SNC #5',
            'slug' => 'sparkling-nganjuk-carnival-5',
            'status' => 'published',
        ]);

        TicketType::query()->create([
            'event_id' => $event->id,
            'name' => 'Regular',
            'code' => 'REG',
            'price' => 12000,
            'quota' => 10,
            'reserved_quantity' => 2,
            'sold_quantity' => 3,
            'status' => 'active',
        ]);

        $this->get(route('orders.create'))
            ->assertOk()
            ->assertDontSee('Tersedia', false)
            ->assertDontSee('5 tiket', false);
    }

    public function test_order_submission_redirects_to_payment_when_sold_out_type_is_omitted(): void
    {
        $this->travelTo('2026-11-11 12:00:00');

        $event = Event::query()->create([
            'name' => 'SNC #5',
            'slug' => 'sparkling-nganjuk-carnival-5',
            'status' => 'published',
        ]);

        $availableTicket = TicketType::query()->create([
            'event_id' => $event->id,
            'name' => 'Regular',
            'code' => 'REG',
            'price' => 12000,
            'quota' => 10,
            'status' => 'active',
        ]);
        $zeroQuantityTicket = TicketType::query()->create([
            'event_id' => $event->id,
            'name' => 'VIP',
            'code' => 'VIP',
            'price' => 20000,
            'quota' => 10,
            'status' => 'active',
        ]);
        TicketType::query()->create([
            'event_id' => $event->id,
            'name' => 'Sold Out',
            'code' => 'SOLD',
            'price' => 30000,
            'quota' => 1,
            'reserved_quantity' => 1,
            'status' => 'active',
        ]);

        $this->post(route('orders.store'), [
            'event_id' => $event->id,
            'buyer_name' => 'Buyer',
            'buyer_email' => 'buyer@example.com',
            'buyer_phone' => '0811111111',
            'items' => [
                [
                    'ticket_type_id' => $availableTicket->id,
                    'quantity' => 1,
                ],
                [
                    'ticket_type_id' => $zeroQuantityTicket->id,
                    'quantity' => 0,
                ],
            ],
        ])
            ->assertRedirect(route('orders.payment', [
                'order_code' => Order::query()->sole()->order_code,
            ]));

        $order = Order::query()->sole();

        $this->assertSame('pending', $order->status);
        $this->assertSame('62811111111', $order->buyer_phone_normalized);
        $this->assertSame('2026-11-11 12:15:00', $order->expires_at->format('Y-m-d H:i:s'));
    }

    public function test_order_submission_rejects_a_second_pending_transaction_for_the_same_whatsapp_number(): void
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
            'status' => 'active',
        ]);
        $data = [
            'event_id' => $event->id,
            'buyer_name' => 'Buyer',
            'buyer_email' => 'buyer@example.com',
            'buyer_phone' => '081234567890',
            'items' => [
                [
                    'ticket_type_id' => $ticketType->id,
                    'quantity' => 1,
                ],
            ],
        ];

        $this->post(route('orders.store'), $data)->assertSessionHasNoErrors();

        $this->post(route('orders.store'), array_merge($data, [
            'buyer_phone' => '+62 812-3456-7890',
        ]))
            ->assertSessionHasErrors([
                'buyer_phone' => 'Nomor WhatsApp ini masih memiliki transaksi yang menunggu pembayaran.',
            ]);

        $this->assertDatabaseCount('orders', 1);
        $this->assertSame(1, $ticketType->fresh()->reserved_quantity);
    }

    public function test_order_submission_requires_a_whatsapp_number(): void
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
            'status' => 'active',
        ]);

        $this->post(route('orders.store'), [
            'event_id' => $event->id,
            'buyer_name' => 'Buyer',
            'buyer_email' => 'buyer@example.com',
            'items' => [
                [
                    'ticket_type_id' => $ticketType->id,
                    'quantity' => 1,
                ],
            ],
        ])
            ->assertSessionHasErrors([
                'buyer_phone' => 'Nomor WhatsApp wajib diisi.',
            ]);

        $this->assertDatabaseCount('orders', 0);
        $this->assertSame(0, $ticketType->fresh()->reserved_quantity);
    }

    public function test_expired_transaction_releases_reserved_tickets_and_allows_a_new_transaction(): void
    {
        $this->travelTo('2026-11-11 12:00:00');

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
            'status' => 'active',
        ]);
        $data = [
            'event_id' => $event->id,
            'buyer_name' => 'Buyer',
            'buyer_email' => 'buyer@example.com',
            'buyer_phone' => '081234567890',
            'items' => [
                [
                    'ticket_type_id' => $ticketType->id,
                    'quantity' => 1,
                ],
            ],
        ];

        $this->post(route('orders.store'), $data)->assertSessionHasNoErrors();
        $order = Order::query()->sole();
        Payment::query()->create([
            'order_id' => $order->id,
            'provider' => 'qris',
            'provider_order_id' => $order->order_code,
            'transaction_status' => 'pending',
            'gross_amount' => 12000,
        ]);

        $this->travelTo('2026-11-11 12:15:00');

        $this->artisan('orders:expire-pending')->assertSuccessful();

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'expired',
        ]);
        $this->assertDatabaseHas('payments', [
            'order_id' => $order->id,
            'transaction_status' => 'expired',
        ]);
        $this->assertSame(0, $ticketType->fresh()->reserved_quantity);
        $this->assertSame(0, $ticketType->fresh()->sold_quantity);

        $this->get(route('orders.status', ['order_code' => $order->order_code]))
            ->assertOk()
            ->assertExactJson(['status' => 'expired']);

        $this->get(route('orders.payment', ['order_code' => $order->order_code]))
            ->assertOk()
            ->assertSee('Pesanan <em>Kedaluwarsa</em>', false)
            ->assertSee('Batas pembayaran 15 menit telah berakhir');

        $this->post(route('orders.store'), $data)->assertSessionHasNoErrors();

        $this->assertDatabaseCount('orders', 2);
        $newOrder = Order::query()->where('status', 'pending')->sole();
        $this->assertSame('pending', $newOrder->status);
        $this->assertSame(1, $ticketType->fresh()->reserved_quantity);

        config(['services.qris.merchant_payload' => null]);

        $this->get(route('orders.payment', ['order_code' => $newOrder->order_code]))
            ->assertOk()
            ->assertSee('id="payment-countdown"', false)
            ->assertSee('data-expires-at="'.$newOrder->expires_at->timestamp.'"', false)
            ->assertSee('window.setInterval(updatePaymentCountdown, 1000)', false)
            ->assertSee('window.location.reload()', false)
            ->assertSee('href="https://wa.me/6287857242184?text=', false)
            ->assertSee(rawurlencode('Kode pesanan: '.$newOrder->order_code), false)
            ->assertSee(rawurlencode('Nama pemesan: Buyer'), false)
            ->assertSee(rawurlencode('Total: Rp12.000'), false)
            ->assertSee('class="payment-whatsapp-btn"', false)
            ->assertSee('Konfirmasi pembayaran via WhatsApp')
            ->assertSee('Batas waktu:')
            ->assertSee('19:30 WIB');
    }

    public function test_admin_dashboard_shows_sold_and_remaining_ticket_counts(): void
    {
        $event = Event::query()->create([
            'name' => 'SNC #5',
            'slug' => 'sparkling-nganjuk-carnival-5',
            'status' => 'published',
        ]);
        TicketType::query()->create([
            'event_id' => $event->id,
            'name' => 'Regular',
            'code' => 'REG',
            'price' => 12000,
            'quota' => 10,
            'reserved_quantity' => 2,
            'sold_quantity' => 3,
            'status' => 'active',
        ]);
        $admin = User::factory()->create();
        $admin->forceFill(['role' => 'admin'])->save();

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Terjual:')
            ->assertSee('Tersisa:')
            ->assertSee('<strong>3</strong>', false)
            ->assertSee('<strong>5</strong>', false);
    }

    public function test_admin_dashboard_shows_order_whatsapp_and_live_clock(): void
    {
        $this->travelTo('2026-11-22 12:00:00');

        $event = Event::query()->create([
            'name' => 'SNC #5',
            'slug' => 'sparkling-nganjuk-carnival-5',
            'status' => 'published',
        ]);
        Order::query()->create([
            'event_id' => $event->id,
            'order_code' => 'SNC-WA-ORDER',
            'buyer_name' => 'Buyer',
            'buyer_email' => 'buyer@example.com',
            'buyer_phone' => '08123456789',
            'quantity' => 1,
            'total_amount' => 12000,
            'status' => 'pending',
            'expires_at' => '2026-11-22 12:15:00',
        ]);
        Order::query()->create([
            'event_id' => $event->id,
            'order_code' => 'SNC-EXPIRED-ORDER',
            'buyer_name' => 'Expired Buyer',
            'buyer_email' => 'expired@example.com',
            'buyer_phone' => '0811111112',
            'quantity' => 1,
            'total_amount' => 12000,
            'status' => 'expired',
        ]);
        $admin = User::factory()->create();
        $admin->forceFill(['role' => 'admin'])->save();

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('08123456789')
            ->assertSee('Transaksi Kedaluwarsa')
            ->assertSee('SNC-EXPIRED-ORDER')
            ->assertSee('Konfirmasi terlambat')
            ->assertSee('Dana sudah diverifikasi')
            ->assertSee('data-payment-countdown="'.strtotime('2026-11-22 12:15:00').'"', false)
            ->assertSee('22 Nov 2026 19:00 WIB')
            ->assertSee('data-payment-countdown', false)
            ->assertSee('window.setInterval(updatePaymentCountdowns, 1000)', false)
            ->assertSee('dashboardClock', false);
    }
}
