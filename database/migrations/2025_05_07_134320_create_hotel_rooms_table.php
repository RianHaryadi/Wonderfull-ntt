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
        Schema::create('hotel_rooms', function (Blueprint $table) {
        $table->id();
        $table->string('room_number')->unique(); // Buat unik biar tidak bentrok
        $table->string('room_type')->nullable(); // single, double, family

        // Booking Info
        $table->string('booking_number')->nullable();
        $table->string('customer_name')->nullable();
        $table->foreignId('booking_hotel_id')->nullable()->constrained('booking_hotels')->onDelete('cascade');

        // Status kamar
        $table->enum('status', ['available', 'cleaning', 'maintenance', 'not available'])->default('not available');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_rooms');
    }
};
