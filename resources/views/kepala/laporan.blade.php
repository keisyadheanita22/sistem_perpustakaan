<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan – Sistem Perpustakaan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'DM Sans', sans-serif; box-sizing: border-box; }
        tbody tr:hover td { background: #fafafa; }
        select:focus      { border-color: #db2777 !important; outline: none; }
        .export-btn:hover { opacity: .85; }
        @media print {
            .print-hidden { display: none !important; }
            body          { background: #fff !important; }
            main          { padding: 0 !important; }
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- NAVBAR --}}
    <nav class="px-8 h-14 flex items-center justify-between print-hidden" style="background-color:#db2777;">
        <span class="text-white font-bold text-lg italic">Sistem Perpustakaan</span>
        <a href="{{ route('kepala.profil') }}" class="flex items-center gap-2 text-white text-sm hover:opacity-80">
            @if(Auth::user()->foto)
                <img src="{{ asset('storage/' . Auth::user()->foto) }}" class="w-8 h-8 rounded-full object-cover">
            @else
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold text-white" style="background-color:#9d174d;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            @endif
            <span>{{ Auth::user()->name }}</span>
        </a>
    </nav>

    <div class="flex flex-1">

        {{-- SIDEBAR --}}
        <aside class="w-44 flex flex-col py-4 gap-2 print-hidden" style="background-color:#db2777; min-height: calc(100vh - 56px);">
            <a href="{{ route('kepala.dashboard') }}"
               class="mx-3 px-4 py-2 rounded text-white text-sm text-center"
               style="background-color:#9d174d;">Dashboard</a>
            <a href="{{ route('kepala.petugas.index') }}"
               class="mx-3 px-4 py-2 rounded text-white text-sm text-center"
               style="background-color:#9d174d;">Data Petugas</a>
            <a href="{{ route('kepala.katalog') }}"
               class="mx-3 px-4 py-2 rounded text-white text-sm text-center"
               style="background-color:#9d174d;">Katalog Buku</a>
            <a href="{{ route('kepala.anggota.index') }}"
               class="mx-3 px-4 py-2 rounded text-white text-sm text-center"
               style="background-color:#9d174d;">Daftar Anggota</a>
            <a href="{{ route('kepala.laporan') }}"
               class="mx-3 px-4 py-2 rounded text-white text-sm text-center font-bold"
               style="background-color:#831843;">Laporan</a>

            <div class="mt-auto mx-3 pb-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-4 py-2 rounded text-white text-sm"
                        style="background-color:#9d174d;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- KONTEN UTAMA --}}
        <main style="flex:1; padding:24px 28px; overflow:auto;">

            <div style="margin-bottom:20px;">
                <h1 style="font-size:20px; font-weight:800; color:#111827; margin:0;">Laporan Perpustakaan</h1>
                <p style="color:#6b7280; font-size:13px; margin:3px 0 0;">Rekap peminjaman &amp; denda perpustakaan</p>
                <p class="hidden print:block" style="font-size:12px; color:#9ca3af; margin-top:2px;">
                    Dicetak: {{ now()->format('d/m/Y') }}
                </p>
            </div>

            {{-- FILTER & EKSPOR --}}
            <div class="print-hidden"
                 style="background:#fff; border-radius:12px; border:1px solid #f0e6ed;
                        display:flex; flex-wrap:wrap; align-items:center;
                        justify-content:space-between; gap:10px;
                        padding:14px 20px; margin-bottom:16px;">
                <form method="GET" action="{{ route('kepala.laporan') }}"
                      style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <select name="bulan"
                            style="border:1px solid #e5e7eb; border-radius:8px; padding:6px 10px; font-size:13px; color:#374151; background:#fafafa;">
                        <option value="">Semua Bulan</option>
                        @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $bln)
                            <option value="{{ $i+1 }}" {{ request('bulan') == $i+1 ? 'selected' : '' }}>{{ $bln }}</option>
                        @endforeach
                    </select>
                    <select name="tahun"
                            style="border:1px solid #e5e7eb; border-radius:8px; padding:6px 10px; font-size:13px; color:#374151; background:#fafafa;">
                        @for($y = now()->year; $y >= now()->year - 3; $y--)
                            <option value="{{ $y }}" {{ request('tahun', now()->year) == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                    <button type="submit"
                            style="padding:6px 16px; border-radius:8px; background:#db2777; color:#fff; font-size:13px; font-weight:600; border:none; cursor:pointer;">
                        Filter
                    </button>
                </form>
                <div style="display:flex; align-items:center; gap:8px;">
                    <a href="{{ route('kepala.laporan.pdf', request()->query()) }}" class="export-btn"
                       style="padding:6px 14px; border-radius:8px; background:#9d174d; color:#fff; font-size:13px; font-weight:600; text-decoration:none;">📄 PDF</a>
                    <a href="{{ route('kepala.laporan.excel', request()->query()) }}" class="export-btn"
                       style="padding:6px 14px; border-radius:8px; background:#166534; color:#fff; font-size:13px; font-weight:600; text-decoration:none;">📊 Excel</a>
                    <button onclick="window.print()" class="export-btn"
                            style="padding:6px 14px; border-radius:8px; background:#1e40af; color:#fff; font-size:13px; font-weight:600; border:none; cursor:pointer;">🖨️ Print</button>
                </div>
            </div>

            {{-- REKAP BULANAN --}}
            <div style="background:#fff; border-radius:12px; border:1px solid #f0e6ed; overflow:hidden; margin-bottom:16px;">
                <div style="padding:14px 20px; border-bottom:1px solid #f0e6ed; display:flex; align-items:center; gap:8px;">
                    <span>📅</span>
                    <h2 style="font-size:13.5px; font-weight:700; color:#374151; margin:0;">Rekap Bulanan</h2>
                </div>
                <div style="display:grid; grid-template-columns:repeat(12,1fr); gap:8px; padding:16px 20px;">
                    @php $namaBulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des']; @endphp
                    @foreach($namaBulan as $i => $bln)
                        @php
                            $data  = $rekapBulanan->firstWhere('bulan', $i + 1);
                            $total = $data ? $data->total : 0;
                        @endphp
                        <div style="text-align:center; border-radius:8px; padding:10px 4px; border:1px solid #fce7f3;">
                            <div style="font-size:9px; color:#9ca3af; font-weight:700; text-transform:uppercase; letter-spacing:.06em;">{{ $bln }}</div>
                            <div style="font-size:18px; font-weight:900; color:#db2777; margin-top:2px; line-height:1;">{{ $total }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- TABEL PEMINJAMAN --}}
            <div style="background:#fff; border-radius:12px; border:1px solid #f0e6ed; overflow:hidden; margin-bottom:16px;">
                <div style="padding:14px 20px; border-bottom:1px solid #f0e6ed; display:flex; align-items:center; gap:8px;">
                    <span>📚</span>
                    <h2 style="font-size:13.5px; font-weight:700; color:#374151; margin:0;">Laporan Peminjaman</h2>
                </div>
                <div style="overflow-x:auto;">
                    <table style="width:100%; border-collapse:collapse; font-size:12.5px;">
                        <thead>
                            <tr style="background:#fdf2f8;">
                                <th style="padding:10px 16px; text-align:left; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:#6b7280;">No</th>
                                <th style="padding:10px 16px; text-align:left; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:#6b7280;">ID</th>
                                <th style="padding:10px 16px; text-align:left; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:#6b7280;">Anggota</th>
                                <th style="padding:10px 16px; text-align:left; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:#6b7280;">Buku</th>
                                <th style="padding:10px 16px; text-align:center; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:#6b7280;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($peminjamans as $i => $p)
                            <tr style="border-top:1px solid #f3f4f6;">
                                <td style="padding:10px 16px; color:#9ca3af;">{{ $i + 1 }}</td>
                                <td style="padding:10px 16px; font-family:monospace; font-weight:700; color:#db2777; font-size:11.5px;">#{{ $p->id_peminjaman }}</td>
                                <td style="padding:10px 16px; font-weight:600; text-transform:uppercase; font-size:11.5px; color:#374151;">{{ $p->nama_anggota }}</td>
                                <td style="padding:10px 16px; color:#374151;">{{ $p->buku->judul ?? '—' }}</td>
                                <td style="padding:10px 16px; text-align:center;">
                                    @php
                                        if ($p->status === 'dikembalikan') {
                                            $bg = '#d1fae5'; $tc = '#065f46';
                                        } elseif ($p->status === 'dipinjam') {
                                            $bg = '#fce7f3'; $tc = '#9d174d';
                                        } else {
                                            $bg = '#fef3c7'; $tc = '#92400e';
                                        }
                                    @endphp
                                    <span style="display:inline-block; padding:2px 10px; border-radius:999px; font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:.07em; background:{{ $bg }}; color:{{ $tc }};">
                                        {{ $p->status }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="text-align:center; padding:32px; color:#9ca3af; font-size:13px;">Tidak ada data peminjaman.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- TABEL DENDA --}}
            <div style="background:#fff; border-radius:12px; border:1px solid #f0e6ed; overflow:hidden;">
                <div style="padding:14px 20px; border-bottom:1px solid #f0e6ed; display:flex; align-items:center; gap:8px;">
                    <span>💰</span>
                    <h2 style="font-size:13.5px; font-weight:700; color:#374151; margin:0;">Laporan Denda</h2>
                </div>
                <div style="overflow-x:auto;">
                    <table style="width:100%; border-collapse:collapse; font-size:12.5px;">
                        <thead>
                            <tr style="background:#fdf2f8;">
                                <th style="padding:10px 16px; text-align:left; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:#6b7280;">No</th>
                                <th style="padding:10px 16px; text-align:left; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:#6b7280;">Anggota</th>
                                <th style="padding:10px 16px; text-align:left; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:#6b7280;">Total Denda</th>
                                <th style="padding:10px 16px; text-align:center; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:#6b7280;">Status Bayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dendas as $i => $d)
                            <tr style="border-top:1px solid #f3f4f6;">
                                <td style="padding:10px 16px; color:#9ca3af;">{{ $i + 1 }}</td>
                                <td style="padding:10px 16px; font-weight:600; text-transform:uppercase; font-size:11.5px; color:#374151;">{{ $d->nama_anggota }}</td>
                                <td style="padding:10px 16px; font-weight:700; color:#ef4444;">
                                    Rp {{ number_format($d->total_denda, 0, ',', '.') }}
                                </td>
                                <td style="padding:10px 16px; text-align:center;">
                                    @php
                                        if ($d->status_bayar === 'lunas') {
                                            $bgD = '#d1fae5'; $tcD = '#065f46';
                                        } else {
                                            $bgD = '#fce7f3'; $tcD = '#9d174d';
                                        }
                                    @endphp
                                    <span style="display:inline-block; padding:2px 10px; border-radius:999px; font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:.07em; background:{{ $bgD }}; color:{{ $tcD }};">
                                        {{ $d->status_bayar }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" style="text-align:center; padding:32px; color:#9ca3af; font-size:13px;">Tidak ada data denda.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

</body>
</html>