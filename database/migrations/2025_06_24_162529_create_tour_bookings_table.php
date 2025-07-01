<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tour_bookings', function (Blueprint $table) {
            $table->id();

            // Relasi ke paket tour & hotel (opsional)
            $table->foreignId('tour_package_id')->constrained()->onDelete('cascade');
            $table->foreignId('hotel_id')->nullable()->constrained()->onDelete('set null');

            // Informasi pelanggan
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');

            // Harga
            $table->decimal('tour_price', 12, 2);
            $table->decimal('hotel_price', 12, 2)->default(0);
            $table->decimal('total_price', 12, 2);

            // Status & metode pembayaran
            $table->string('status')->default('pending'); // pending | confirmed | completed | cancelled
            $table->string('payment_method')->nullable(); // qris, transfer, dll

            // Booking number unik
            $table->string('booking_number')->unique();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_bookings');
    }
};
