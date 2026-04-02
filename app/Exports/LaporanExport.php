<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LaporanExport implements WithMultipleSheets
{
    public function __construct(
        protected $bulan = null,
        protected $tahun = null
    ) {}

   public function sheets(): array
{
    return [
        'Peminjaman' => new PeminjamanSheet($this->bulan, $this->tahun),
        'Denda'      => new DendaSheet($this->bulan, $this->tahun),
    ];
}

}