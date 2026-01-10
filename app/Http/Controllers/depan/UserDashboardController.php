<?php

namespace App\Http\Controllers\depan;

use App\Http\Controllers\Controller;
use App\Models\KaosKustom;
use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function userDashboard()
    {

        $user = Auth::user();

        $role = $user->role;

        if ($role == 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $produk = Produk::count();
        $desainSaya = KaosKustom::where('user_id', $user->id)->count();
        $keranjang = Keranjang::where('user_id', $user->id)->first();

        $keranjangItem = 0;

        if ($keranjang) {
            $keranjangItem = $keranjang->items()->with('produk')->count();
        }
        // Cek apakah user sudah punya biodata
        if (!$user->biodata) {
            return redirect()->route('biodata.create')->with('warning', 'Silakan lengkapi biodata terlebih dahulu.');
        }

        return view('depan.userDashboard', compact('produk', 'desainSaya', 'keranjangItem'));
    }
}
