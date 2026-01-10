<?php

namespace App\Http\Controllers;

use App\Models\Biodata;
use App\Models\KaosKustom;
use App\Models\Keranjang;
use App\Models\KeranjangItem;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Rekening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helpers\TelegramHelper;

class KeranjangController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $keranjang = Keranjang::where('user_id', $user->id)->first();
        $biodata = Biodata::where('user_id', $user->id)->first();

        $items = [];
        if ($keranjang) {
            $items = $keranjang->items()->with(['produk', 'kaosKustom'])->get();
        }

        return view('depan.keranjang.index', compact('items', 'biodata'));
    }

    public function tambahItemKeranjang(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:produk,kustom',
            'jumlah' => 'required|integer|min:1',
            'ukuran' => 'required|in:S,M,L,XL,XXL,XXXL',
            'produk_id' => 'nullable|exists:produk,id',
            'kaos_kustom_id' => 'nullable|exists:kaos_kustom,id',
        ]);

        $user = Auth::user();
        $keranjang = Keranjang::firstOrCreate(['user_id' => $user->id]);

        if ($request->jenis === 'produk') {
            $produk = Produk::findOrFail($request->produk_id);

            if ($request->jumlah > $produk->stok) {
                return back()->with('error', 'Jumlah melebihi stok. Stok tersedia: ' . $produk->stok);
            }

            $item = KeranjangItem::where('keranjang_id', $keranjang->id)
                ->where('produk_id', $produk->id)
                ->whereNull('kaos_kustom_id')
                ->where('ukuran', $request->ukuran)
                ->first();

            if ($item) {
                $totalJumlah = $item->jumlah + $request->jumlah;
                if ($totalJumlah > $produk->stok) {
                    return back()->with('error', 'Jumlah total di keranjang melebihi stok. Sisa stok: ' . $produk->stok);
                }
                $item->jumlah = $totalJumlah;
                $item->save();
            } else {
                KeranjangItem::create([
                    'keranjang_id' => $keranjang->id,
                    'produk_id' => $produk->id,
                    'jumlah' => $request->jumlah,
                    'ukuran' => $request->ukuran,
                ]);
            }

            return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
        }

        if ($request->jenis === 'kustom') {
            $kaos = KaosKustom::where('id', $request->kaos_id)
                ->where('user_id', $user->id)
                ->first();

            if (!$kaos) {
                return back()->with('error', 'Desain tidak ditemukan.');
            }

            $item = KeranjangItem::where('keranjang_id', $keranjang->id)
                ->where('kaos_kustom_id', $kaos->id)
                ->whereNull('produk_id')
                ->first();

            if ($item) {
                return back()->with('info', 'Desain ini sudah ada di keranjang.');
            }

            if ($kaos->status !== 'draf') {
                return back()->with('error', 'Desain ini tidak bisa ditambahkan ulang ke keranjang.');
            }

            KeranjangItem::create([
                'keranjang_id' => $keranjang->id,
                'kaos_kustom_id' => $kaos->id,
                'jumlah' => $request->jumlah,
                'ukuran' => $kaos->ukuran ?? $request->ukuran,
            ]);

            $kaos->status = 'keranjang';
            $kaos->save();

            return back()->with('success', 'Kaos kustom berhasil ditambahkan ke keranjang!');
        }

        return back()->with('error', 'Jenis item tidak valid.');
    }

    public function hapus($id)
    {
        $item = KeranjangItem::findOrFail($id);

        if ($item->keranjang->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk item ini.');
        }

        if ($item->kaos_kustom_id) {
            $kaos = KaosKustom::find($item->kaos_kustom_id);
            if ($kaos && $kaos->user_id === Auth::id()) {
                $kaos->status = 'draf';
                $kaos->save();
            }
        }

        $item->delete();

        return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    public function checkoutForm($id)
    {
        $user = auth()->user();
        $keranjang = Keranjang::where('user_id', $user->id)->first();

        $item = KeranjangItem::where('id', $id)
            ->whereHas('keranjang', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->with(['produk', 'kaosKustom'])
            ->firstOrFail();

        $rekeningList = Rekening::all();
        $biodata = Biodata::where('user_id', $user->id)->first();

        return view('depan.keranjang.checkout', compact('item', 'biodata', 'rekeningList'));
    }

    public function checkoutProses(Request $request, $id)
    {
        $user = auth()->user();
        $keranjang = Keranjang::where('user_id', $user->id)->firstOrFail();
        $item = $keranjang->items()
            ->where('id', $id)
            ->with(['produk', 'kaosKustom'])
            ->firstOrFail();

        $isKustom = $item->kaos_kustom_id !== null;
        $produk = $isKustom ? $item->kaosKustom : $item->produk;

        if (!$produk) {
            return back()->with('error', 'Produk tidak ditemukan.');
        }

        $jumlah = $request->input('jumlah', $item->jumlah);
        $ukuran = $request->input('ukuran', $item->ukuran);

        $rules = [
            'metode_pembayaran' => 'required|in:transfer,cod',
            'jumlah' => 'required|integer|min:1' . ($isKustom ? '' : '|max:' . $produk->stok),
            'ukuran' => 'required|in:S,M,L,XL,XXL,XXXL',
        ];

        if ($request->metode_pembayaran === 'transfer') {
            $rules['rekening_id'] = 'required|exists:rekening,id';
            $rules['bukti_transfer'] = 'required|mimes:jpg,jpeg,png,pdf|max:2048';
        }

        $request->validate($rules);

        if (!$isKustom && $jumlah > $produk->stok) {
            return back()->with('error', 'Jumlah produk melebihi stok tersedia.');
        }

        $harga = $isKustom ? ($produk->harga ?? 0) : ($produk->harga_diskon ?? $produk->harga);
        $totalHarga = $harga * $jumlah;

        if (!$isKustom) {
            $produk->stok -= $jumlah;
            $produk->save();
        }

        $buktiTransferPath = null;
        if ($request->metode_pembayaran === 'transfer' && $request->hasFile('bukti_transfer')) {
            $buktiTransferPath = $request->file('bukti_transfer')->store('bukti_transfer', 'public');
        }

        Pesanan::create([
            'user_id' => $user->id,
            'produk_id' => $isKustom ? null : $produk->id,
            'kaos_kustom_id' => $isKustom ? $produk->id : null,
            'jumlah' => $jumlah,
            'ukuran' => $ukuran,
            'total_harga' => $totalHarga,
            'metode_pembayaran' => $request->metode_pembayaran,
            'rekening_id' => $request->metode_pembayaran === 'transfer' ? $request->rekening_id : null,
            'bukti_transfer' => $buktiTransferPath,
            'status' => 'menunggu',
        ]);

        if ($isKustom) {
            $produk->status = 'draf';
            $produk->save();
        }

        // Kirim notifikasi ke Telegram
        $message = "📢 <b>Pesanan Baru!</b>\n\n"
            . "👤 User: {$user->nama}\n"
            . "🛒 Produk: " . ($isKustom ? "Kaos Kustom" : $produk->nama) . "\n"
            . "📦 Jumlah: {$jumlah}\n"
            . "📏 Ukuran: {$ukuran}\n"
            . "💰 Total: Rp" . number_format($totalHarga, 0, ',', '.') . "\n"
            . "💳 Metode: {$request->metode_pembayaran}\n"
            . "⏰ Status: Menunggu";

        TelegramHelper::sendMessage($message);

        $item->delete();

        return redirect()->route('pesanan.user.index')->with('success', 'Pesanan berhasil dibuat.');
    }
}
