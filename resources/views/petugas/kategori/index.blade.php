<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
        const menu = document.getElementById('dropdownMenu');
        const chevron = document.getElementById('chevronIcon');
        if (!wrapper.contains(e.target)) {
            menu.style.display = 'none';
            chevron.style.transform = 'rotate(0deg)';
        }
    }
</script>
</head>
<body style="margin: 0; font-family: ui-sans-serif, system-ui; background-color: #F5F0E8;">

 {{-- NAVBAR --}}
<nav style="background-color: #2D3A1E; height: 56px; padding: 0 32px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; border-bottom: 2px solid #D4A017;">
    <span style="color: #F5F0E8; font-size: 17px; font-weight: bold; font-style: italic; letter-spacing: 0.02em;">Sistem Perpustakaan</span>

    {{-- DROPDOWN PROFIL --}}
    <div class="profile-wrapper" id="profileWrapper" style="position: relative;">
        <button onclick="toggleDropdown()" style="display: flex; align-items: center; gap: 8px; color: #F5F0E8; font-size: 14px; cursor: pointer; background: none; border: none; padding: 6px 10px; border-radius: 8px;">
            @if(Auth::user()->foto)
                <img src="{{ asset('storage/' . Auth::user()->foto) }}" style="width: 34px; height: 34px; border-radius: 50%; object-fit: cover; border: 2px solid #D4A017;" alt="Profile">
            @else
                <div style="width: 34px; height: 34px; border-radius: 50%; background-color: #D4A017; color: #2D3A1E; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700; border: 2px solid #D4A017;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            @endif
            <span>{{ Auth::user()->name }}</span>
            <svg id="chevronIcon" style="width: 14px; height: 14px; transition: transform 0.2s; opacity: 0.8;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div id="dropdownMenu" style="display: none; position: absolute; top: calc(100% + 8px); right: 0; background: #FFFDF8; border: 1px solid #DDD6C8; border-radius: 12px; min-width: 180px; box-shadow: 0 8px 24px rgba(45,58,30,0.15); overflow: hidden; z-index: 100;">
            <div style="padding: 12px 16px; border-bottom: 1px solid #E8E2D4; background: #F5F0E8;">
                <p style="margin: 0; font-size: 13px; font-weight: 600; color: #2D3A1E;">{{ Auth::user()->name }}</p>
                <p style="margin: 1px 0 0 0; font-size: 11px; color: #8A7E6E;">Petugas Perpustakaan</p>
            </div>

            <a href="{{ route('petugas.profil') }}" style="display: flex; align-items: center; gap: 10px; padding: 10px 16px; font-size: 13px; color: #3A3020; text-decoration: none;">
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

    {{-- Layout utama: sidebar + konten --}}
    <div style="display: flex; min-height: calc(100vh - 56px);">

        {{-- ============================== --}}
        {{-- SIDEBAR - Menu navigasi kiri   --}}
        {{-- ============================== --}}
        <aside style="width: 176px; background-color: #2D3A1E; padding: 20px 12px; display: flex; flex-direction: column; gap: 6px; flex-shrink: 0;">

            <span style="font-size: 10px; color: #7A9E5A; text-transform: uppercase; letter-spacing: 0.08em; padding: 0 8px; margin: 0 0 4px 0;">Menu Petugas</span>

            {{-- Link: Dashboard --}}
            <a href="{{ route('petugas.dashboard') }}"
               style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">
                Dashboard
            </a>

            {{-- Link: Data Buku --}}
            <a href="{{ route('buku.index') }}"
               style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">
                Data Buku
            </a>

            {{-- Link: Data Anggota --}}
            <a href="{{ route('anggota.index') }}"
               style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">
                Data Anggota
            </a>

            {{-- Link: Peminjaman + badge notifikasi kalau ada yang perlu diverifikasi --}}
            <a href="{{ route('peminjaman.index') }}"
               style="display: flex; align-items: center; justify-content: space-between; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">
                <span>Peminjaman</span>
                @if(!empty($perluVerifikasi) && $perluVerifikasi > 0)
                    <span style="background-color: #D4A017; color: #2D3A1E; font-size: 10px; font-weight: bold; border-radius: 50%; width: 18px; height: 18px; display: flex; align-items: center; justify-content: center;">
                        {{ $perluVerifikasi > 9 ? '9+' : $perluVerifikasi }}
                    </span>
                @endif
            </a>

            {{-- Link: Kategori - AKTIF, warna biru tua sebagai aksen aktif --}}
            <a href="{{ route('kategori.index') }}"
               style="display: flex; align-items: center; padding: 9px 12px; border-radius: 8px; background: #D4A017; color: #2D3A1E; font-size: 13px; text-decoration: none; font-weight: 600;">
                Kategori
            </a>

            {{-- Link: Denda --}}
            <a href="{{ route('denda.index') }}"
               style="display: flex; align-items: center; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">
                Denda
            </a>
        </aside>

        {{-- ============================== --}}
        {{-- KONTEN UTAMA                   --}}
        {{-- ============================== --}}
        <main style="flex: 1; padding: 32px;">

            {{-- Judul halaman --}}
            <div style="margin-bottom: 24px;">
                <h1 style="font-size: 24px; font-weight: 700; color: #2D3A1E; margin: 0;">Kategori</h1>
            </div>

            {{-- Notifikasi sukses setelah tambah/edit/hapus --}}
            @if(session('success'))
                <div id="flash-success"
                     style="background-color: #dcfce7; border: 1px solid #22c55e; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; display: flex; align-items: center; justify-content: space-between;">
                    <span>✅ {{ session('success') }}</span>
                    <button onclick="document.getElementById('flash-success').style.display='none'"
                            style="background: none; border: none; color: #166534; cursor: pointer; font-size: 18px;">&times;</button>
                </div>
            @endif

            {{-- Baris tombol tambah (kiri) dan form cari (kanan) - di luar card tabel --}}
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">

                {{-- Tombol tambah kategori, aksen biru tua --}}
                <a href="{{ route('kategori.create') }}"
                   style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; background-color: #1E3A5F; color: #DBEAFE; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none;">
                    + Tambah Kategori
                </a>

                {{-- Form pencarian kategori --}}
                <form method="GET" action="{{ route('kategori.index') }}">
                    <div style="display: flex; align-items: center; border: 1px solid #D4A017; border-radius: 8px; padding: 8px 12px; gap: 8px; background: white;">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width: 14px; height: 14px; color: #8A7E6E;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                        </svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Kategori..."
                               style="outline: none; font-size: 13px; width: 180px; border: none; color: #2D3A1E;">
                    </div>
                </form>
            </div>

            {{-- Card tabel dengan border kuning seperti halaman peminjaman --}}
            <div style="background: #F9F9F9; border-radius: 12px; border: 1px solid #D4A017; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.08);">

                {{-- Tabel data kategori --}}
                <table style="width: 100%; border-collapse: collapse; font-size: 13px;">

                    {{-- Header tabel warna hijau gelap --}}
                    <thead>
                        <tr style="background-color: #2D3A1E; border-bottom: 2px solid #D4A017; text-align: left;">
                            <th style="padding: 14px 16px; color: #F5F0E8; width: 60px;">No</th>
                            <th style="padding: 14px 16px; color: #F5F0E8;">Nama Kategori</th>
                            <th style="padding: 14px 16px; color: #F5F0E8; text-align: center;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        {{-- Looping data kategori --}}
                        @forelse ($kategoris as $kategori)
                        <tr style="border-bottom: 1px solid #E8E2D4; background-color: #FFFFFF; transition: background 0.15s;"
                            onmouseover="this.style.backgroundColor='#F5F0E8'"
                            onmouseout="this.style.backgroundColor='#FFFFFF'">

                            {{-- Nomor urut --}}
                            <td style="padding: 14px 16px; color: #8A7E6E;">{{ $loop->iteration }}</td>

                            {{-- Nama kategori --}}
                            <td style="padding: 14px 16px; font-weight: 600; color: #2D3A1E;">{{ $kategori->nama_kategori }}</td>

                            {{-- Tombol aksi: edit & hapus --}}
                            <td style="padding: 14px 16px;">
                                <div style="display: flex; align-items: center; gap: 8px; justify-content: center;">

                                    {{-- Tombol edit, aksen biru tua --}}
                                    <a href="{{ route('kategori.edit', $kategori->id) }}"
                                       style="padding: 5px 10px; background: #DBEAFE; color: #1E3A5F; border: 1px solid #93C5FD; border-radius: 6px; font-size: 11px; font-weight: 600; text-decoration: none;">
                                        ✏️ Edit
                                    </a>

                                    {{-- Separator visual --}}
                                    <span style="color: #D1C9BE;">|</span>

                                    {{-- Tombol hapus dengan konfirmasi --}}
                                    <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST"
                                          onsubmit="return confirm('Yakin hapus kategori ini?')" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                style="padding: 5px 10px; background: #FFF1F1; color: #991b1b; border: 1px solid #fca5a5; border-radius: 6px; font-size: 11px; font-weight: 600; cursor: pointer;">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        {{-- Tampilan kosong kalau tidak ada data --}}
                        @empty
                        <tr>
                            <td colspan="3" style="padding: 40px; text-align: center; color: #8A7E6E;">
                                <div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                                    <span style="font-size: 40px;">🗂️</span>
                                    <span style="font-style: italic;">Tidak ada data kategori.</span>
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