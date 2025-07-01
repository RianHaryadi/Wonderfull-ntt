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
            $table->string('booking_code')->unique();

            // Customer info
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');

            // Tour Package relation
            $table->foreignId('tour_package_id')->nullable()->constrained();
            $table->foreignId('destination_id')->nullable()->constrained()->nullOnDelete();

            //diskon
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->decimal('discount_percent', 5, 2)->nullable();

            // Booking details
            $table->dateTime('booking_date');
            $table->integer('number_of_tickets');

            // Pricing
            $table->decimal('package_price', 12, 2);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('total_price', 12, 2);

            // Payment
            $table->enum('payment_method', ['transfer', 'qris', 'cash'])->nullable();
            $table->enum('status', ['pending', 'paid', 'confirmed', 'completed', 'cancelled', 'expired'])->default('pending');

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
