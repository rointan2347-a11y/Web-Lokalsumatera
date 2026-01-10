<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produk = Produk::with('ulasan')->get();
        return view('admin.produk.index', compact('produk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.produk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'stok' => 'required|numeric',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'harga_diskon' => 'nullable|numeric',
            'warna' => 'nullable|string',
            'ketebalan' => 'nullable|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'gambar_belakang' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('produk', 'public');
        }
        if ($request->hasFile('gambar_belakang')) {
            $validated['gambar_belakang'] = $request->file('gambar_belakang')->store('produk', 'public');
        }

        Produk::create($validated);

        return redirect('/admin/produk')->with('success', 'Data produk berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $produk = Produk::with('ulasan')->findOrFail($id);
        return view('admin.produk.show', compact('produk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        return view('admin.produk.edit', compact('produk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produk $produk)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'stok' => 'required|numeric',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'harga_diskon' => 'nullable|numeric',
            'warna' => 'nullable|string',
            'ketebalan' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'gambar_belakang' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
                Storage::disk('public')->delete($produk->gambar);
            }

            $validated['gambar'] = $request->file('gambar')->store('produk', 'public');
        }

        if ($request->hasFile('gambar_belakang')) {
            if ($produk->gambar_belakang && Storage::disk('public')->exists($produk->gambar_belakang)) {
                Storage::disk('public')->delete($produk->gambar_belakang);
            }

            $validated['gambar_belakang'] = $request->file('gambar_belakang')->store('produk', 'public');
        }


        $produk->update($validated);
        return redirect('/admin/produk')->with('success', 'Data produk berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
            Storage::disk('public')->delete($produk->gambar);
        }

        if ($produk->gambar_belakang && Storage::disk('public')->exists($produk->gambar_belakang)) {
            Storage::disk('public')->delete($produk->gambar_belakang);
        }

        $produk->delete();
        return redirect('/admin/produk')->with('success', 'Data produk berhasil dihapus.');
    }

    /**
     * AJAX AI Generator
     */
    public function ajaxGenerateContent(Request $request, \App\Services\AiFittingService $aiService)
    {
        $request->validate([
            'keyword' => 'required|string|max:100',
            'warna' => 'nullable|string'
        ]);

        $result = $aiService->generateProductContent($request->keyword, $request->warna ?? 'Netral');

        if ($result && !isset($result['error'])) {
            return response()->json([
                'status' => 'success',
                'data' => $result
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => $result['error'] ?? 'Gagal menghubungi AI (Null Response).'
        ], 500);
    }
}
