<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionsTable extends Migration
{
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Promotion code
            $table->string('description')->nullable(); // Description of the promotion
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->decimal('discount_percent', 5, 2)->nullable(); // Discount percentage
            $table->date('valid_from')->nullable(); // Start date of promotion
            $table->date('valid_until')->nullable(); // End date of promotion
            $table->boolean('active')->default(true); // Is promotion active?
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('promotions');
    }
}
