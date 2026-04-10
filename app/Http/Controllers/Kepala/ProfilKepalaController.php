<?php

namespace App\Http\Controllers\Kepala;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfilKepalaController extends Controller
{
    /**
     * Menampilkan halaman profil kepala perpustakaan
     */
    public function show()
    {
        return view('kepala.profil', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Update nama dan email kepala
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Ganti password kepala dengan verifikasi password lama
     */
    public function gantiPassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'password_lama'         => 'required',
            'password'              => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

        // Cek apakah password lama sesuai
        if (!Hash::check($request->password_lama, $user->password)) {
            return back()->withErrors(['password_lama' => 'Password lama tidak cocok!']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diubah!');
    }

    /**
     * Update foto profil kepala
     * Foto lama akan dihapus otomatis sebelum foto baru disimpan
     */
    public function updateFoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();

        // Hapus foto lama dari storage jika ada
        if ($user->foto && Storage::disk('public')->exists($user->foto)) {
            Storage::disk('public')->delete($user->foto);
        }

        // Simpan foto baru ke storage/app/public/foto-profil
        $path = $request->file('foto')->store('foto-profil', 'public');

        $user->update(['foto' => $path]);

        return back()->with('success', 'Foto berhasil diperbarui!');
    }
}