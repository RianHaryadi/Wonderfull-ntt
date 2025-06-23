<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('booking_hotels', function (Blueprint $table) {
            $table->id();

            // Foreign key ke tabel hotels
            $table->foreignId('hotel_id')->constrained()->onDelete('cascade');

            // Data pelanggan
            $table->string('customer_name', 255)->default('Unknown');
            $table->string('customer_email', 255)->default('example@example.com');
            $table->string('customer_phone', 20)->default('0000000000');

            // Tanggal check-in dan check-out (nullable)
            $table->date('check_in_date')->nullable();
            $table->date('check_out_date')->nullable();

            // Status booking
            $table->enum('status', ['pending', 'checked-in', 'checked-out', 'failed'])->default('pending');

            // Harga dan biaya tambahan
            $table->decimal('room_price', 10, 2)->default(0.00);
            $table->decimal('tax', 10, 2)->default(0.00);
            $table->decimal('service_charge', 10, 2)->default(0.00);
            $table->decimal('discount_percent', 5, 2)->default(0); // Discount percentage
            $table->decimal('discount_amount', 10, 0)->default(0);
            $table->decimal('total_price', 10, 2)->default(0.00);

            // Promo code opsional
            $table->string('promo_code')->nullable();

            // Nomor booking unik
            $table->string('booking_number', 100)->unique();

            // Jenis kamar (nullable, default Standard)
            $table->string('room_type', 50)->nullable()->default('Standard');

            // Metode pembayaran
            $table->enum('payment_method', ['pending', 'transfer', 'qris', 'cash'])->default('pending');

            // Jumlah malam menginap
            $table->integer('night_count')->default(1);

            $table->timestamps();

            // Index untuk performa query
            $table->index('hotel_id');
            $table->index('status');
            $table->index('payment_method');
        });
    }

    public function down()
    {
        Schema::dropIfExists('booking_hotels');
    }
};
