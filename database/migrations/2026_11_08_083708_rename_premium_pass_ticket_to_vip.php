<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('ticket_types')
            ->where('code', 'PREMIUM')
            ->where('name', 'Premium Pass')
            ->update([
                'name' => 'VIP',
                'updated_at' => now(),
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('ticket_types')
            ->where('code', 'PREMIUM')
            ->where('name', 'VIP')
            ->update([
                'name' => 'Premium Pass',
                'updated_at' => now(),
            ]);
    }
};
