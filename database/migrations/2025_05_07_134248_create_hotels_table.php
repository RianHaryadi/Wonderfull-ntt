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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address');
            $table->string('description')->nullable();
            $table->string('image')->nullable(); // ← Kolom gambar
            $table->foreignId('destination_id')->default(1)->constrained()->onDelete('cascade');
            $table->text('facilities')->nullable();
            $table->string('location')->nullable(); // kolom location tambahan
            $table->decimal('single_room_price', 15, 2)->nullable();
            $table->decimal('double_room_price', 15, 2)->nullable();
            $table->decimal('family_room_price', 15, 2)->nullable();
            $table->integer('room_count_single')->default(10);
            $table->integer('room_count_double')->default(10);
            $table->integer('room_count_family')->default(5);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
