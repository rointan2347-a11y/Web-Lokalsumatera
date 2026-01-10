<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', 'admin')->withCount('pesanan')->get(); // hitung jumlah pesanan per user
        return view('admin.user.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::with(['biodata', 'pesanan.produk', 'pesanan.kaosKustom'])->findOrFail($id);
        return view('admin.user.show', compact('user'));
    }
}
