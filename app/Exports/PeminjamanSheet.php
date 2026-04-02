<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class PeminjamanSheet implements FromCollection, WithHeadings, WithTitle
{
    public function __construct(
        protected $bulan = null,
        protected $tahun = null
    ) {}

    public function title(): string { return 'Peminjaman'; }

    public function headings(): array
    {
        return ['No', 'ID Peminjaman', 'Nama Anggota', 'Buku', 'Tgl Pinjam', 'Tgl Kembali', 'Status'];
    }

    public function collection()
    {
        return Peminjaman::with('buku')
            ->when($this->bulan, fn($q) => $q
                ->whereMonth('tanggal_pinjam', $this->bulan)
                ->whereYear('tanggal_pinjam', $this->tahun ?? now()->year))
            ->latest()
            ->get()
            ->map(fn($p, $i) => [
                $i + 1,
                $p->id_peminjaman,
                $p->nama_anggota,
                $p->buku->judul ?? '-',
                $p->tanggal_pinjam,
                $p->tanggal_kembali ?? '-',
                $p->status,
            ]);
    }
}