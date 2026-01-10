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
        Schema::create('kaos_kustom', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('user')->onDelete('cascade');

            $table->string('desain_depan')->nullable();
            $table->string('desain_belakang')->nullable();
            $table->string('warna')->default('putih');
            $table->string('ukuran')->default('M');
            $table->string('teks_kustom')->nullable();
            $table->integer('harga')->default(0);

            $table->enum('status', ['draf', 'keranjang', 'dipesan'])->default('draf');

            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kaos_kustom');
    }
};
