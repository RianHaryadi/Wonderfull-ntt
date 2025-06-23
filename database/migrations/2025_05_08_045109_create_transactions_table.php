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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name')->default('Unknown');
            $table->string('customer_email')->default('example@example.com');
            $table->string('customer_phone')->default('0000000000');
            $table->decimal('base_price', 12, 2)->default(0.00);
            $table->unsignedInteger('ticket_quantity')->default(1);
            $table->string('promo_code')->nullable()->default(null);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('total_price', 12, 2)->default(0.00);
            $table->enum('payment_method', ['pending', 'transfer', 'qris', 'cash'])->default('pending');
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->dateTime('transaction_date')->nullable();
            $table->unsignedBigInteger('tour_package_id')->nullable();
            $table->foreign('tour_package_id')->references('id')->on('tour_packages')->onDelete('set null');
            $table->string('room_type')->nullable(); // single, double, family
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
