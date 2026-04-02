<?php

namespace App\Exports;

use App\Models\Denda;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class DendaSheet implements FromCollection, WithHeadings, WithTitle
{
    public function __construct(
        protected $bulan = null,
        protected $tahun = null
    ) {}

    public function title(): string { return 'Denda'; }

    public function headings(): array
    {
        return ['No', 'Nama Anggota', 'Judul Buku', 'Hari Terlambat', 'Denda/Hari', 'Total Denda', 'Status'];
    }

    public function collection()
    {
        return Denda::when($this->bulan, fn($q) => $q
                ->whereMonth('created_at', $this->bulan)
                ->whereYear('created_at', $this->tahun ?? now()->year))
            ->get()
            ->map(fn($d, $i) => [
                $i + 1,
                $d->nama_anggota,
                $d->judul_buku,
                $d->hari_terlambat . ' hari',
                'Rp ' . number_format($d->denda_per_hari, 0, ',', '.'),
                'Rp ' . number_format($d->total_denda, 0, ',', '.'),
                $d->status_bayar,
            ]);
    }
}