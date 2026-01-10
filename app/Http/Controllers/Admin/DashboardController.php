<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BerandaWeb;
use App\Models\KaosKustom;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function adminDashboard(Request $request)
    {
        $request->validate([
            'tanggal_awal' => 'nullable|date',
            'tanggal_akhir' => 'nullable|date|after_or_equal:tanggal_awal',
        ]);

        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        // Ubah COUNT(*) menjadi SUM(jumlah) untuk hitung total qty terjual
        $queryProduk = Pesanan::selectRaw('DATE(updated_at) as tanggal, SUM(jumlah) as total')
            ->where('status', 'selesai')
            ->whereNotNull('produk_id');

        $queryKustom = Pesanan::selectRaw('DATE(updated_at) as tanggal, SUM(jumlah) as total')
            ->where('status', 'selesai')
            ->whereNotNull('kaos_kustom_id');

        if ($tanggalAwal && $tanggalAkhir) {
            $queryProduk->whereBetween('updated_at', [$tanggalAwal, $tanggalAkhir]);
            $queryKustom->whereBetween('updated_at', [$tanggalAwal, $tanggalAkhir]);
        }

        $formatTanggal = function ($item) {
            $item->tanggal = Carbon::parse($item->tanggal)->format('d-m-Y');
            return $item;
        };

        $grafikProdukJadi = $queryProduk->groupBy('tanggal')->orderBy('tanggal')->get()->map($formatTanggal);
        $grafikKaosKustom = $queryKustom->groupBy('tanggal')->orderBy('tanggal')->get()->map($formatTanggal);

        $totalProduk = Produk::count();
        $totalPesanan = Pesanan::count();
        $totalUser = User::where('role', 'user')->count();
        $totalKustom = KaosKustom::count();
        $totalPendapatan = Pesanan::where('status', 'selesai')->sum('total_harga');

        $statusPesanProduk = Pesanan::selectRaw('status, COUNT(*) as total')
            ->whereNotNull('produk_id')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $statusPesanKustom = Pesanan::selectRaw('status, COUNT(*) as total')
            ->whereNotNull('kaos_kustom_id')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        foreach (['menunggu', 'diproses', 'dikirim', 'selesai', 'dibatalkan'] as $status) {
            $statusPesanProduk[$status] = $statusPesanProduk[$status] ?? 0;
            $statusPesanKustom[$status] = $statusPesanKustom[$status] ?? 0;
        }

        $produkTerlaris = Pesanan::select('produk_id', DB::raw('SUM(jumlah) as total_terjual'))
            ->where('status', 'selesai')
            ->whereNotNull('produk_id')
            ->groupBy('produk_id')
            ->orderByDesc('total_terjual')
            ->with('produk')
            ->take(5)
            ->get();

        return view('admin.adminDashboard', compact(
            'totalProduk',
            'totalPesanan',
            'totalUser',
            'totalKustom',
            'totalPendapatan',
            'statusPesanProduk',
            'statusPesanKustom',
            'grafikProdukJadi',
            'grafikKaosKustom',
            'tanggalAwal',
            'tanggalAkhir',
            'produkTerlaris'
        ));
    }

    public function adminBerandaWeb()
    {
        $berandaWeb = BerandaWeb::first();
        return view('admin.berandaWeb.index', compact('berandaWeb'));
    }

    public function adminBerandaWebEdit()
    {
        $berandaWeb = BerandaWeb::firstOrFail();
        return view('admin.berandaWeb.edit', compact('berandaWeb'));
    }

    public function adminBerandaWebUpdate(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|min:6',
            'deskripsi' => 'required|min:20',
        ]);

        $berandaWeb = BerandaWeb::firstOrFail();
        $berandaWeb->update($validated);

        return redirect()->route('admin.berandaWeb.index')
            ->with('success', 'Detail halaman beranda berhasil diperbarui.');
    }
}
