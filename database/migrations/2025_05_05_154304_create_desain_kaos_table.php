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
        Schema::create('desain_kaos', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable(); // Nama desain (boleh kosong)
            $table->string('gambar'); // Path gambar desain
            $table->boolean('desain_default')->default(false); // True = disediakan admin
            $table->foreignId('user_id')->nullable()->constrained('user')->nullOnDelete(); // Null = desain default
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('desain_kaos');
    }
};
