<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Denda Saya</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="margin: 0; font-family: ui-sans-serif, system-ui; background-color: #F5F0E8;">

  {{-- NAVBAR --}}
<nav style="background-color: #2D3A1E; height: 56px; padding: 0 32px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 100; border-bottom: 2px solid #D4A017;">
    <span style="color: #F5F0E8; font-size: 17px; font-weight: bold; font-style: italic;">Sistem Perpustakaan</span>

    {{-- Dropdown profil --}}
    <div id="userMenu" style="position: relative;">
        <button onclick="toggleDropdown()" style="display: flex; align-items: center; gap: 8px; color: #F5F0E8; font-size: 14px; cursor: pointer; background: none; border: none; padding: 6px 10px; border-radius: 8px;">
            @if(Auth::user()->foto)
                <img src="{{ asset('storage/' . Auth::user()->foto) }}"
                     style="width: 34px; height: 34px; border-radius: 50%; object-fit: cover; border: 2px solid #D4A017;">
            @else
                <div style="width: 34px; height: 34px; border-radius: 50%; background-color: #D4A017; color: #2D3A1E; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 14px;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            @endif
            <span>{{ Auth::user()->name }}</span>
            <svg id="chevronIcon" style="width: 14px; height: 14px; transition: transform 0.2s; opacity: 0.8;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div id="userDropdown" style="display: none; position: absolute; top: calc(100% + 8px); right: 0; background: #FFFDF8; border: 1px solid #DDD6C8; border-radius: 12px; min-width: 180px; box-shadow: 0 8px 24px rgba(45,58,30,0.15); overflow: hidden; z-index: 100;">
            <div style="padding: 12px 16px; border-bottom: 1px solid #E8E2D4; background: #F5F0E8;">
                <p style="margin: 0; font-size: 13px; font-weight: 600; color: #2D3A1E;">{{ Auth::user()->name }}</p>
                <p style="margin: 1px 0 0 0; font-size: 11px; color: #8A7E6E;">Anggota Perpustakaan</p>
            </div>
            <a href="{{ route('anggota.profil') }}" style="display: flex; align-items: center; gap: 10px; padding: 10px 16px; font-size: 13px; color: #3A3020; text-decoration: none;">
                <svg style="width: 15px; height: 15px; opacity: 0.7;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Profil Saya
            </a>
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

    <div style="display: flex; min-height: calc(100vh - 56px);">

        {{-- ============================== --}}
        {{-- SIDEBAR                        --}}
        {{-- ============================== --}}
        <aside style="width: 176px; background-color: #2D3A1E; padding: 20px 12px; display: flex; flex-direction: column; gap: 6px; flex-shrink: 0;">

            <span style="font-size: 10px; color: #7A9E5A; text-transform: uppercase; letter-spacing: 0.08em; padding: 0 8px; margin: 0 0 4px 0;">Menu Anggota</span>

            <a href="{{ route('anggota.dashboard') }}"
               style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">
                Dashboard
            </a>

            <a href="{{ route('katalog.index') }}"
               style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">
                Katalog Buku
            </a>

            <a href="{{ route('peminjaman.saya') }}"
               style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">
                Peminjaman Saya
            </a>

            {{-- Link Denda Saya — AKTIF, kuning emas --}}
            <a href="{{ route('denda.saya') }}"
               style="display: flex; align-items: center; padding: 9px 12px; border-radius: 8px; background: #D4A017; color: #2D3A1E; font-size: 13px; text-decoration: none; font-weight: 600;">
                Denda Saya
            </a>
        </aside>

        {{-- ============================== --}}
        {{-- KONTEN UTAMA                   --}}
        {{-- ============================== --}}
        <main style="flex: 1; padding: 32px;">

            {{-- Judul halaman --}}
            <div style="margin-bottom: 24px;">
                <h1 style="font-size: 24px; font-weight: 700; color: #2D3A1E; margin: 0;">Denda Saya</h1>
            </div>

            {{-- Notifikasi sukses --}}
            @if(session('success'))
                <div id="flash-success"
                     style="background-color: #dcfce7; border: 1px solid #22c55e; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; display: flex; align-items: center; justify-content: space-between;">
                    <span>✅ {{ session('success') }}</span>
                    <button onclick="document.getElementById('flash-success').style.display='none'"
                            style="background: none; border: none; color: #166534; cursor: pointer; font-size: 18px;">&times;</button>
                </div>
            @endif

            {{-- Tabel denda --}}
            <div style="background: #F9F9F9; border-radius: 12px; border: 1px solid #D4A017; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.08);">
                <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
{{-- ============================== --}}
{{-- HEADER TABEL                   --}}
{{-- ============================== --}}
<thead>
    <tr style="background-color: #2D3A1E; border-bottom: 2px solid #D4A017; text-align: left;">
        <th style="padding: 14px 16px; color: #F5F0E8;">No</th>
        <th style="padding: 14px 16px; color: #F5F0E8;">Judul Buku</th>

        {{-- Kolom Jenis Denda (Rusak / Terlambat / Hilang) --}}
        <th style="padding: 14px 16px; color: #F5F0E8;">Jenis</th>

        <th style="padding: 14px 16px; color: #F5F0E8;">Hari Terlambat</th>
        <th style="padding: 14px 16px; color: #F5F0E8;">Denda/Hari</th>
        <th style="padding: 14px 16px; color: #F5F0E8;">Total Denda</th>
        <th style="padding: 14px 16px; color: #F5F0E8;">Status</th>
    </tr>
</thead>

{{-- ============================== --}}
{{-- BODY TABEL                     --}}
{{-- ============================== --}}
<tbody>
    @forelse($dendas as $index => $d)
    <tr style="border-bottom: 1px solid #E8E2D4; background-color: #FFFFFF; transition: background 0.15s;"
        onmouseover="this.style.backgroundColor='#F5F0E8'"
        onmouseout="this.style.backgroundColor='#FFFFFF'">

        {{-- Nomor urut --}}
        <td style="padding: 14px 16px; color: #8A7E6E;">{{ $index + 1 }}</td>

        {{-- Judul buku --}}
        <td style="padding: 14px 16px; font-weight: 600; color: #2D3A1E;">{{ $d->judul_buku }}</td>

        {{-- Jenis denda: badge warna berbeda tiap jenis --}}
        <td style="padding: 14px 16px;">
            @if($d->jenis_denda == 'rusak')
                {{-- Badge kuning untuk buku rusak --}}
                <span style="background-color: #FEF9C3; color: #854D0E; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">
                    🔧 Rusak
                </span>
            @elseif($d->jenis_denda == 'hilang')
                {{-- Badge merah gelap untuk buku hilang --}}
                <span style="background-color: #FEE2E2; color: #7F1D1D; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">
                    ❌ Hilang
                </span>
            @else
                {{-- Badge biru/ungu untuk keterlambatan --}}
                <span style="background-color: #EDE9FE; color: #5B21B6; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">
                    🕐 Terlambat
                </span>
            @endif
        </td>

        {{-- Hari terlambat, badge merah --}}
        <td style="padding: 14px 16px;">
            <span style="background-color: #FEE2E2; color: #991b1b; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">
                {{ $d->hari_terlambat }} hari
            </span>
        </td>

        {{-- Denda per hari --}}
        <td style="padding: 14px 16px; color: #8A7E6E;">Rp {{ number_format($d->denda_per_hari, 0, ',', '.') }}</td>

        {{-- Total denda, merah tebal --}}
        <td style="padding: 14px 16px; font-weight: 700; color: #991b1b;">Rp {{ number_format($d->total_denda, 0, ',', '.') }}</td>

        {{-- Badge status bayar --}}
        <td style="padding: 14px 16px;">
            @if($d->status_bayar == 'belum_bayar')
                {{-- Belum bayar: badge merah --}}
                <span style="background-color: #FEE2E2; color: #991b1b; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">Belum Bayar</span>
            @else
                {{-- Sudah bayar: badge hijau --}}
                <span style="background-color: #DCFCE7; color: #166534; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">Sudah Bayar</span>
            @endif
        </td>

    </tr>
    @empty
    {{-- Jika tidak ada denda sama sekali --}}
    <tr>
        {{-- colspan diubah jadi 7 karena sudah ada kolom Jenis --}}
        <td colspan="7" style="padding: 40px; text-align: center; color: #8A7E6E;">
            <div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                <span style="font-size: 40px;">✅</span>
                <span style="font-style: italic;">Tidak ada denda 🎉</span>
            </div>
        </td>
    </tr>
    @endforelse
</tbody>
                </table>
            </div>

        </main>
    </div>

   <script>
    function toggleDropdown() {
        const menu = document.getElementById('userDropdown');
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
        if (!e.target.closest('#userMenu')) {
            document.getElementById('userDropdown').style.display = 'none';
            document.getElementById('chevronIcon').style.transform = 'rotate(0deg)';
        }
    }
</script>
</body>
</html>