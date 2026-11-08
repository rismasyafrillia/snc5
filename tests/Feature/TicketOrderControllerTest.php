<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Order;
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

        $this->assertSame('pending', Order::query()->sole()->status);
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
        ]);
        $admin = User::factory()->create();
        $admin->forceFill(['role' => 'admin'])->save();

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('08123456789')
            ->assertSee('dashboardClock', false);
    }
}
