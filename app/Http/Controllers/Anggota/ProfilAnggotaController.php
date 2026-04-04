<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilAnggotaController extends Controller
{
    /**
     * Tampilkan halaman profil anggota
     */
    public function show()
    {
        return view('anggota.profil');
    }

    /**
     * Update data profil anggota (nama, email, no telepon, username)
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi input profil
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $user->id,
            'no_telepon' => 'required|string|max:20',
            'username'   => 'required|string|max:50|unique:users,username,' . $user->id,
        ]);

        // Update data user
        $user->update([
            'name'       => $request->name,
            'email'      => $request->email,
            'no_telepon' => $request->no_telepon,
            'username'   => $request->username,
        ]);

        return redirect()->route('anggota.profil')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Ganti password anggota
     */
    public function gantiPassword(Request $request)
    {
        $user = Auth::user();

        // Validasi input password
        $request->validate([
            'password_lama' => 'required',
            'password'      => 'required|min:8|confirmed',
        ]);

        // Cek password lama
        if (!Hash::check($request->password_lama, $user->password)) {
            return back()->withErrors(['password_lama' => 'Password lama tidak sesuai!']);
        }

        // Update password baru
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('anggota.profil')->with('success', 'Password berhasil diganti!');
    }
}