<?php

namespace App\Exports;

use App\Models\Peminjaman;
use App\Models\Denda;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanExport implements FromView, ShouldAutoSize
{
    public function __construct(protected $bulan, protected $tahun) {}

    public function view(): View
{
    // Tambahkan 'buku.kategori' agar data kategorinya ikut terambil (Eager Loading)
    $peminjamans = Peminjaman::with(['buku.kategori'])
        ->when($this->bulan, fn($q) => $q->whereMonth('tanggal_pinjam', $this->bulan))
        ->get();

    $dendas = Denda::when($this->bulan, fn($q) => $q->whereMonth('created_at', $this->bulan))
        ->get();

    
    return view('kepala.exports.gabungan-excel', compact('peminjamans', 'dendas'));
}
}