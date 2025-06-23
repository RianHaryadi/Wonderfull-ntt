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
        $table->string('name');
        $table->text('description')->nullable();
        $table->string('location');
        $table->string('image')->nullable();
        $table->string('category');
        $table->boolean('is_popular')->default(false); // tambah ini
        $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('destinations');
    }
}
