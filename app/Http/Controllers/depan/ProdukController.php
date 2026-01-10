<?php

namespace App\Http\Controllers\depan;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $produk = Produk::withCount('ulasan')
            ->withAvg('ulasan', 'rating')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                        ->orWhere('deskripsi', 'like', "%{$search}%");
                });
            })
            ->paginate(12);

        return view('depan.produk.index', compact('produk'));
    }


    public function show($id)
    {
        $produk = Produk::with(['ulasan.gambar', 'ulasan.pesanan.user'])->findOrFail($id);

        // Hitung rata-rata rating
        $rataRataRating = $produk->ulasan->avg('rating');
        return view('depan.produk.show', compact('produk', 'rataRataRating'));
    }
}
