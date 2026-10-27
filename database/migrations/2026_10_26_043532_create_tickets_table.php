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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
             $table->foreignId('order_item_id')
                ->constrained('order_items')
                ->restrictOnDelete();

            $table->string('ticket_code')->unique();

            // Simpan hash token QR, bukan token aslinya
            $table->string('qr_token_hash', 64)->unique();

            // valid, used, cancelled
            $table->string('status')->default('valid');

            $table->dateTime('checked_in_at')->nullable();

            $table->timestamps();

            $table->index(['order_item_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
