<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\Denda;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;
use Illuminate\Http\Request;

class KepalaController extends Controller
{
    // =====================
    // DASHBOARD
    // =====================
    public function dashboard()
    {
        $totalBuku       = Buku::count();
        $totalAnggota    = User::where('role', 'anggota')->count();
        $totalPetugas    = User::where('role', 'petugas')->count();
        $peminjamanAktif = Peminjaman::where('status', 'dipinjam')->count();

        // ambil 5 buku terbaru
        $buku = Buku::latest()->take(5)->get();

        return view('dashboard.kepala', compact(
            'totalBuku',
            'totalAnggota',
            'totalPetugas',
            'peminjamanAktif',
            'buku'
        ));
    }

    // =====================
    // KATALOG ✅ SUDAH DIPERBAIKI
    // =====================
    public function katalog(Request $request)
    {
        $bukus = Buku::with('kategori')
            ->when($request->search, function ($query) use ($request) {
                $query->where('judul', 'like', '%' . $request->search . '%')
                      ->orWhere('pengarang', 'like', '%' . $request->search . '%');
            })
            ->when($request->kategori_id, function ($query) use ($request) {
                $query->where('kategori_id', $request->kategori_id);
            })
            ->get();

        $kategoris = Kategori::all();

        // 🔥 FIX DI SINI
        return view('kepala.katalog.index', compact('bukus', 'kategoris'));
    }

    // =====================
    // LAPORAN
    // =====================
    public function laporan(Request $request)
    {
        $peminjamans = Peminjaman::with('buku')
            ->when($request->bulan, function ($query) use ($request) {
                $query->whereMonth('tanggal_pinjam', $request->bulan)
                      ->whereYear('tanggal_pinjam', $request->tahun ?? now()->year);
            })
            ->latest()
            ->get();

        $dendas = Denda::with('peminjaman')
            ->when($request->bulan, function ($query) use ($request) {
                $query->whereMonth('created_at', $request->bulan)
                      ->whereYear('created_at', $request->tahun ?? now()->year);
            })
            ->get();

        $rekapBulanan = Peminjaman::selectRaw('MONTH(tanggal_pinjam) as bulan, COUNT(*) as total')
            ->whereYear('tanggal_pinjam', $request->tahun ?? now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        return view('kepala.laporan', compact('peminjamans', 'dendas', 'rekapBulanan'));
    }

    // =====================
    // EXPORT PDF
    // =====================
    public function exportPdf(Request $request)
    {
        $peminjamans = Peminjaman::with('buku')
            ->when($request->bulan, function ($query) use ($request) {
                $query->whereMonth('tanggal_pinjam', $request->bulan)
                      ->whereYear('tanggal_pinjam', $request->tahun ?? now()->year);
            })
            ->latest()
            ->get();

        $dendas = Denda::with('peminjaman')
            ->when($request->bulan, function ($query) use ($request) {
                $query->whereMonth('created_at', $request->bulan)
                      ->whereYear('created_at', $request->tahun ?? now()->year);
            })
            ->get();

        $pdf = Pdf::loadView('kepala.laporan-pdf', compact('peminjamans', 'dendas'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-perpustakaan.pdf');
    }

    // =====================
    // EXPORT EXCEL
    // =====================
    public function exportExcel(Request $request)
    {
        return Excel::download(
            new LaporanExport($request->bulan, $request->tahun),
            'laporan-perpustakaan.xlsx'
        );
    }

    // =====================
    // DATA PETUGAS
    // =====================
    public function indexPetugas(Request $request)
    {
        $petugas = User::where('role', 'petugas')
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('email', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->get();

        return view('kepala.petugas.index', compact('petugas'));
    }

    public function createPetugas()
    {
        return view('kepala.petugas.create');
    }

    public function storePetugas(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'role'     => 'petugas',
        ]);

        return redirect()->route('kepala.petugas.index')
                         ->with('success', 'Petugas berhasil ditambahkan!');
    }

    public function editPetugas($id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);
        return view('kepala.petugas.edit', compact('petugas'));
    }

    public function updatePetugas(Request $request, $id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        

        $petugas->update([
            'name'  => $request->name,
            'email' => $request->email,
            ...($request->filled('password')
                ? ['password' => bcrypt($request->password)]
                : []),
        ]);

        return redirect()->route('kepala.petugas.index')
                         ->with('success', 'Data petugas berhasil diperbarui!');
    }

    public function destroyPetugas($id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);
        $petugas->delete();

        return redirect()->route('kepala.petugas.index')
                         ->with('success', 'Petugas berhasil dihapus!');
    }
}