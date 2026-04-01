<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class KepalaController extends Controller
{
    public function dashboard()
    {
        $totalBuku       = Buku::count();
        $totalAnggota    = User::where('role', 'anggota')->count();
        $totalPetugas    = User::where('role', 'petugas')->count();
        $peminjamanAktif = Peminjaman::where('status', 'dipinjam')->count();

        return view('dashboard.kepala', compact(
            'totalBuku',
            'totalAnggota',
            'totalPetugas',
            'peminjamanAktif'
        ));
    }
}