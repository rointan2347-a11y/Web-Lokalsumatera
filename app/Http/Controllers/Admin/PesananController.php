<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $query = Pesanan::with(['user', 'produk', 'kaosKustom'])->latest();

        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $pesanans = $query->get();

        return view('admin.pesanan.index', compact('pesanans'));
    }


    // Menampilkan detail pesanan
    public function show($id)
    {
        $pesanan = Pesanan::with(['user', 'produk', 'kaosKustom'])->findOrFail($id);

        return view('admin.pesanan.show', compact('pesanan'));
    }

    // Mengupdate status pesanan (misalnya dari dropdown)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,diproses,dikirim',
        ]);

        $pesanan = Pesanan::findOrFail($id);

        // Cegah update jika status sudah selesai atau dibatalkan
        if (in_array($pesanan->status, ['selesai', 'dibatalkan'])) {
            return redirect()->route('admin.pesanan.index')
                ->with('error', 'Status pesanan tidak dapat diubah karena sudah ' . $pesanan->status . '.');
        }

        $pesanan->status = $request->status;
        $pesanan->save();

        return redirect()->route('admin.pesanan.index')->with('success', 'Status pesanan diperbarui.');
    }


    public function previewDesain($id)
    {
        $pesanan = Pesanan::with('kaosKustom')->findOrFail($id);

        if (!$pesanan->kaosKustom) {
            abort(404, 'Pesanan tidak memiliki desain kustom.');
        }

        return view('admin.pesanan.desain_pdf', [
            'depan' => $pesanan->kaosKustom->desain_depan,
            'belakang' => $pesanan->kaosKustom->desain_belakang,
        ]);
    }
}
