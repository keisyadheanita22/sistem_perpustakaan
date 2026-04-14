<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan – Sistem Perpustakaan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- CSS khusus untuk mode print: sembunyikan navbar, sidebar, dan rapikan tampilan --}}
    <style>
    @media print {
        nav, aside { display: none !important; }
        body { background-color: #fff !important; }
        main { padding: 16px !important; }
        div[style*="display: flex; min-height"] { display: block !important; }
    }
    </style>
</head>

<body style="margin: 0; background-color: #F5F0E8; font-family: ui-sans-serif, system-ui; box-sizing: border-box;">

{{-- NAVBAR --}}
<nav style="background-color: #2D3A1E; height: 56px; padding: 0 32px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; border-bottom: 2px solid #D4A017;">
    <span style="color: #F5F0E8; font-size: 17px; font-weight: bold; font-style: italic;">Sistem Perpustakaan</span>

    {{-- DROPDOWN PROFIL --}}
    <div id="profileWrapper" style="position: relative;">
        <button onclick="toggleDropdown()" style="display: flex; align-items: center; gap: 8px; color: #F5F0E8; font-size: 14px; cursor: pointer; background: none; border: none; padding: 6px 10px; border-radius: 8px;">
            @if(Auth::user()->foto)
                <img src="{{ asset('storage/' . Auth::user()->foto) }}" style="width: 34px; height: 34px; border-radius: 50%; object-fit: cover; border: 2px solid #D4A017;" alt="Profile">
            @else
                {{-- Inisial nama jika tidak ada foto --}}
                <div style="width: 34px; height: 34px; border-radius: 50%; background-color: #D4A017; color: #2D3A1E; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            @endif
            <span>{{ Auth::user()->name }}</span>
            <svg id="chevronIcon" style="width: 14px; height: 14px; transition: transform 0.2s; opacity: 0.8;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        {{-- MENU DROPDOWN --}}
        <div id="dropdownMenu" style="display: none; position: absolute; top: calc(100% + 8px); right: 0; background: #FFFDF8; border: 1px solid #DDD6C8; border-radius: 12px; min-width: 180px; box-shadow: 0 8px 24px rgba(45,58,30,0.15); overflow: hidden; z-index: 100;">
            <div style="padding: 12px 16px; border-bottom: 1px solid #E8E2D4; background: #F5F0E8;">
                <p style="margin: 0; font-size: 13px; font-weight: 600; color: #2D3A1E;">{{ Auth::user()->name }}</p>
                <p style="margin: 1px 0 0 0; font-size: 11px; color: #8A7E6E;">Kepala Perpustakaan</p>
            </div>
            <a href="{{ route('kepala.profil') }}" style="display: flex; align-items: center; gap: 10px; padding: 10px 16px; font-size: 13px; color: #3A3020; text-decoration: none;">
                <svg style="width: 15px; height: 15px; opacity: 0.7;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Profil Saya
            </a>
            {{-- FORM LOGOUT --}}
            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" style="display: flex; align-items: center; gap: 10px; padding: 10px 16px; font-size: 13px; color: #8B3A3A; cursor: pointer; background: none; border: none; width: 100%; text-align: left;">
                    <svg style="width: 15px; height: 15px; opacity: 0.7;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>

{{-- WRAPPER UTAMA: sidebar + konten --}}
<div style="display: flex; min-height: calc(100vh - 56px); overflow: hidden;">

    {{-- SIDEBAR --}}
    <aside style="width: 176px; background-color: #2D3A1E; padding: 20px 12px; display: flex; flex-direction: column; gap: 6px; flex-shrink: 0;">
        <span style="font-size: 10px; color: #7A9E5A; text-transform: uppercase; letter-spacing: 0.08em; padding: 0 8px; margin: 0 0 4px 0;">Menu Kepala</span>
        <a href="{{ route('kepala.dashboard') }}" style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none; {{ request()->routeIs('kepala.dashboard') ? 'background: #D4A017; color: #2D3A1E; font-weight: 600;' : '' }}">Dashboard</a>
        <a href="{{ route('kepala.petugas.index') }}" style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none; {{ request()->routeIs('kepala.petugas.*') ? 'background: #D4A017; color: #2D3A1E; font-weight: 600;' : '' }}">Data Petugas</a>
        <a href="{{ route('kepala.katalog') }}" style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none; {{ request()->routeIs('kepala.katalog') ? 'background: #D4A017; color: #2D3A1E; font-weight: 600;' : '' }}">Katalog Buku</a>
        <a href="{{ route('kepala.anggota.index') }}" style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none; {{ request()->routeIs('kepala.anggota.*') ? 'background: #D4A017; color: #2D3A1E; font-weight: 600;' : '' }}">Daftar Anggota</a>
        <a href="{{ route('kepala.laporan') }}" style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none; {{ request()->routeIs('kepala.laporan') ? 'background: #D4A017; color: #2D3A1E; font-weight: 600;' : '' }}">Laporan</a>
    </aside>

    {{-- KONTEN UTAMA --}}
    <main style="flex: 1; padding: 32px; overflow: auto; min-width: 0;">

        {{-- JUDUL HALAMAN --}}
        <div style="margin-bottom: 24px;">
            <h1 style="font-size: 22px; font-weight: 700; color: #2D3A1E; margin: 0 0 4px;">Laporan Perpustakaan</h1>
            <p style="font-size: 13px; color: #8A7E6E; margin: 0;">Rekap peminjaman &amp; denda perpustakaan</p>
        </div>

        {{-- FILTER BULAN & TAHUN + TOMBOL EKSPOR --}}
        <div style="background: #FFFDF8; border-radius: 14px; border: 1px solid #E8E2D4; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 10px; padding: 16px 20px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(45,58,30,0.05);">
            <form method="GET" action="{{ route('kepala.laporan') }}" style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                {{-- Dropdown pilih bulan --}}
                <select name="bulan" style="border: 1px solid #DDD6C8; border-radius: 8px; padding: 7px 10px; font-size: 13px; color: #2D3A1E; background: #F5F0E8;">
                    <option value="">Semua Bulan</option>
                    @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $bln)
                        <option value="{{ $i+1 }}" {{ request('bulan') == $i+1 ? 'selected' : '' }}>{{ $bln }}</option>
                    @endforeach
                </select>
                {{-- Dropdown pilih tahun (4 tahun terakhir) --}}
                <select name="tahun" style="border: 1px solid #DDD6C8; border-radius: 8px; padding: 7px 10px; font-size: 13px; color: #2D3A1E; background: #F5F0E8;">
                    @for($y = now()->year; $y >= now()->year - 3; $y--)
                        <option value="{{ $y }}" {{ request('tahun', now()->year) == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
                <button type="submit" style="padding: 7px 18px; border-radius: 8px; background: #2D3A1E; color: #D4A017; font-size: 13px; font-weight: 700; border: none; cursor: pointer;">
                    Filter
                </button>
            </form>

            {{-- TOMBOL EKSPOR PDF, EXCEL & PRINT --}}
            <div style="display: flex; align-items: center; gap: 8px;">
                {{-- Export ke PDF dengan filter bulan/tahun aktif --}}
                <a href="{{ route('kepala.laporan.pdf', request()->query()) }}"
                   style="padding: 7px 14px; border-radius: 8px; background: #8B3A3A; color: #fff; font-size: 13px; font-weight: 600; text-decoration: none;">📄 PDF</a>
                {{-- Export ke Excel dengan filter bulan/tahun aktif --}}
                <a href="{{ route('kepala.laporan.excel', request()->query()) }}"
                   style="padding: 7px 14px; border-radius: 8px; background: #2D3A1E; color: #D4A017; font-size: 13px; font-weight: 600; text-decoration: none;">📊 Excel</a>
                {{-- Tombol print browser --}}
                <button onclick="window.print()"
                        style="padding: 7px 14px; border-radius: 8px; background: #1A2E5A; color: #fff; font-size: 13px; font-weight: 600; border: none; cursor: pointer;">🖨️ Print</button>
            </div>
        </div>
        {{-- AKHIR FILTER & EKSPOR --}}

        {{-- REKAP BULANAN --}}
        <div style="background: #FFFDF8; border-radius: 14px; border: 1px solid #E8E2D4; overflow: hidden; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(45,58,30,0.05);">
            <div style="padding: 14px 20px; border-bottom: 1px solid #E8E2D4; background: #2D3A1E; display: flex; align-items: center; gap: 8px;">
                <span>📅</span>
                <h2 style="font-size: 13px; font-weight: 700; color: #D4A017; margin: 0; text-transform: uppercase; letter-spacing: 0.06em;">Rekap Bulanan</h2>
            </div>
            {{-- Grid 12 kolom untuk setiap bulan --}}
            <div style="display: grid; grid-template-columns: repeat(12, 1fr); gap: 8px; padding: 16px 20px;">
                @php $namaBulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des']; @endphp
                @foreach($namaBulan as $i => $bln)
                    @php
                        $data  = $rekapBulanan->firstWhere('bulan', $i + 1);
                        $total = $data ? $data->total : 0;
                    @endphp
                    <div style="text-align: center; border-radius: 8px; padding: 10px 4px; border: 1px solid #E8E2D4; background: #F5F0E8;">
                        <div style="font-size: 9px; color: #8A7E6E; font-weight: 700; text-transform: uppercase; letter-spacing: .06em;">{{ $bln }}</div>
                        <div style="font-size: 18px; font-weight: 900; color: #2D3A1E; margin-top: 2px; line-height: 1;">{{ $total }}</div>
                    </div>
                @endforeach
            </div>
        </div>
        {{-- AKHIR REKAP BULANAN --}}

        {{-- TABEL LAPORAN PEMINJAMAN --}}
        <div style="background: #FFFDF8; border-radius: 14px; border: 1px solid #E8E2D4; overflow: hidden; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(45,58,30,0.05);">
            <div style="padding: 14px 20px; border-bottom: 1px solid #E8E2D4; background: #2D3A1E; display: flex; align-items: center; gap: 8px;">
                <span>📚</span>
                <h2 style="font-size: 13px; font-weight: 700; color: #D4A017; margin: 0; text-transform: uppercase; letter-spacing: 0.06em;">Laporan Peminjaman</h2>
            </div>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 12.5px;">
                    <thead>
                        <tr style="background: #2D3A1E;">
                            <th style="padding: 11px 16px; text-align: left; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: #D4A017;">No</th>
                            <th style="padding: 11px 16px; text-align: left; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: #D4A017;">ID</th>
                            <th style="padding: 11px 16px; text-align: left; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: #D4A017;">Anggota</th>
                            <th style="padding: 11px 16px; text-align: left; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: #D4A017;">Buku</th>
                            <th style="padding: 11px 16px; text-align: center; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: #D4A017;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjamans as $i => $p)
                        <tr style="border-top: 1px solid #EDE7DA; {{ $i % 2 == 1 ? 'background-color: #F5F0E8;' : '' }}">
                            <td style="padding: 11px 16px; color: #A09080;">{{ $i + 1 }}</td>
                            <td style="padding: 11px 16px; font-family: monospace; font-weight: 700; color: #1A2E5A; font-size: 11.5px;">#{{ $p->id_peminjaman }}</td>
                            <td style="padding: 11px 16px; font-weight: 600; text-transform: uppercase; font-size: 11.5px; color: #2D3A1E;">{{ $p->nama_anggota }}</td>
                            <td style="padding: 11px 16px; color: #2D3A1E;">{{ $p->buku->judul ?? '—' }}</td>
                            <td style="padding: 11px 16px; text-align: center;">
                                {{-- Warna badge status berdasarkan kondisi --}}
                                @php
                                    if ($p->status === 'dikembalikan') { $bg = '#E8F0DC'; $tc = '#2D3A1E'; }
                                    elseif ($p->status === 'dipinjam') { $bg = '#DDE8F5'; $tc = '#1A2E5A'; }
                                    else { $bg = '#FEF3C7'; $tc = '#92400E'; }
                                @endphp
                                <span style="display: inline-block; padding: 3px 10px; border-radius: 999px; font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: .07em; background: {{ $bg }}; color: {{ $tc }};">
                                    {{ $p->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 32px; color: #8A7E6E; font-size: 13px;">Tidak ada data peminjaman.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{-- AKHIR TABEL PEMINJAMAN --}}

        {{-- TABEL LAPORAN DENDA --}}
        <div style="background: #FFFDF8; border-radius: 14px; border: 1px solid #E8E2D4; overflow: hidden; box-shadow: 0 2px 8px rgba(45,58,30,0.05);">
            <div style="padding: 14px 20px; border-bottom: 1px solid #E8E2D4; background: #2D3A1E; display: flex; align-items: center; gap: 8px;">
                <span>💰</span>
                <h2 style="font-size: 13px; font-weight: 700; color: #D4A017; margin: 0; text-transform: uppercase; letter-spacing: 0.06em;">Laporan Denda</h2>
            </div>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 12.5px;">
                    <thead>
                        <tr style="background: #2D3A1E;">
                            <th style="padding: 11px 16px; text-align: left; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: #D4A017;">No</th>
                            <th style="padding: 11px 16px; text-align: left; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: #D4A017;">Anggota</th>
                            <th style="padding: 11px 16px; text-align: left; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: #D4A017;">Total Denda</th>
                            <th style="padding: 11px 16px; text-align: center; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: #D4A017;">Status Bayar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dendas as $i => $d)
                        <tr style="border-top: 1px solid #EDE7DA; {{ $i % 2 == 1 ? 'background-color: #F5F0E8;' : '' }}">
                            <td style="padding: 11px 16px; color: #A09080;">{{ $i + 1 }}</td>
                            <td style="padding: 11px 16px; font-weight: 600; text-transform: uppercase; font-size: 11.5px; color: #2D3A1E;">{{ $d->nama_anggota }}</td>
                            <td style="padding: 11px 16px; font-weight: 700; color: #8B3A3A;">Rp {{ number_format($d->total_denda, 0, ',', '.') }}</td>
                            <td style="padding: 11px 16px; text-align: center;">
                                {{-- Warna badge status bayar --}}
                                @php
                                    if ($d->status_bayar === 'sudah_bayar') { $bgD = '#E8F0DC'; $tcD = '#2D3A1E'; }
                                    else { $bgD = '#F8D7DA'; $tcD = '#8B3A3A'; }
                                @endphp
                                <span style="display: inline-block; padding: 3px 10px; border-radius: 999px; font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: .07em; background: {{ $bgD }}; color: {{ $tcD }};">
                                    {{ $d->status_bayar }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 32px; color: #8A7E6E; font-size: 13px;">Tidak ada data denda.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{-- AKHIR TABEL DENDA --}}

    </main>
</div>

{{-- JAVASCRIPT: Toggle dropdown profil & tutup saat klik di luar --}}
<script>
    function toggleDropdown() {
        const menu = document.getElementById('dropdownMenu');
        const chevron = document.getElementById('chevronIcon');
        if (menu.style.display === 'none' || menu.style.display === '') {
            menu.style.display = 'block';
            chevron.style.transform = 'rotate(180deg)';
        } else {
            menu.style.display = 'none';
            chevron.style.transform = 'rotate(0deg)';
        }
    }
    window.onclick = function(e) {
        const wrapper = document.getElementById('profileWrapper');
        if (!wrapper.contains(e.target)) {
            document.getElementById('dropdownMenu').style.display = 'none';
            document.getElementById('chevronIcon').style.transform = 'rotate(0deg)';
        }
    }
</script>

</body>
</html>