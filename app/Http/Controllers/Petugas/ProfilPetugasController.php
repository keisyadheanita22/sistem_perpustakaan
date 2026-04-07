<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; // ✅ WAJIB INI

class ProfilPetugasController extends Controller
{
    // ================= TAMPILKAN HALAMAN =================
    public function show()
    {
        return view('petugas.profil');
    }

    // ================= UPDATE PROFIL + FOTO =================
    public function update(Request $request)
    {
        $user = Auth::user();

        // validasi input
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'foto'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // update data
        $user->name  = $request->name;
        $user->email = $request->email;

        // 🔥 HANDLE UPLOAD FOTO
        if ($request->hasFile('foto')) {

            // hapus foto lama (kalau ada)
            if ($user->foto) {
                Storage::delete('public/' . $user->foto);
            }

            // simpan foto baru
            $path = $request->file('foto')->store('foto-profil', 'public');

            // simpan ke database
            $user->foto = $path;
        }

        // simpan ke database
        $user->save();

        return redirect()->route('petugas.profil')->with('success', 'Profil berhasil diperbarui!');
    }

    // ================= GANTI PASSWORD =================
    public function gantiPassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'password_lama' => 'required',
            'password'      => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->password_lama, $user->password)) {
            return back()->withErrors(['password_lama' => 'Password lama tidak sesuai!']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('petugas.profil')->with('success', 'Password berhasil diganti!');
    }
}