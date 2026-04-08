<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil (SAMA KAYA PETUGAS: Pakai folder anggota)
     */
    public function edit(Request $request): View
    {
        // Perbaikan utama: Tambahkan 'anggota.' agar tidak error "View Not Found"
        return view('anggota.profil', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update Profil & Foto (SAMA KAYA PETUGAS: Masuk ke folder foto-profil)
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'no_telepon' => 'nullable|string|max:20',
            'username' => 'required|string|max:255|unique:users,username,'.$user->id,
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        if ($request->hasFile('foto')) {
            // Hapus foto lama agar storage tidak penuh
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }

            // Simpan foto ke folder yang sama dengan petugas
            $path = $request->file('foto')->store('foto-profil', 'public');
            
            // Masukkan path ke kolom foto (Ini yang bikin database tidak NULL lagi)
            $user->foto = $path;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->no_telepon = $request->no_telepon;
        $user->username = $request->username;

        $user->save();

        // Redirect balik ke rute profil anggota
        return redirect()->route('anggota.profil')->with('success', 'Profil dan foto berhasil diperbarui!');
    }

    /**
     * Hapus akun
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}