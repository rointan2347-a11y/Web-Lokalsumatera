<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Rekening;
use Illuminate\Http\Request;

class RekeningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rekening = Rekening::all();
        return view('admin.rekening.index', compact('rekening'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.rekening.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'atas_nama' => 'required|string|min:5',
            'nama_bank' => 'required|string|min:3',
            'no_rek' => 'required|numeric|min:5|unique:rekening,no_rek'
        ]);
        Rekening::create($validated);
        return redirect()->route('rekening.index')->with('success', 'Data rekening berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Rekening $rekening)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rekening $rekening)
    {
        return view('admin.rekening.edit', compact('rekening'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rekening $rekening)
    {
        $validated = $request->validate([
            'atas_nama' => 'required|string|min:5',
            'nama_bank' => 'required|string|min:3',
            'no_rek' => 'required|numeric|min:5|unique:rekening,no_rek,' . $rekening->id,
        ]);
        $rekening->update($validated);
        return redirect()->route('rekening.index')->with('success', 'Data rekening berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rekening $rekening)
    {
        $dipakai = Pesanan::where('rekening_id', $rekening->id)
            ->where('status', '!=', 'selesai') // sesuaikan dengan status kamu
            ->exists();

        if ($dipakai) {
            return redirect()->route('rekening.index')
                ->with('error', 'Rekening tidak bisa dihapus karena masih digunakan dalam pesanan.');
        }
        $rekening->delete();
        return redirect()->route('rekening.index')->with('success', 'Data rekening berhasil dihapus.');
    }
}
