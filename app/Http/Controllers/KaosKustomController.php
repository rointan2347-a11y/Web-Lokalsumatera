<?php

namespace App\Http\Controllers;

use App\Models\KaosKustom;
use Illuminate\Http\Request;

class KaosKustomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'desain_depan_id' => 'nullable|exists:desain_kaos,id',
            'desain_belakang_id' => 'nullable|exists:desain_kaos,id',
            'teks_custom' => 'nullable|string|max:255',
        ]);

        KaosKustom::create([
            'user_id' => auth()->id(),
            'desain_depan_id' => $request->desain_depan_id,
            'desain_belakang_id' => $request->desain_belakang_id,
            'teks_custom' => $request->teks_custom,
            'status' => 'tersimpan', // atau 'draf' sesuai kebutuhan alur
        ]);

        return redirect()->route('desain.sendiri')->with('success', 'Desain berhasil disimpan!');
    }


    /**
     * Display the specified resource.
     */
    public function show(KaosKustom $kaosKustom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KaosKustom $kaosKustom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KaosKustom $kaosKustom)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KaosKustom $kaosKustom)
    {
        //
    }
}
