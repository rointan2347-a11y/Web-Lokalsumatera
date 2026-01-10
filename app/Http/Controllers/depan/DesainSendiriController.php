<?php

namespace App\Http\Controllers\depan;

use App\Http\Controllers\Controller;
use App\Models\DesainKaos;
use App\Models\KaosKustom;
use App\Models\KeranjangItem;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DesainSendiriController extends Controller
{
    public function index()
    {

        $user = Auth::user();

        // Cek apakah user sudah punya biodata
        if (!$user->biodata) {
            return redirect()->route('biodata.create')->with('warning', 'Silakan lengkapi biodata terlebih dahulu.');
        }

        $desainAdmin = DesainKaos::where('desain_default', true)->get();

        $desainUser = DesainKaos::where('user_id', Auth::id())
            ->where('desain_default', false)
            ->get();

        return view('depan.desain_sendiri.desain_sendiri',  compact('desainAdmin', 'desainUser'));
    }

    public function desainSendiriSimpan(Request $request)
    {
        $request->validate([
            'warna_kaos' => 'required|string',
            'ukuran_kaos' => 'required|string',
            'desain_depan' => 'required|string',
            'desain_belakang' => 'required|string',
            'teks_custom' => 'nullable|string',
            'total_harga' => 'required|integer|min:0', // Tambahkan validasi ini
        ]);

        // Simpan gambar depan
        $imageNameDepan = 'depan_' . time() . '.png';
        $imagePathDepan = public_path('storage/kustom_desain/' . $imageNameDepan);
        $base64Depan = str_replace('data:image/png;base64,', '', $request->desain_depan);
        file_put_contents($imagePathDepan, base64_decode($base64Depan));

        // Simpan gambar belakang
        $imageNameBelakang = 'belakang_' . time() . '.png';
        $imagePathBelakang = public_path('storage/kustom_desain/' . $imageNameBelakang);
        $base64Belakang = str_replace('data:image/png;base64,', '', $request->desain_belakang);
        file_put_contents($imagePathBelakang, base64_decode($base64Belakang));

        // Ambil data dari request
        $warna = $request->warna_kaos;
        $ukuran = $request->ukuran_kaos;
        $harga = $request->total_harga;

        // Simpan ke database
        KaosKustom::create([
            'user_id' => auth()->id(),
            'desain_depan' => 'kustom_desain/' . $imageNameDepan,
            'desain_belakang' => 'kustom_desain/' . $imageNameBelakang,
            'warna' => $warna,
            'ukuran' => $ukuran,
            'teks_kustom' => $request->teks_custom,
            'harga' => $harga,
            'status' => 'draf',
        ]);

        return redirect()->back()->with('success', 'Desain berhasil disimpan!');
    }

    public function showPreview()
    {
        // $userDesigns = KaosKustom::where('user_id', auth()->id())->get();
        $userDesigns = KaosKustom::aktif()->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')->get();


        foreach ($userDesigns as $design) {
            // Tambahkan properti dinamis 'is_locked' jika desain dipakai di pesanan aktif
            $design->is_locked = Pesanan::where('kaos_kustom_id', $design->id)
                ->whereNotIn('status', ['selesai', 'dibatalkan'])
                ->exists();
        }

        return view('depan.desain_sendiri.preview-desain', compact('userDesigns'));
    }

    public function uploadDesainUser(Request $request)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:png|max:5120',
        ]);

        $path = $request->file('gambar')->store('desain_kaos', 'public');

        DesainKaos::create([
            'gambar' => $path,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Desain berhasil diupload.');
    }

    public function userDesainUploadHapus($id)
    {
        $desain = DesainKaos::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        // Hapus file dari storage
        if (Storage::exists($desain->gambar)) {
            Storage::delete($desain->gambar);
        }

        // Hapus dari database
        $desain->delete();

        return back()->with('success', 'Desain berhasil dihapus.');
    }


    public function saranUkuran()
    {
        return view('depan.desain_sendiri.saran_ukuran');
    }
    public function cekUkuran(Request $request, \App\Services\AiFittingService $aiService)
    {
        $berat = $request->berat;
        $tinggi = $request->tinggi;
        $lingkarDada = $request->lingkar_dada; // Opsional
        $panjangBaju = $request->panjang_baju; // Opsional
        $warna = $request->warna;
        $ketebalan = $request->ketebalan;

        $ukuran = 'L'; // Default fallback
        $saran = "Berdasarkan estimasi standar.";

        // Prevent division by zero
        if ($tinggi <= 0 || $berat <= 0) {
             return response()->json([
                'ukuran' => '-',
                'saran' => 'Mohon masukkan tinggi dan berat badan yang valid.',
                'produk' => [],
                'pesan_tambahan' => 'Data tidak valid.'
            ]);
        }

        if ($lingkarDada) {
            if ($lingkarDada < 90) {
                $ukuran = 'S';
            } elseif ($lingkarDada < 96) {
                $ukuran = 'M';
            } elseif ($lingkarDada < 102) {
                $ukuran = 'L';
            } elseif ($lingkarDada < 110) {
                $ukuran = 'XL';
            } elseif ($lingkarDada < 118) {
                $ukuran = 'XXL';
            } else {
                $ukuran = 'XXXL';
            }
            $saran = "Analisis berdasarkan Lingkar Dada ($lingkarDada cm) memberikan hasil paling akurat.";
        } else {
            $tinggiMeter = $tinggi / 100;
            $bmi = $berat / ($tinggiMeter * $tinggiMeter);

            if ($bmi < 18.5) {
                $ukuran = ($tinggi < 170) ? 'S' : 'M';
            } elseif ($bmi < 25) {
                if ($tinggi < 165) $ukuran = 'S';
                elseif ($tinggi < 175) $ukuran = 'M';
                elseif ($tinggi < 180) $ukuran = 'L';
                else $ukuran = 'XL';
            } elseif ($bmi < 30) {
                if ($tinggi < 160) $ukuran = 'M';
                elseif ($tinggi < 170) $ukuran = 'L';
                elseif ($tinggi < 180) $ukuran = 'XL';
                else $ukuran = 'XXL';
            } else {
                if ($tinggi < 160) $ukuran = 'L'; 
                elseif ($tinggi < 170) $ukuran = 'XL';
                elseif ($tinggi < 180) $ukuran = 'XXL';
                else $ukuran = 'XXXL';
            }
            $saran = "Analisis kombinasi Tinggi ($tinggi cm) & Berat ($berat kg).";
        }

        // 1. Ambil Produk Kandidat (Filtering)
        $kandidatProduk = \App\Models\Produk::with('ulasan')->where(function ($q) use ($warna) {
            $q->where('warna', 'LIKE', '%' . $warna . '%')
                ->orWhere('nama', 'LIKE', '%' . $warna . '%');
        })
            ->where(function ($q) use ($ketebalan) {
                $q->where('ketebalan', $ketebalan)
                    ->orWhere('deskripsi', 'LIKE', '%' . $ketebalan . '%');
            })
            ->get();

        // 2. Ranking dengan Metode SAW
        $rekomendasiProduk = $aiService->rankingSAW($kandidatProduk);

        // 3. Ambil Saran Personal dari OpenRouter AI
        $saranAI = $aiService->getAiAdvice([
            'tinggi' => $tinggi,
            'berat' => $berat,
            'ukuran' => $ukuran,
            'warna' => $warna,
            'ketebalan' => $ketebalan
        ]);

        if ($rekomendasiProduk->isEmpty()) {
            $pesanTamabahan = "Mohon maaf, artikel dengan spesifikasi tersebut belum tersedia saat ini.";
        } else {
            $pesanTamabahan = $saranAI; // Gunakan saran dari AI sebagai pesan tambahan
        }

        return response()->json([
            'ukuran' => $ukuran,
            'saran' => $saran,
            'produk' => $rekomendasiProduk,
            'pesan_tambahan' => $pesanTamabahan
        ]);
    }

    public function hapusDesainSaya($id)
    {
        $desain = KaosKustom::findOrFail($id);

        $adaDiKeranjang = KeranjangItem::where('kaos_kustom_id', $desain->id)->exists();
        if ($adaDiKeranjang) {
            return redirect()->back()->with('error', 'Desain tidak dapat dihapus karena masih ada di keranjang.');
        }
        // Cek apakah desain sedang digunakan dalam pesanan aktif
        $digunakan = Pesanan::where('kaos_kustom_id', $desain->id)
            ->whereNotIn('status', ['selesai', 'dibatalkan'])
            ->exists();

        if ($digunakan) {
            return redirect()->back()->with('error', 'Desain tidak dapat dihapus karena sedang dalam proses pesanan.');
        }

        // Cek apakah desain pernah dipakai dalam pesanan (selesai/dibatalkan)
        $pernahDipakai = Pesanan::where('kaos_kustom_id', $desain->id)->exists();

        if ($pernahDipakai) {
            // Tandai sebagai dihapus tanpa menghapus file
            $desain->is_deleted = true;
            $desain->save();

            return redirect()->back()->with('success', 'Desain ditandai sebagai dihapus karena pernah digunakan.');
        }

        // Jika belum pernah dipakai, aman untuk hapus file & data
        $depanPath = public_path('storage/' . $desain->desain_depan);
        if (file_exists($depanPath)) {
            unlink($depanPath);
        }

        $belakangPath = public_path('storage/' . $desain->desain_belakang);
        if (file_exists($belakangPath)) {
            unlink($belakangPath);
        }

        $desain->delete();

        return redirect()->back()->with('success', 'Desain berhasil dihapus.');
    }
}
