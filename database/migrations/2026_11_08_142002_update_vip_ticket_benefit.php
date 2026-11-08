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
            ->where('name', 'VIP')
            ->update([
                'description' => 'Mendapatkan snack box.',
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
                'description' => 'Benefit mengikuti ketentuan resmi acara.',
                'updated_at' => now(),
            ]);
    }
};
