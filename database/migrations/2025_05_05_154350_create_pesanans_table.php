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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('user')->onDelete('cascade');

            // Produk biasa (nullable jika kustom)
            $table->foreignId('produk_id')->nullable()->constrained('produk')->onDelete('set null');

            // Kaos kustom (nullable jika produk biasa)
            $table->foreignId('kaos_kustom_id')->nullable()->constrained('kaos_kustom')->onDelete('set null');

            $table->integer('jumlah');
            $table->string('ukuran');
            $table->decimal('total_harga', 10, 2);

            $table->foreignId('rekening_id')->nullable()->constrained('rekening')->nullOnDelete();
            $table->enum('metode_pembayaran', ['transfer', 'cod']);
            $table->string('bukti_transfer')->nullable();
            $table->string('status')->default('menunggu');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
