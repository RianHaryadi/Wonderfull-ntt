<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDestinationHotelTable extends Migration
{
    public function up()
    {
        Schema::create('destination_hotel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained()->onDelete('cascade');
            $table->foreignId('destination_id')->constrained()->onDelete('cascade');
            $table->timestamps(); // opsional
        });
    }

    public function down()
    {
        Schema::dropIfExists('destination_hotel');
    }
}
