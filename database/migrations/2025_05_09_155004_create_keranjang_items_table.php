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
        Schema::create('keranjang_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('keranjang_id')->constrained('keranjang')->onDelete('cascade');

            // Untuk produk biasa (nullable jika kustom)
            $table->foreignId('produk_id')->nullable()->constrained('produk')->onDelete('set null');

            // Untuk kaos kustom (nullable jika produk biasa)
            $table->foreignId('kaos_kustom_id')->nullable()->constrained('kaos_kustom')->onDelete('set null');

            $table->integer('jumlah')->default(1);
            $table->string('ukuran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keranjang_item');
    }
};
