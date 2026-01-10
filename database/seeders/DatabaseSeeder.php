<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\BerandaWeb;
use App\Models\Biodata;
use App\Models\DesainKaos;
use App\Models\Rekening;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'nama' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('admin'),
        ]);
        User::create([
            'nama' => 'user',
            'username' => 'user',
            'email' => 'user@gmail.com',
            'role' => 'user',
            'password' => Hash::make('123456'),
        ]);

        Biodata::create([
            'user_id' => 2,
            'tanggal_lahir' => '2000-05-01',
            'jenis_kelamin' => 'Laki - laki',
            'telepon' => '081212345678',
            'alamat_lengkap' => 'Jln. Swadaya Lorong Makmur'
        ]);

        DesainKaos::create([
            'nama' => 'coba-desain1',
            'gambar' => 'desain_kaos/mycLeBOqc0qM4zx9OVv4ZGJ8GNJ0lprCkt90a29L.png',
            'desain_default' => 1
        ]);
        DesainKaos::create([
            'nama' => 'coba-desain2',
            'gambar' => 'desain_kaos/w79fu69zdRWWM32PUnIIqYDHYMeDVFzKlqRUEpXu.png',
            'desain_default' => 1
        ]);

        BerandaWeb::create([
            'judul' => 'Lokal Sumatera',
            'deskripsi' => 'Lokal Sumatera, brand clothing asal Sumatera Selatan, awalnya beroperasi dengan toko fisik sebelum meluncurkan situs web dan bergabung dengan platform e-commerce...'
        ]);

        Rekening::create([
            'atas_nama' => 'Farhan',
            'nama_bank' => 'BNI',
            'no_rek' => 12345531421
        ]);

        $this->call([
            ProdukSeeder::class,
        ]);
    }
}
