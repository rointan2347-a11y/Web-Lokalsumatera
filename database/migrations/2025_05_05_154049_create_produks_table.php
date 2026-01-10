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
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('stok')->default(0);
            $table->text('deskripsi')->nullable();
            $table->string('gambar');
            $table->string('gambar_belakang')->nullable();
            $table->decimal('harga', 10, 2);
            $table->decimal('harga_diskon', 10, 2)->nullable();
            $table->string('warna')->nullable(); // Hitam, Putih
            $table->string('ketebalan')->nullable(); // 16s, 24s, 30s
            $table->float('rating')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
