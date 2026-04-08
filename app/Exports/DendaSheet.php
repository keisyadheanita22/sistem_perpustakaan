<?php

namespace App\Exports;

use App\Models\Denda;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DendaSheet implements FromView, WithTitle, ShouldAutoSize
{
    public function __construct(protected $bulan, protected $tahun) {}

    public function title(): string { return 'Denda'; }

    public function view(): View
    {
        $dendas = Denda::when($this->bulan, function ($query) {
                // Sesuaikan kolom tgl di tabel denda kamu, biasanya created_at
                $query->whereMonth('created_at', $this->bulan)
                      ->whereYear('created_at', $this->tahun ?? now()->year);
            })->get();

        return view('kepala.exports.denda-excel', compact('dendas'));
    }
}