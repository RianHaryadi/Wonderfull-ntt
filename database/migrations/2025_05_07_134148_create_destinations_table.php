<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDestinationsTable extends Migration
{
    public function up()
    {
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();

            // ===== Informasi Umum =====
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('location');
            $table->string('category');
            $table->string('image')->nullable();
            $table->boolean('is_popular')->default(false);

            // ===== Harga =====
            $table->unsignedInteger('price')->default(0); // Harga tiket masuk, dalam rupiah

            // ===== Informasi Rating =====
            $table->float('rating', 2, 1)->nullable();        // Contoh: 4.5
            $table->integer('rating_count')->nullable();      // Contoh: 1200

            // ===== Lokasi Peta =====
            $table->decimal('latitude', 10, 7)->nullable();   // Contoh: -10.176627
            $table->decimal('longitude', 10, 7)->nullable();  // Contoh: 123.607007
            $table->string('maps_url')->nullable();           // Contoh: https://goo.gl/maps/...

            // ===== Pembayaran =====
            $table->enum('payment_method', ['transfer', 'qris', 'cash'])->nullable()->change();
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending')->change();
            // ===== Timestamps =====
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('destinations');
    }
}
