<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('buyer_phone_normalized', 30)
                ->nullable()
                ->after('buyer_phone');
            $table->index(
                ['buyer_phone_normalized', 'status', 'expires_at'],
                'orders_phone_status_expires_index'
            );
        });

        DB::table('orders')
            ->whereNotNull('buyer_phone')
            ->orderBy('id')
            ->chunkById(500, function ($orders): void {
                foreach ($orders as $order) {
                    $digits = preg_replace('/\D+/', '', $order->buyer_phone) ?? '';

                    if (str_starts_with($digits, '00')) {
                        $digits = substr($digits, 2);
                    }

                    if (str_starts_with($digits, '0')) {
                        $digits = '62'.substr($digits, 1);
                    } elseif (str_starts_with($digits, '8')) {
                        $digits = '62'.$digits;
                    }

                    DB::table('orders')
                        ->where('id', $order->id)
                        ->update([
                            'buyer_phone_normalized' => preg_match('/^[1-9]\d{7,14}$/', $digits) === 1
                                ? $digits
                                : null,
                        ]);
                }
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex('orders_phone_status_expires_index');
            $table->dropColumn('buyer_phone_normalized');
        });
    }
};
