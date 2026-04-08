<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    /**
     * Untuk PETUGAS
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
     * Untuk KEPALA — view berbeda!
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
     * Hapus anggota
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil dihapus!');
    }
}