@extends('layouts.kepala')

@section('title', 'Laporan')

@section('content')

{{-- Judul --}}
<h1 class="text-2xl font-bold text-gray-800 mb-6">Laporan</h1>

{{-- Filter & Tombol Export --}}
<div class="flex items-center gap-2 mb-6">
    <form method="GET" action="{{ route('kepala.laporan') }}" class="flex items-center gap-2">
        <select name="bulan" class="border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white">
            <option value="">Semua Bulan</option>
            @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $bln)
                <option value="{{ $i+1 }}" {{ request('bulan') == $i+1 ? 'selected' : '' }}>{{ $bln }}</option>
            @endforeach
        </select>
        <select name="tahun" class="border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white">
            @for($y = now()->year; $y >= now()->year - 3; $y--)
                <option value="{{ $y }}" {{ request('tahun', now()->year) == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
        </select>
        <button type="submit" class="px-4 py-2 rounded-lg text-white text-sm" style="background-color:#db2777;">Filter</button>
    </form>

    {{-- Tombol Export --}}
    <a href="{{ route('kepala.laporan.pdf', request()->query()) }}"
        class="px-4 py-2 rounded-lg text-white text-sm" style="background-color:#9d174d;">
        📄 Export PDF
    </a>
    <a href="{{ route('kepala.laporan.excel', request()->query()) }}"
        class="px-4 py-2 rounded-lg text-white text-sm" style="background-color:#065f46;">
        📊 Export Excel
    </a>
    <button onclick="window.print()"
        class="px-4 py-2 rounded-lg text-white text-sm" style="background-color:#1d4ed8;">
        🖨️ Print
    </button>
</div>

{{-- Rekap Bulanan --}}
<div class="bg-white rounded-xl shadow p-5 mb-6">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Rekap Bulanan</h2>
    <div style="display:grid; grid-template-columns: repeat(12, 1fr); gap: 12px;">
        @php
            $namaBulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];
        @endphp
        @foreach($namaBulan as $i => $bln)
            @php
                $data = $rekapBulanan->firstWhere('bulan', $i+1);
                $total = $data ? $data->total : 0;
            @endphp
            <div class="text-center rounded-lg p-3" style="background:#fdf2f8;">
                <p class="text-xs text-gray-500">{{ $bln }}</p>
                <p class="text-xl font-bold mt-1" style="color:#db2777;">{{ $total }}</p>
            </div>
        @endforeach
    </div>
</div>

{{-- Laporan Peminjaman --}}
<div class="bg-white rounded-xl shadow mb-6" style="overflow-x:auto;">
    <div class="px-5 py-4 border-b">
        <h2 class="text-lg font-semibold text-gray-800">Laporan Peminjaman</h2>
    </div>
    <table class="w-full text-sm">
        <thead style="background-color:#db2777;">
            <tr>
                <th class="text-left px-4 py-3 text-white">No</th>
                <th class="text-left px-4 py-3 text-white">ID Peminjaman</th>
                <th class="text-left px-4 py-3 text-white">Nama Anggota</th>
                <th class="text-left px-4 py-3 text-white">Buku</th>
                <th class="text-left px-4 py-3 text-white">Tgl Pinjam</th>
                <th class="text-left px-4 py-3 text-white">Tgl Kembali</th>
                <th class="text-left px-4 py-3 text-white">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peminjamans as $i => $p)
            <tr class="border-t" style="background:{{ $i % 2 == 0 ? '#fff' : '#fdf2f8' }}">
                <td class="px-4 py-3">{{ $i + 1 }}</td>
                <td class="px-4 py-3">{{ $p->id_peminjaman }}</td>
                <td class="px-4 py-3">{{ $p->nama_anggota }}</td>
                <td class="px-4 py-3">{{ $p->buku->judul ?? '-' }}</td>
                <td class="px-4 py-3">{{ $p->tanggal_pinjam }}</td>
                <td class="px-4 py-3">{{ $p->tanggal_kembali ?? '-' }}</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-1 rounded-full text-xs font-medium"
                        style="background:{{ $p->status == 'dikembalikan' ? '#d1fae5' : ($p->status == 'dipinjam' ? '#fce7f3' : '#fef3c7') }};
                               color:{{ $p->status == 'dikembalikan' ? '#065f46' : ($p->status == 'dipinjam' ? '#9d174d' : '#92400e') }}">
                        {{ ucfirst($p->status) }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-8 text-gray-400">Tidak ada data peminjaman.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Laporan Denda --}}
<div class="bg-white rounded-xl shadow" style="overflow-x:auto;">
    <div class="px-5 py-4 border-b">
        <h2 class="text-lg font-semibold text-gray-800">Laporan Denda</h2>
    </div>
    <table class="w-full text-sm">
        <thead style="background-color:#db2777;">
            <tr>
                <th class="text-left px-4 py-3 text-white">No</th>
                <th class="text-left px-4 py-3 text-white">Nama Anggota</th>
                <th class="text-left px-4 py-3 text-white">Judul Buku</th>
                <th class="text-left px-4 py-3 text-white">Hari Terlambat</th>
                <th class="text-left px-4 py-3 text-white">Denda/Hari</th>
                <th class="text-left px-4 py-3 text-white">Total Denda</th>
                <th class="text-left px-4 py-3 text-white">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dendas as $i => $d)
            <tr class="border-t" style="background:{{ $i % 2 == 0 ? '#fff' : '#fdf2f8' }}">
                <td class="px-4 py-3">{{ $i + 1 }}</td>
                <td class="px-4 py-3">{{ $d->nama_anggota }}</td>
                <td class="px-4 py-3">{{ $d->judul_buku }}</td>
                <td class="px-4 py-3">{{ $d->hari_terlambat }} hari</td>
                <td class="px-4 py-3">Rp {{ number_format($d->denda_per_hari, 0, ',', '.') }}</td>
                <td class="px-4 py-3">Rp {{ number_format($d->total_denda, 0, ',', '.') }}</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-1 rounded-full text-xs font-medium"
                        style="background:{{ $d->status_bayar == 'lunas' ? '#d1fae5' : '#fce7f3' }};
                               color:{{ $d->status_bayar == 'lunas' ? '#065f46' : '#9d174d' }}">
                        {{ ucfirst($d->status_bayar) }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-8 text-gray-400">Tidak ada data denda.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection