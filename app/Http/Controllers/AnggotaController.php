<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    /**
     * Tampilkan daftar anggota — untuk PETUGAS
     * Bisa filter by nama atau email via ?search=...
     */
    public function index(Request $request)
    {
        $anggota = User::where('role', 'anggota')
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('email', 'like', '%' . $request->search . '%');
            })->get();

        return view('petugas.anggota.index', compact('anggota'));
    }

    /**
     * Tampilkan daftar anggota — untuk KEPALA (view berbeda)
     * Bisa filter by nama atau email via ?search=...
     */
    public function indexKepala(Request $request)
    {
        $anggota = User::where('role', 'anggota')
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('email', 'like', '%' . $request->search . '%');
            })->get();

        return view('kepala.anggota.index', compact('anggota'));
    }

    /**
     * Tampilkan form edit anggota
     * Dipanggil saat petugas klik tombol Edit di tabel
     */
    public function edit($id)
    {
        // Cari anggota by ID, kalau tidak ketemu otomatis 404
        $anggota = User::findOrFail($id);

        return view('petugas.anggota.edit', compact('anggota'));
    }

    /**
     * Simpan perubahan data anggota
     * Password hanya diupdate kalau diisi, kalau kosong dibiarkan
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $id,
            'no_telepon' => 'nullable|string|max:20',
            'username'   => 'nullable|string|max:50|unique:users,username,' . $id,
            'password'   => 'nullable|string|min:6',
        ]);

        $anggota = User::findOrFail($id);

        $anggota->name       = $request->name;
        $anggota->email      = $request->email;
        $anggota->no_telepon = $request->no_telepon;
        $anggota->username   = $request->username;

        // Hanya update password kalau field password diisi
        if ($request->filled('password')) {
            $anggota->password = Hash::make($request->password);
        }

        $anggota->save();

        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil diupdate!');
    }

    /**
     * Hapus anggota dari database
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil dihapus!');
    }
}