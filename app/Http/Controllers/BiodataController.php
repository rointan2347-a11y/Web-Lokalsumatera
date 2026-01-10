<?php

namespace App\Http\Controllers;

use App\Models\Biodata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BiodataController extends Controller
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
        return view('auth.biodata');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki - laki,Perempuan',
            'telepon' => 'required|string|max:20',
            'alamat_lengkap' => 'required|string',
        ]);

        // Update nama di tabel user
        $user = auth()->user();
        $user->nama = $request->nama;
        $user->save();

        // Simpan biodata baru
        Biodata::create([
            'user_id' => $user->id,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'telepon' => $request->telepon,
            'alamat_lengkap' => $request->alamat_lengkap,
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Biodata berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Biodata $biodata)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Biodata $biodata)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Biodata $biodata)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Biodata $biodata)
    {
        //
    }


    public function showProfile()
    {
        return view('depan.user-profile.profile', [
            'user' => Auth::user()
        ]);
    }
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:user,email,' . $user->id,
            'telepon' => 'nullable|string|max:20',
            'alamat_lengkap' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
        ]);

        $biodataData = [
            'telepon' => $request->telepon,
            'alamat_lengkap' => $request->alamat_lengkap,
        ];

        // Handle Photo Upload
        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($user->biodata && $user->biodata->foto) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->biodata->foto);
            }

            $path = $request->file('foto')->store('profile_photos', 'public');
            $biodataData['foto'] = $path;
        }

        // Update atau buat biodata
        $user->biodata()->updateOrCreate(
            ['user_id' => $user->id],
            $biodataData
        );

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui.');
    }

    public function updateLogin(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username' => 'required|string|max:255|unique:user,username,' . $user->id,
            'email' => 'required|email|max:255|unique:user,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->username = $request->username;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return back()->with('success', 'Informasi login berhasil diperbarui.');
    }
}
