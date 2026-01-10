<?php

namespace App\Http\Controllers\depan;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Ulasan;
use App\Models\UlasanGambar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class pesananController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $status = $request->query('status');

        $query = Pesanan::where('user_id', $user->id);

        if ($status) {
            $query->where('status', $status);
        } else {
            $query->where('status', '!=', 'selesai'); // Kecualikan yang selesai
        }

        $pesanans = $query->latest()->get();

        return view('depan.pesanan.index', compact('pesanans'));
    }


    public function show($id)
    {
        $user = auth()->user();

        $pesanan = Pesanan::where('id', $id)
            ->where('user_id', $user->id)
            ->with(['produk', 'kaosKustom'])
            ->firstOrFail();

        return view('depan.pesanan.detail-pesanan', compact('pesanan'));
    }

    public function terimaPesanan($id)
    {
        $pesanan = Pesanan::where('user_id', auth()->id())
            ->where('status', 'dikirim')
            ->findOrFail($id);

        $pesanan->status = 'selesai';
        $pesanan->save();

        return redirect()->back()->with('success', 'Terima kasih! Pesanan telah ditandai sebagai selesai.');
    }

    public function batalkan($id)
    {
        $pesanan = Pesanan::where('user_id', auth()->id())
            ->where('status', 'menunggu')
            ->findOrFail($id);

        // Cek jika user sudah upload bukti transfer
        if ($pesanan->metode_pembayaran === 'transfer' && $pesanan->bukti_transfer) {
            return redirect()->back()->with('info', 'Pesanan tidak bisa dibatalkan karena sudah melakukan transfer.');
        }

        $pesanan->update(['status' => 'dibatalkan']);

        return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function hapus($id)
    {
        $pesanan = Pesanan::where('user_id', auth()->id())->findOrFail($id);

        // Hanya izinkan hapus jika status pesanan adalah 'dibatalkan'
        if ($pesanan->status !== 'dibatalkan') {
            return redirect()->back()->with('error', 'Pesanan hanya bisa dihapus jika statusnya dibatalkan.');
        }

        // Opsional: hapus file bukti transfer jika ada
        if ($pesanan->bukti_transfer) {
            Storage::disk('public')->delete($pesanan->bukti_transfer);
        }

        $pesanan->delete();

        return redirect()->back()->with('success', 'Pesanan berhasil dihapus.');
    }

    // riwayat pesaanan
    public function riwayat()
    {
        $pesanans = Pesanan::where('user_id', auth()->id())
            ->where('status', 'selesai')
            ->latest()
            ->get();

        return view('depan.pesanan.riwayat', compact('pesanans'));
    }

    public function showRiwayat($id)
    {
        $user = auth()->user();

        $pesanan = Pesanan::where('id', $id)
            ->where('user_id', $user->id)
            ->with(['produk', 'kaosKustom'])
            ->firstOrFail();

        return view('depan.pesanan.riwayat-detail', compact('pesanan'));
    }

    // Ulasan
    public function formUlasan($id)
    {
        $pesanan = Pesanan::where('user_id', auth()->id())
            ->where('status', 'selesai')
            ->with('produk')
            ->findOrFail($id);

        // Jika bukan produk (misalnya kaos kustom), bisa dikondisikan juga

        return view('depan.ulasan.form-ulasan', compact('pesanan'));
    }

    public function ulasanFormStore(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string',
            'gambar.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $pesanan = Pesanan::where('user_id', auth()->id())
            ->where('id', $id)
            ->where('status', 'selesai')
            ->whereNotNull('produk_id')
            ->firstOrFail();

        // Validasi: sudah beri ulasan?
        if (Ulasan::where('pesanan_id', $pesanan->id)->exists()) {
            return redirect()->back()->with('error', 'Anda sudah memberikan ulasan untuk pesanan ini.');
        }

        $ulasan = Ulasan::create([
            'pesanan_id' => $pesanan->id,
            'produk_id' => $pesanan->produk_id,
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        // Simpan gambar
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {
                $path = $file->store('ulasan', 'public');
                UlasanGambar::create([
                    'ulasan_id' => $ulasan->id,
                    'gambar' => $path,
                ]);
            }
        }

        return redirect()->route('ulasan.saya')->with('success', 'Ulasan berhasil dikirim.');
    }

    public function ulasanSaya()
    {
        $ulasanList = Ulasan::with(['produk', 'gambar'])
            ->whereHas('pesanan', function ($q) {
                $q->where('user_id', auth()->id());
            })->latest()->get();

        return view('depan.ulasan.ulasan-saya', compact('ulasanList'));
    }
}
