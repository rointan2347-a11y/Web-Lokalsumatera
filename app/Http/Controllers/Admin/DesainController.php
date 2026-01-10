<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DesainKaos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DesainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $desain = DesainKaos::where('desain_default', true)->get(); // hanya desain admin
        return view('admin.desain.index', compact('desain'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.desain.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'nullable|string|max:255',
            'gambar' => 'required|image|mimes:png|max:5120', // hanya PNG
        ]);

        $path = $request->file('gambar')->store('desain_kaos', 'public');

        DesainKaos::create([
            'nama' => $request->nama,
            'gambar' => $path,
            'desain_default' => true,       // ini menandakan desain dari admin
            'user_id' => null,              // null karena bukan user biasa
        ]);

        return redirect('/admin/desain')->with('success', 'Desain berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DesainKaos $desain)
    {
        return view('admin.desain.edit', compact('desain'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DesainKaos $desain)
    {
        $request->validate([
            'nama' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|mimes:png|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($desain->gambar && Storage::disk('public')->exists($desain->gambar)) {
                Storage::disk('public')->delete($desain->gambar);
            }

            $path = $request->file('gambar')->store('desain_kaos', 'public');
            $desain->gambar = $path;
        }

        $desain->nama = $request->nama;
        $desain->save();

        return redirect('/admin/desain')->with('success', 'Desain berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DesainKaos $desain)
    {

        if ($desain->gambar && Storage::disk('public')->exists($desain->gambar)) {
            Storage::disk('public')->delete($desain->gambar);
        }

        $desain->delete();
        return redirect('/admin/desain')->with('success', 'Desain berhasil dihapus.');
    }
}
