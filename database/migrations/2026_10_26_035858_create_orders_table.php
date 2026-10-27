<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')
                ->constrained('events')
                ->restrictOnDelete();

            $table->string('order_code')->unique();

            $table->string('buyer_name');
            $table->string('buyer_email');
            $table->string('buyer_phone', 30)->nullable();

            $table->unsignedInteger('quantity')->default(0);
            $table->unsignedBigInteger('total_amount');

            // Contoh status: pending, paid, expired, cancelled, refunded
            $table->string('status')->default('pending');

            // Simpan hash token QR, bukan token aslinya
            $table->string('qr_token_hash', 64)->nullable()->unique();
            $table->dateTime('qr_issued_at')->nullable();

            $table->dateTime('expires_at')->nullable();
            $table->dateTime('paid_at')->nullable();

            $table->timestamps();

            $table->index(['event_id', 'status']);
            $table->index('buyer_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
