<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Buku</title>
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

    <div style="display: flex; min-height: calc(100vh - 56px);">

        {{-- SIDEBAR --}}
        <aside style="width: 176px; background-color: #2D3A1E; padding: 20px 12px; display: flex; flex-direction: column; gap: 6px; flex-shrink: 0;">
            <span style="font-size: 10px; color: #7A9E5A; text-transform: uppercase; letter-spacing: 0.08em; padding: 0 8px; margin: 0 0 4px 0;">Menu Petugas</span>

            {{-- Link dashboard --}}
            <a href="{{ route('petugas.dashboard') }}" style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">Dashboard</a>

            {{-- Link data buku - aktif --}}
            <a href="{{ route('buku.index') }}" style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; background: #D4A017; color: #2D3A1E; font-size: 13px; text-decoration: none; font-weight: 600;">Data Buku</a>

            {{-- Link data anggota --}}
            <a href="{{ route('anggota.index') }}" style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">Data Anggota</a>

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
        <main style="flex: 1; padding: 32px; min-width: 0;">
    
           {{-- ================= HEADER HALAMAN ================= --}}
<div style="margin-bottom: 16px;">
    {{-- Judul halaman --}}
    <h1 style="font-size: 24px; font-weight: 700; color: #2D3A1E;">
        Data Buku
    </h1>
</div>

{{-- ================= BAR ATAS (TOMBOL + FILTER) ================= --}}
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
    
    {{-- ✅ Tombol tambah buku (SEKARANG DI KIRI) --}}
    <a href="{{ route('buku.create') }}"
       style="background-color: #2D3A1E; color: #D4A017; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: bold; border: 1px solid #D4A017;">
       + Tambah Buku
    </a>

    {{-- ✅ Filter + search (SEKARANG DI KANAN) --}}
    <form method="GET" action="{{ route('buku.index') }}" 
          style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">

       {{-- ================= DROPDOWN KATEGORI ================= --}}
<div style="position: relative;">

    {{-- SELECT --}}
    <select name="kategori_id" onchange="this.form.submit()"
            style="appearance: none; 
                   -webkit-appearance: none;
                   -moz-appearance: none;
                   border: 1px solid #D4A017; 
                   border-radius: 8px; 
                   padding: 8px 36px 8px 12px; 
                   font-size: 13px; 
                   background: white; 
                   color: #2D3A1E;
                   cursor: pointer;">
        
        {{-- Default option --}}
        <option value="">📂 Semua Kategori</option>

        {{-- Loop kategori --}}
        @foreach ($kategoris as $kategori)
            <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                {{ $kategori->nama_kategori }}
            </option>
        @endforeach
    </select>

    {{-- ICON PANAH DROPDOWN --}}
    <span style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); pointer-events: none; font-size: 12px; color: #8A7E6E;">
        ▼
    </span>

</div>

        {{-- Input search --}}
        <div style="display: flex; align-items: center; border: 1px solid #D4A017; border-radius: 8px; padding: 8px 12px; gap: 8px; background: white;">
            🔍
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari Buku..."
                   style="outline: none; font-size: 13px; width: 160px; border: none; color: #2D3A1E;">
        </div>
    </form>
</div>

            {{-- Notifikasi sukses --}}
            @if(session('success'))
                <div id="flash-message" style="background-color: #dcfce7; border: 1px solid #22c55e; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                    <span>✅ {{ session('success') }}</span>
                    <button onclick="document.getElementById('flash-message').style.display='none'" style="background: none; border: none; color: #166534; cursor: pointer; font-size: 18px;">&times;</button>
                </div>
            @endif

          
            {{-- Tampilan kalau tidak ada data buku --}}
            @if($bukus->isEmpty())
                <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 64px; color: #8A7E6E;">
                    <span style="font-size: 48px; margin-bottom: 12px;">📚</span>
                    <span style="font-style: italic;">Tidak ada data buku.</span>
                </div>

            @else
            {{-- Tabel daftar buku --}}
            <div style="background: #F9F9F9; border-radius: 12px; border: 1px solid #D4A017; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.08);">
                <table style="width: 100%; border-collapse: collapse; font-size: 13px;">

                    {{-- Header tabel --}}
                    <thead>
                        <tr style="background-color: #F5F0E8; border-bottom: 2px solid #D4A017; text-align: left;">
                            <th style="padding: 14px 16px; width: 40px;">No</th>
                            <th style="padding: 14px 16px; width: 60px;">Cover</th>
                            <th style="padding: 14px 16px;">Judul</th>
                            <th style="padding: 14px 16px;">Pengarang</th>
                            <th style="padding: 14px 16px;">Kategori</th>
                            <th style="padding: 14px 16px; text-align: center;">Stok</th>
                            <th style="padding: 14px 16px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        {{-- Looping data buku --}}
                        @foreach ($bukus as $index => $buku)
                        <tr style="border-bottom: 1px solid #E8E2D4; background-color: #FFFFFF; transition: background 0.15s;"
                            onmouseover="this.style.backgroundColor='#F5F0E8'"
                            onmouseout="this.style.backgroundColor='#FFFFFF'">

                            {{-- Nomor urut --}}
                            <td style="padding: 14px 16px; color: #8A7E6E;">{{ $index + 1 }}</td>

                            {{-- Cover buku --}}
                            <td style="padding: 14px 16px;">
                                @if($buku->foto)
                                    <img src="{{ asset('storage/' . $buku->foto) }}" style="width: 45px; height: 60px; object-fit: cover; border-radius: 4px; border: 1px solid #E8E2D4;">
                                @else
                                    {{-- Placeholder kalau tidak ada foto --}}
                                    <div style="width: 45px; height: 60px; border-radius: 4px; background: linear-gradient(135deg, #E8F0DC, #C8DDB0); display: flex; align-items: center; justify-content: center; font-size: 18px;">📚</div>
                                @endif
                            </td>

                            {{-- Judul buku --}}
                            <td style="padding: 14px 16px; font-weight: 600; color: #2D3A1E;">{{ $buku->judul }}</td>

                            {{-- Nama pengarang --}}
                            <td style="padding: 14px 16px; color: #8A7E6E;">{{ $buku->pengarang }}</td>

                            {{-- Badge kategori --}}
                            <td style="padding: 14px 16px;">
                                @if($buku->kategori)
                                    <span style="background: #E8F0DC; color: #2D3A1E; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">
                                        {{ $buku->kategori->nama_kategori }}
                                    </span>
                                @else
                                    <span style="color: #8A7E6E; font-size: 11px;">-</span>
                                @endif
                            </td>

                            {{-- Jumlah stok --}}
                            <td style="padding: 14px 16px; text-align: center; font-weight: 600; color: #2D3A1E;">{{ $buku->stok }}</td>

                            {{-- Tombol aksi edit dan hapus --}}
                            <td style="padding: 14px 16px;">
                                <div style="display: flex; justify-content: center; gap: 8px;">

                                    {{-- Tombol edit buku --}}
                                    <a href="{{ route('buku.edit', $buku->id) }}" style="padding: 6px 12px; border: 1px solid #D4A017; border-radius: 6px; text-decoration: none; color: #2D3A1E; font-size: 11px; font-weight: 600; background: #FFFBEB;">✏️ Edit</a>

                                    {{-- Form hapus buku dengan konfirmasi --}}
                                    <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" onsubmit="return confirm('Yakin hapus buku ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="padding: 6px 12px; background: #FFF1F1; color: #991b1b; border: 1px solid #fca5a5; border-radius: 6px; cursor: pointer; font-size: 11px; font-weight: 600;">🗑️ Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

        </main>
    </div>

</body>
</html>