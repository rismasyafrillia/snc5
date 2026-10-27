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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();

            $table->string('provider')->default('midtrans');
            $table->string('provider_order_id')->unique();
            $table->string('transaction_id')->nullable();

            $table->string('payment_type')->nullable();
            $table->string('transaction_status')->default('pending');
            $table->unsignedBigInteger('gross_amount');

            $table->json('raw_status')->nullable();
            $table->dateTime('paid_at')->nullable();

            $table->timestamps();

            $table->index(['order_id', 'transaction_status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
