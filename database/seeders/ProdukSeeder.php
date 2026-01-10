<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('produk')->insert([
            [
                'nama' => 'Kaos Polos Putih 30s (Adem)',
                'stok' => 30,
                'deskripsi' => 'Kaos polos putih berkualitas tinggi, bahan Cotton Combed 30s yang tipis dan sangat adem.',
                'gambar' => 'produk/kLpW6PirPKE0GZhNh51UUoc35FBKJlBwyGZNhomP.jpg',
                'gambar_belakang' => null,
                'harga' => 75000,
                'harga_diskon' => 65000,
                'warna' => 'Putih',
                'ketebalan' => '30s',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Kaos Hitam Premium 24s (Sedang)',
                'stok' => 45,
                'deskripsi' => 'Kaos hitam pekat bahan 24s, ketebalan pas tidak terlalu tipis.',
                'gambar' => 'produk/kLpW6PirPKE0GZhNh51UUoc35FBKJlBwyGZNhomP.jpg',
                'gambar_belakang' => null,
                'harga' => 90000,
                'harga_diskon' => null,
                'warna' => 'Hitam',
                'ketebalan' => '24s',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Kaos Heavyweight Hitam 16s (Tebal)',
                'stok' => 20,
                'deskripsi' => 'Kaos Heavyweight 16s. Bahan tebal, kaku, dan kokoh (American Style).',
                'gambar' => 'produk/kLpW6PirPKE0GZhNh51UUoc35FBKJlBwyGZNhomP.jpg',
                'gambar_belakang' => null,
                'harga' => 120000,
                'harga_diskon' => 100000,
                'warna' => 'Hitam',
                'ketebalan' => '16s',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Kaos Putih Tebal 16s',
                'stok' => 15,
                'deskripsi' => 'Kaos Putih Heavyweight 16s. Tidak menerawang.',
                'gambar' => 'produk/kLpW6PirPKE0GZhNh51UUoc35FBKJlBwyGZNhomP.jpg',
                'gambar_belakang' => null,
                'harga' => 125000,
                'harga_diskon' => null,
                'warna' => 'Putih',
                'ketebalan' => '16s',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
