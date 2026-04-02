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

        return view('kepala.katalog', compact('bukus', 'kategoris'));
    }

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

    public function exportPdf(Request $request)
    {
        $peminjamans = Peminjaman::with('buku')
            ->when($request->bulan, function ($query) use ($request) {
                $query->whereMonth('tanggal_pinjam', $request->bulan)
                      ->whereYear('tanggal_pinjam', $request->tahun ?? now()->year);
            })
            ->latest()->get();

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

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new LaporanExport($request->bulan, $request->tahun),
            'laporan-perpustakaan.xlsx'
        );
    }
}