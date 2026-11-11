<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Seed the SNC #5 event and its ticket types.
     */
    public function run(): void
    {
        $event = Event::query()->firstOrCreate(
            ['slug' => 'sparkling-nganjuk-carnival-5'],
            [
                'name' => 'SNC #5',
                'status' => 'published',
            ],
        );

        $event->ticketTypes()->firstOrCreate(
            ['code' => 'REG'],
            [
                'name' => 'Regular',
                'price' => 12000,
                'quota' => 10,
                'status' => 'active',
            ],
        );

        $event->ticketTypes()->firstOrCreate(
            ['code' => 'VIP'],
            [
                'name' => 'VIP',
                'price' => 20000,
                'quota' => 10,
                'status' => 'active',
            ],
        );
    }
}
