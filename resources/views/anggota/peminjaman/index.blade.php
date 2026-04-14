<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Saya</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="margin: 0; font-family: ui-sans-serif, system-ui; background-color: #F5F0E8;">

    {{-- ============================== --}}
    {{-- NAVBAR                         --}}
    {{-- ============================== --}}
    <nav style="background-color: #2D3A1E; height: 56px; padding: 0 32px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 100;">

        <span style="color: #F5F0E8; font-size: 17px; font-weight: bold; font-style: italic;">Sistem Perpustakaan</span>

        {{-- Dropdown profil --}}
        <div id="userMenu" style="position: relative; cursor: pointer;" onclick="toggleDropdown()">
            <div style="display: flex; align-items: center; gap: 8px; color: #F5F0E8; font-size: 14px;">
                @if(Auth::user()->foto)
                    <img src="{{ asset('storage/' . Auth::user()->foto) }}"
                         style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; border: 1px solid #D4A017;">
                @else
                    <div style="width: 32px; height: 32px; border-radius: 50%; background-color: #D4A017; color: #2D3A1E; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
                <span>{{ Auth::user()->name }} ▾</span>
            </div>

            <div id="userDropdown" style="display: none; position: absolute; right: 0; top: 45px; width: 160px; background: white; border-radius: 8px; box-shadow: 0 10px 15px rgba(0,0,0,0.1); border: 1px solid #E8E2D4; overflow: hidden;">
                <a href="{{ route('anggota.profil') }}"
                   style="display: block; padding: 12px 16px; color: #2D3A1E; text-decoration: none; font-size: 13px; font-weight: 600; border-bottom: 1px solid #F0EBE0;">
                    Profil Saya
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            style="width: 100%; text-align: left; background: none; border: none; padding: 12px 16px; color: #9d174d; font-size: 13px; font-weight: 600; cursor: pointer;">
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

            {{-- Link Peminjaman Saya — AKTIF, kuning emas --}}
            <a href="{{ route('peminjaman.saya') }}"
               style="display: flex; align-items: center; padding: 9px 12px; border-radius: 8px; background: #D4A017; color: #2D3A1E; font-size: 13px; text-decoration: none; font-weight: 600;">
                Peminjaman Saya
            </a>

            <a href="{{ route('denda.saya') }}"
               style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">
                Denda Saya
            </a>

            {{-- Tombol logout di bagian bawah --}}
            <div style="margin-top: auto; padding-top: 16px;">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 6px; padding: 9px 12px; border-radius: 8px; background: none; border: 1px solid #4a5c2e; color: #C8DDB0; font-size: 13px; cursor: pointer;">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width: 14px; height: 14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- ============================== --}}
        {{-- KONTEN UTAMA                   --}}
        {{-- ============================== --}}
        <main style="flex: 1; padding: 32px;">

            <div style="margin-bottom: 24px;">
                <h1 style="font-size: 24px; font-weight: 700; color: #2D3A1E; margin: 0;">Peminjaman Saya</h1>
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

            {{-- Notifikasi error --}}
            @if(session('error'))
            <div id="flash-error"
                 style="background-color: #FEE2E2; border: 1px solid #FCA5A5; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; display: flex; align-items: center; justify-content: space-between;">
                <span>⚠️ {{ session('error') }}</span>
                <button onclick="document.getElementById('flash-error').style.display='none'"
                        style="background: none; border: none; color: #991b1b; cursor: pointer; font-size: 18px;">&times;</button>
            </div>
            @endif

            {{-- Tabel peminjaman --}}
            <div style="background: #F9F9F9; border-radius: 12px; border: 1px solid #D4A017; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.08);">
                <table style="width: 100%; border-collapse: collapse; font-size: 13px;">

                    <thead>
                        <tr style="background-color: #2D3A1E; border-bottom: 2px solid #D4A017; text-align: left;">
                            <th style="padding: 14px 16px; color: #F5F0E8;">No</th>
                            <th style="padding: 14px 16px; color: #F5F0E8;">ID Pinjam</th>
                            <th style="padding: 14px 16px; color: #F5F0E8;">Buku</th>
                            <th style="padding: 14px 16px; color: #F5F0E8;">Tanggal Pinjam</th>
                            <th style="padding: 14px 16px; color: #F5F0E8;">Batas Kembali</th>
                            <th style="padding: 14px 16px; color: #F5F0E8;">Status</th>
                            <th style="padding: 14px 16px; color: #F5F0E8; text-align: center;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($peminjamans as $index => $p)
                        <tr style="border-bottom: 1px solid #E8E2D4; background-color: #FFFFFF; transition: background 0.15s;"
                            onmouseover="this.style.backgroundColor='#F5F0E8'"
                            onmouseout="this.style.backgroundColor='#FFFFFF'">

                            <td style="padding: 14px 16px; color: #8A7E6E;">{{ $index + 1 }}</td>
                            <td style="padding: 14px 16px; font-weight: 700; color: #2D3A1E;">{{ $p->id_peminjaman }}</td>
                            <td style="padding: 14px 16px; color: #2D3A1E;">{{ $p->buku->judul ?? '-' }}</td>
                            <td style="padding: 14px 16px; color: #8A7E6E;">{{ $p->tanggal_pinjam }}</td>
                            <td style="padding: 14px 16px; color: #8A7E6E;">{{ $p->tanggal_kembali }}</td>

                            {{-- Badge status --}}
                            <td style="padding: 14px 16px;">
                                @if($p->status == 'menunggu')
                                    <span style="background-color: #FEF3C7; color: #92400e; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">Menunggu</span>
                                @elseif($p->status == 'dipinjam')
                                    <span style="background-color: #FEE2E2; color: #991b1b; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">Dipinjam</span>
                                @elseif($p->status == 'mengembalikan')
                                    <span style="background-color: #EDE9FE; color: #5b21b6; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">Menunggu Verifikasi</span>
                                @else
                                    <span style="background-color: #DCFCE7; color: #166534; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">Dikembalikan</span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td style="padding: 14px 16px; text-align: center;">
                                @if($p->status == 'menunggu')
                                    <form method="POST" action="{{ route('peminjaman.batalkan', $p->id) }}">
                                        @csrf
                                        <button type="submit"
                                                style="padding: 5px 12px; background-color: #E8E2D4; color: #8A7E6E; border: 1px solid #d0c9bd; border-radius: 6px; font-size: 11px; font-weight: 600; cursor: pointer;"
                                                onclick="return confirm('Batalkan peminjaman ini?')">
                                            Batalkan
                                        </button>
                                    </form>
                                @elseif($p->status == 'dipinjam')
                                    <form method="POST" action="{{ route('peminjaman.kembalikan', $p->id) }}">
                                        @csrf
                                        <button type="submit"
                                                style="padding: 5px 12px; background-color: #DBEAFE; color: #1E3A5F; border: 1px solid #93C5FD; border-radius: 6px; font-size: 11px; font-weight: 600; cursor: pointer;"
                                                onclick="return confirm('Kembalikan buku ini? Pengembalian akan diverifikasi oleh petugas.')">
                                            Kembalikan
                                        </button>
                                    </form>
                                @elseif($p->status == 'mengembalikan')
                                    <span style="color: #5b21b6; font-size: 11px; font-style: italic;">Menunggu verifikasi...</span>
                                @else
                                    <span style="color: #8A7E6E; font-size: 11px;">Selesai ✓</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" style="padding: 40px; text-align: center; color: #8A7E6E;">
                                <div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                                    <span style="font-size: 40px;">📋</span>
                                    <span style="font-style: italic;">Belum ada peminjaman.</span>
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
            const dropdown = document.getElementById('userDropdown');
            dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
        }
        window.onclick = function(event) {
            if (!event.target.closest('#userMenu')) {
                const d = document.getElementById('userDropdown');
                if (d) d.style.display = 'none';
            }
        }
    </script>
</body>
</html>