<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    /**
     * Tampilkan daftar anggota yang sudah registrasi
     * Hanya bisa diakses oleh petugas
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
     * Hapus anggota dari tabel users
     * Hanya bisa diakses oleh petugas
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil dihapus!');
    }
}