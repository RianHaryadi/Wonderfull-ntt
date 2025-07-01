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
        Schema::create('tour_packages', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->foreignId('destination_id')->nullable()->constrained()->nullOnDelete();
        $table->decimal('price', 12, 2);
        $table->integer('days')->default(1);
        $table->boolean('includes_hotel')->default(false);
        $table->string('location');
        $table->string('thumbnail')->nullable();
        $table->string('category')->nullable();
        $table->text('photos')->nullable();
        $table->text('description')->nullable();
        $table->float('rating', 2, 1)->nullable(); // nilai bintang dummy
        $table->integer('rating_count')->nullable(); // jumlah review dummy
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_packages');
    }
};
