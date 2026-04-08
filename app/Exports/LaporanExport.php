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
        $peminjamans = Peminjaman::with('buku')
            ->when($this->bulan, fn($q) => $q->whereMonth('tanggal_pinjam', $this->bulan))
            ->get();

        $dendas = Denda::when($this->bulan, fn($q) => $q->whereMonth('created_at', $this->bulan))
            ->get();

        // Pakai satu file view saja yang isinya gabungan
        return view('kepala.exports.gabungan-excel', compact('peminjamans', 'dendas'));
    }
}