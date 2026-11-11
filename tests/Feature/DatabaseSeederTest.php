<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_seeder_creates_the_event_and_ticket_types(): void
    {
        $this->seed();

        $event = Event::query()
            ->where('slug', 'sparkling-nganjuk-carnival-5')
            ->firstOrFail();

        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'name' => 'SNC #5',
            'status' => 'published',
        ]);
        $this->assertDatabaseHas('ticket_types', [
            'event_id' => $event->id,
            'code' => 'REG',
            'name' => 'Regular',
            'price' => 12000,
            'quota' => 10,
        ]);
        $this->assertDatabaseHas('ticket_types', [
            'event_id' => $event->id,
            'code' => 'VIP',
            'name' => 'VIP',
            'price' => 20000,
            'quota' => 10,
        ]);
        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $this->assertNotNull(
            User::query()->where('email', 'test@example.com')->sole()->email_verified_at,
        );
    }

    public function test_database_seeder_can_run_more_than_once_without_duplicates(): void
    {
        $this->seed();
        $this->seed();

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseCount('events', 1);
        $this->assertDatabaseCount('ticket_types', 2);
    }
}
