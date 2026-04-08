<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PeminjamanSheet implements FromView, WithTitle, ShouldAutoSize
{
    public function __construct(protected $bulan, protected $tahun) {}

    public function title(): string { return 'Peminjaman'; }

    public function view(): View
    {
        $peminjamans = Peminjaman::with('buku')
            ->when($this->bulan, function ($query) {
                $query->whereMonth('tanggal_pinjam', $this->bulan)
                      ->whereYear('tanggal_pinjam', $this->tahun ?? now()->year);
            })->get();

        return view('kepala.exports.peminjaman-excel', compact('peminjamans'));
    }
}