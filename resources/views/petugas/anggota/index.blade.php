<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Anggota</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        {{-- Fungsi buka/tutup dropdown profil --}}
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
        }
        {{-- Tutup dropdown kalau klik di luar area --}}
        window.onclick = function(event) {
            if (!event.target.closest('#userMenu')) {
                const d = document.getElementById('userDropdown');
                if(d) d.style.display = 'none';
            }
        }
    </script>
</head>
<body style="margin: 0; font-family: ui-sans-serif, system-ui; background-color: #F5F0E8;">

    {{-- NAVBAR --}}
    <nav style="background-color: #2D3A1E; height: 56px; padding: 0 32px; display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid #D4A017; position: sticky; top: 0; z-index: 100;">
        {{-- Judul aplikasi --}}
        <span style="color: #F5F0E8; font-size: 17px; font-weight: bold; font-style: italic;">Sistem Perpustakaan</span>

        {{-- Menu dropdown profil pengguna --}}
        <div id="userMenu" style="position: relative; cursor: pointer;" onclick="toggleDropdown()">
            <div style="display: flex; align-items: center; gap: 8px; color: #F5F0E8; font-size: 14px;">
                {{-- Tampilkan foto profil kalau ada, kalau tidak tampilkan inisial --}}
                @if(Auth::user()->foto)
                    <img src="{{ asset('storage/' . Auth::user()->foto) }}" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; border: 1px solid #D4A017;">
                @else
                    <div style="width: 32px; height: 32px; border-radius: 50%; background-color: #D4A017; color: #2D3A1E; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
                <span>{{ Auth::user()->name }} ▾</span>
            </div>

            {{-- Isi dropdown: profil & logout --}}
            <div id="userDropdown" style="display: none; position: absolute; right: 0; top: 45px; width: 160px; background: white; border-radius: 8px; box-shadow: 0 10px 15px rgba(0,0,0,0.1); border: 1px solid #E8E2D4; overflow: hidden;">
                <a href="{{ route('petugas.profil') }}" style="display: block; padding: 12px 16px; color: #2D3A1E; text-decoration: none; font-size: 13px; font-weight: 600; border-bottom: 1px solid #F0EBE0;">Profil Saya</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" style="width: 100%; text-align: left; background: none; border: none; padding: 12px 16px; color: #9d174d; font-size: 13px; font-weight: 600; cursor: pointer;">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div style="display: flex; min-height: calc(100vh - 56px);">

        {{-- SIDEBAR --}}
        <aside style="width: 176px; background-color: #2D3A1E; padding: 20px 12px; display: flex; flex-direction: column; gap: 6px; flex-shrink: 0;">
            <span style="font-size: 10px; color: #7A9E5A; text-transform: uppercase; letter-spacing: 0.08em; padding: 0 8px; margin: 0 0 4px 0;">Menu Petugas</span>

            {{-- Link dashboard --}}
            <a href="{{ route('petugas.dashboard') }}" style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">Dashboard</a>

            {{-- Link data buku --}}
            <a href="{{ route('buku.index') }}" style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">Data Buku</a>

            {{-- Link data anggota - aktif --}}
            <a href="{{ route('anggota.index') }}" style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; background: #D4A017; color: #2D3A1E; font-size: 13px; text-decoration: none; font-weight: 600;">Data Anggota</a>

            {{-- Link peminjaman + badge notifikasi kalau ada yang perlu diverifikasi --}}
            <a href="{{ route('peminjaman.index') }}" style="display: flex; align-items: center; justify-content: space-between; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">
                <span>Peminjaman</span>
                @if(!empty($perluVerifikasi) && $perluVerifikasi > 0)
                    <span style="background-color:#F5F0E8; color:#2D3A1E; font-size: 10px; font-weight: bold; border-radius: 50%; width: 18px; height: 18px; display: flex; align-items: center; justify-content: center;">
                        {{ $perluVerifikasi > 9 ? '9+' : $perluVerifikasi }}
                    </span>
                @endif
            </a>

            {{-- Link kategori --}}
            <a href="{{ route('kategori.index') }}" style="display: flex; align-items: center; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">Kategori</a>

            {{-- Link denda --}}
            <a href="{{ route('denda.index') }}" style="display: flex; align-items: center; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">Denda</a>
        </aside>

        {{-- KONTEN UTAMA --}}
        <main style="flex: 1; padding: 32px;">

            {{-- Header halaman --}}
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                <h1 style="font-size: 24px; font-weight: 700; color: #2D3A1E;">Data Anggota</h1>
            </div>

            {{-- Notifikasi sukses --}}
            @if(session('success'))
                <div id="flash-message" style="background-color: #dcfce7; border: 1px solid #22c55e; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                    <span>✅ {{ session('success') }}</span>
                    <button onclick="document.getElementById('flash-message').style.display='none'" style="background: none; border: none; color: #166534; cursor: pointer; font-size: 18px;">&times;</button>
                </div>
            @endif

            {{-- Kolom pencarian anggota --}}
            <div style="display: flex; justify-content: flex-end; margin-bottom: 20px;">
                <form method="GET" action="{{ route('anggota.index') }}">
                    <div style="display: flex; align-items: center; border: 1px solid #D4A017; border-radius: 8px; padding: 8px 12px; gap: 8px; background: white;">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width: 14px; height: 14px; color: #8A7E6E;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                        </svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Anggota..." style="outline: none; font-size: 13px; width: 180px; border: none; color: #2D3A1E;">
                    </div>
                </form>
            </div>

            {{-- Tabel data anggota --}}
            <div style="background: #F9F9F9; border-radius: 12px; border: 1px solid #D4A017; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.08);">
                <table style="width: 100%; border-collapse: collapse; font-size: 13px;">

                    {{-- Header tabel warna hijau gelap --}}
                    <thead>
                        <tr style="background-color: #2D3A1E; border-bottom: 2px solid #D4A017; text-align: left;">
                            <th style="padding: 14px 16px; color: #F5F0E8;">No</th>
                            <th style="padding: 14px 16px; color: #F5F0E8;">ID Anggota</th>
                            <th style="padding: 14px 16px; color: #F5F0E8;">Nama</th>
                            <th style="padding: 14px 16px; color: #F5F0E8;">Email</th>
                            <th style="padding: 14px 16px; color: #F5F0E8;">No Telepon</th>
                            <th style="padding: 14px 16px; color: #F5F0E8;">Username</th>
                            <th style="padding: 14px 16px; color: #F5F0E8; text-align: center;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        {{-- Looping data anggota dengan warna baris bergantian ijo, kuning, biru tua --}}
                        @forelse ($anggota as $item)

                        @php
                            // 3 warna baris bergantian: putih, hijau muda, biru muda
                            $rowColors = ['#FFFFFF', '#E8F0DC', '#DBEAFE'];
                            $rowHover  = ['#F5F0E8', '#C8DDB0', '#BFDBFE'];
                            $ci = $loop->index % count($rowColors);
                        @endphp

                        {{-- Warna baris bergantian ijo kuning biru --}}
                        <tr style="border-bottom: 1px solid #E8E2D4; background-color: {{ $rowColors[$ci] }}; transition: background 0.15s;"
                            onmouseover="this.style.backgroundColor='{{ $rowHover[$ci] }}'"
                            onmouseout="this.style.backgroundColor='{{ $rowColors[$ci] }}'">

                            {{-- Nomor urut --}}
                            <td style="padding: 14px 16px; color: #8A7E6E;">{{ $loop->iteration }}</td>

                            {{-- ID anggota --}}
                            <td style="padding: 14px 16px; font-weight: 600; color: #2D3A1E;">{{ $item->id_anggota ?? '-' }}</td>

                            {{-- Nama anggota --}}
                            <td style="padding: 14px 16px; color: #2D3A1E;">{{ $item->name }}</td>

                            {{-- Email anggota --}}
                            <td style="padding: 14px 16px; color: #8A7E6E;">{{ $item->email }}</td>

                            {{-- Nomor telepon --}}
                            <td style="padding: 14px 16px; color: #8A7E6E;">{{ $item->no_telepon ?? '-' }}</td>

                            {{-- Username --}}
                            <td style="padding: 14px 16px; color: #8A7E6E;">{{ $item->username ?? '-' }}</td>

                            {{-- Tombol aksi edit dan hapus --}}
                            <td style="padding: 14px 16px;">
                                <div style="display: flex; justify-content: center; gap: 8px;">

                                    {{-- Tombol edit --}}
                                    <a href="{{ route('anggota.edit', $item->id) }}" style="padding: 6px 12px; border: 1px solid #D4A017; border-radius: 6px; text-decoration: none; color: #2D3A1E; font-size: 11px; font-weight: 600; background: #FFFBEB;">✏️ Edit</a>

                                    {{-- Form hapus anggota dengan konfirmasi --}}
                                    <form action="{{ route('anggota.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin hapus anggota {{ $item->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="padding: 6px 12px; background: #FFF1F1; color: #991b1b; border: 1px solid #fca5a5; border-radius: 6px; cursor: pointer; font-size: 11px; font-weight: 600;">🗑️ Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        {{-- Tampilan kalau tidak ada data anggota --}}
                        @empty
                        <tr>
                            <td colspan="7" style="padding: 40px; text-align: center; color: #8A7E6E;">
                                <div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                                    <span style="font-size: 40px;">👤</span>
                                    <span style="font-style: italic;">Tidak ada data anggota.</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </main>
    </div>

</body>
</html>