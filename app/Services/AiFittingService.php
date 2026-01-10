<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AiFittingService
{
    /**
     * Implementasi Metode SAW (Simple Additive Weighting)
     * Kriteria:
     * C1. Harga (Cost) - Bobot 30% - Semakin murah semakin prioritas
     * C2. Rating (Benefit) - Bobot 40% - Semakin tinggi semakin prioritas
     * C3. Stok (Benefit) - Bobot 30% - Semakin banyak stok semakin prioritas
     */
    public function rankingSAW($products)
    {
        if ($products->isEmpty()) {
            return $products;
        }

        // 1. Persiapan Data & Mencari Nilai Min/Max
        // Kita paksa konversi ke float untuk keamanan
        $prices = $products->pluck('harga')->map(fn($v) => (float) $v)->toArray();
        $ratings = $products->map(fn($p) => (float) $p->rata_rata_rating)->toArray();
        $stocks = $products->pluck('stok')->map(fn($v) => (int) $v)->toArray();

        $minPrice = min($prices) ?: 1; // Hindari div by zero
        $maxRating = max($ratings) ?: 5; // Default 5 jika belum ada rating
        $maxStock = max($stocks) ?: 1;

        // Bobot
        $wPrice = 0.30;
        $wRating = 0.40;
        $wStock = 0.30;

        // 2. Normalisasi & Perankingan
        $ranked = $products->map(function ($product) use ($minPrice, $maxRating, $maxStock, $wPrice, $wRating, $wStock) {
            // Normalisasi
            // Cost: Min / Nilai
            $valPrice = (float) $product->harga ?: 1;
            $nPrice = $minPrice / $valPrice;

            // Benefit: Nilai / Max
            $valRating = (float) $product->rata_rata_rating;
            $nRating = $valRating / $maxRating;

            $valStock = (int) $product->stok;
            $nStock = $valStock / $maxStock;

            // Hitung Nilai Preferensi (V)
            $score = ($nPrice * $wPrice) + ($nRating * $wRating) + ($nStock * $wStock);

            // Simpan score untuk debug/tampil jika perlu
            $product->saw_score = round($score, 4);
            $product->saw_details = [
                'n_price' => round($nPrice, 2),
                'n_rating' => round($nRating, 2),
                'n_stock' => round($nStock, 2)
            ];
            
            return $product;
        })->sortByDesc('saw_score'); // Urutkan dari nilai tertinggi

        return $ranked->values();
    }

    /**
     * Integrasi OpenRouter AI
     */
    public function getAiAdvice($data)
    {
        $apiKey = env('OPENROUTER_API_KEY');
        
        // Fallback jika tidak ada Key
        if (!$apiKey) {
            return "Analisis Lokal: Kombinasi ukuran {$data['ukuran']} dengan warna {$data['warna']} adalah pilihan solid!";
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'HTTP-Referer' => url('/'),
                'X-Title' => 'Lokal Sumatera AI',
                'Content-Type' => 'application/json',
            ])->timeout(5)->post('https://openrouter.ai/api/v1/chat/completions', [
                // Menggunakan model gratis Llama 3.3 (Lebih stabil dari Gemini)
                'model' => 'meta-llama/llama-3.3-70b-instruct:free',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Kamu adalah asisten fashion gaul dari brand "Lokal Sumatera". Berikan komentar singkat (max 20 kata), seru, dan memuji pilihan user. Gunakan bahasa Indonesia santai.'
                    ],
                    [
                        'role' => 'user',
                        'content' => "User TB:{$data['tinggi']}cm BB:{$data['berat']}kg pilih size {$data['ukuran']} warna {$data['warna']} ketebalan {$data['ketebalan']}."
                    ]
                ]
            ]);

            if ($response->successful()) {
                return $response->json()['choices'][0]['message']['content'] ?? "Pilihan mantap! Ukuran {$data['ukuran']} bakal pas banget di badan kamu.";
            }

        } catch (\Exception $e) {
            // Silently fail to default
        }

        return "Pilihan mantap! Ukuran {$data['ukuran']} bakal pas banget buat gaya kamu hari ini.";
    }

    /**
     * AI Product Wizard Generator
     */
    public function generateProductContent($concept, $color = 'Hitam')
    {
        $apiKey = env('OPENROUTER_API_KEY');
        
        if (!$apiKey) {
            return [
                'nama' => 'Produk Keren (Fallback)',
                'deskripsi' => 'Deskripsi otomatis tidak tersedia tanpa API Key.',
                'harga' => 85000
            ];
        }

        try {
            $response = Http::withOptions(['verify' => false])->withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'HTTP-Referer' => url('/'),
                'X-Title' => 'Lokal Sumatera AI',
                'Content-Type' => 'application/json',
            ])->timeout(20)->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => 'meta-llama/llama-3.3-70b-instruct:free',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are the Creative Director of "Lokal Sumatera", a dark & edgy streetwear brand (similar to Maternal/Represent). Tone: Dark, Mysterious, Bold, Minimalist. Use Cool English. No cringe words.'
                    ],
                    [
                        'role' => 'user',
                        'content' => "Create streetwear product content for concept: '{$concept}'. Color: {$color}.
                        Format JSON:
                        {
                            \"nama\": \"Product Title (Max 4 words, Dark & Abstract, e.g. 'Void Walker')\",
                            \"deskripsi\": \"One short paragraph description in ENGLISH. Dark, poetic, and mysterious. Subtly hint at Palembang/Sumatera roots but keep it global/abstract.\",
                            \"harga\": (integer, range 120000-280000)
                        }"
                    ]
                ]
            ]);

            if ($response->successful()) {
                $content = $response->json()['choices'][0]['message']['content'];
                $content = str_replace('```json', '', $content);
                $content = str_replace('```', '', $content);
                return json_decode(trim($content), true);
            } else {
                return ['error' => 'API Error ' . $response->status() . ': ' . $response->body()];
            }

        } catch (\Exception $e) {
            return ['error' => 'Connection Error: ' . $e->getMessage()];
        }

        return ['error' => 'Unknown Error'];
    }
}
