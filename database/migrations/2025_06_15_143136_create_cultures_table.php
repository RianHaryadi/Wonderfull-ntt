<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('cultures', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description_1')->nullable();
            $table->text('description_2')->nullable();
            $table->text('tags')->nullable(); // JSON encoded array
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('cultures');
    }
};
