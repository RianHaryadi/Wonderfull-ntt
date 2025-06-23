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
        Schema::create('tour_package_variants', function (Blueprint $table) {
           $table->id(); // ID unik varian

            $table->foreignId('tour_package_id')->constrained()->onDelete('cascade');
            // → Relasi ke tour_packages. Jika paket dihapus, variannya ikut terhapus.

            $table->string('label')->nullable();
            // → Label bebas, misal: "Paket Hemat", "Dengan Hotel", dll.

            $table->boolean('includes_hotel')->default(false);
            // → Menandai apakah varian ini termasuk penginapan.

            $table->foreignId('hotel_id')->nullable()->constrained()->onDelete('set null');
            // → Menghubungkan ke hotel jika diperlukan. Dibiarkan null kalau tidak ada.

            $table->timestamps(); // created_at & updated_at

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_package_variants');
    }
};
