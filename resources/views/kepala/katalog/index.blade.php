<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Katalog Buku</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: ui-sans-serif, system-ui; background-color: #F5F0E8; }
        .sidebar-link {
            display: flex; align-items: center; gap: 8px;
            padding: 9px 12px; border-radius: 8px;
            color: #C8DDB0; font-size: 13px; text-decoration: none;
            transition: background 0.15s, color 0.15s;
        }
        .sidebar-link:hover { background: rgba(212,160,23,0.15); color: #F5E8CC; }
        .sidebar-link.active { background: #D4A017; color: #2D3A1E; font-weight: 600; }
        .book-card {
            background: #FFFDF8;
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid #E8E2D4;
            box-shadow: 0 2px 8px rgba(45,58,30,0.06);
            display: flex;
            flex-direction: column;
            transition: box-shadow 0.15s, transform 0.15s;
        }
        .book-card:hover {
            box-shadow: 0 6px 20px rgba(45,58,30,0.13);
            transform: translateY(-2px);
        }
        select:focus, input:focus { outline: none; border-color: #D4A017 !important; }
    </style>
</head>

<body>

{{-- NAVBAR --}}
<nav style="background-color: #2D3A1E; height: 56px; padding: 0 32px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; border-bottom: 2px solid #D4A017;">
    <span style="color: #F5F0E8; font-size: 17px; font-weight: bold; font-style: italic;">Sistem Perpustakaan</span>

    <div id="profileWrapper" style="position: relative;">
        <button onclick="toggleDropdown()" style="display: flex; align-items: center; gap: 8px; color: #F5F0E8; font-size: 14px; cursor: pointer; background: none; border: none; padding: 6px 10px; border-radius: 8px;">
            @if(Auth::user()->foto)
                <img src="{{ asset('storage/' . Auth::user()->foto) }}" style="width: 34px; height: 34px; border-radius: 50%; object-fit: cover; border: 2px solid #D4A017;" alt="Profile">
            @else
                <div style="width: 34px; height: 34px; border-radius: 50%; background-color: #D4A017; color: #2D3A1E; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700;">
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
                <p style="margin: 1px 0 0 0; font-size: 11px; color: #8A7E6E;">Kepala Perpustakaan</p>
            </div>
            <a href="{{ route('kepala.profil') }}" style="display: flex; align-items: center; gap: 10px; padding: 10px 16px; font-size: 13px; color: #3A3020; text-decoration: none;">
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
        <span style="font-size: 10px; color: #7A9E5A; text-transform: uppercase; letter-spacing: 0.08em; padding: 0 8px; margin: 0 0 4px 0;">Menu Kepala</span>
        <a href="{{ route('kepala.dashboard') }}" class="sidebar-link {{ request()->routeIs('kepala.dashboard') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('kepala.petugas.index') }}" class="sidebar-link {{ request()->routeIs('kepala.petugas.*') ? 'active' : '' }}">Data Petugas</a>
        <a href="{{ route('kepala.katalog') }}" class="sidebar-link {{ request()->routeIs('kepala.katalog') ? 'active' : '' }}">Katalog Buku</a>
        <a href="{{ route('kepala.anggota.index') }}" class="sidebar-link {{ request()->routeIs('kepala.anggota.*') ? 'active' : '' }}">Daftar Anggota</a>
        <a href="{{ route('kepala.laporan') }}" class="sidebar-link {{ request()->routeIs('kepala.laporan') ? 'active' : '' }}">Laporan</a>
    </aside>

    {{-- MAIN CONTENT --}}
    <main style="flex: 1; padding: 32px;">

        {{-- Page Header --}}
        <div style="margin-bottom: 24px;">
            <h1 style="font-size: 22px; font-weight: 700; color: #2D3A1E; margin: 0 0 4px;">Katalog Buku</h1>
            <p style="font-size: 13px; color: #8A7E6E; margin: 0;">Daftar seluruh koleksi buku perpustakaan.</p>
        </div>

        {{-- FILTER --}}
        <form method="GET" action="{{ route('kepala.katalog') }}"
              style="display: flex; justify-content: flex-end; gap: 10px; margin-bottom: 24px; flex-wrap: wrap;">

            {{-- Dropdown Kategori --}}
            <select name="kategori_id" onchange="this.form.submit()"
                    style="border: 1px solid #DDD6C8; border-radius: 10px; padding: 8px 12px; font-size: 13px; color: #2D3A1E; background: #FFFDF8; cursor: pointer;">
                <option value="">Semua Kategori</option>
                @foreach ($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>

            {{-- Search --}}
            <div style="display: flex; align-items: center; gap: 8px; background: #FFFDF8; border: 1px solid #DDD6C8; border-radius: 10px; padding: 8px 14px; box-shadow: 0 1px 4px rgba(45,58,30,0.06);">
                <svg xmlns="http://www.w3.org/2000/svg" style="width: 15px; height: 15px; color: #8A7E6E; flex-shrink: 0;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari buku..."
                       style="outline: none; border: 0; font-size: 13px; width: 180px; background: transparent; color: #2D3A1E;">
            </div>
        </form>

        {{-- GRID BUKU --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; align-items: stretch;">

            @forelse ($bukus as $buku)
            <div class="book-card">

                {{-- Cover --}}
                @if($buku->foto)
                    <img src="{{ asset('storage/' . $buku->foto) }}"
                         style="width: 100%; height: 350px; object-fit: cover; flex-shrink: 0;">
                @else
                    <div style="width: 100%; height: 220px; background: #E8F0DC; display: flex; align-items: center; justify-content: center; font-size: 48px; flex-shrink: 0;">
                        📚
                    </div>
                @endif

                {{-- Info --}}
                <div style="padding: 14px 16px; display: flex; flex-direction: column; flex: 1;">

                    {{-- Judul --}}
                    <p style="font-size: 13px; font-weight: 700; color: #2D3A1E; margin: 0 0 4px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 2.5rem; line-height: 1.4;">
                        {{ $buku->judul }}
                    </p>

                    {{-- Pengarang --}}
                    <p style="font-size: 11px; color: #8A7E6E; margin: 0 0 10px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        {{ $buku->pengarang }}
                    </p>

                    {{-- Badge Kategori --}}
                    <span style="display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 10px; font-weight: 700; background: #2D3A1E; color: #D4A017; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 10px; align-self: flex-start;">
                        {{ $buku->kategori->nama_kategori ?? '-' }}
                    </span>

                    {{-- Stok --}}
                    <div style="margin-top: auto; display: flex; align-items: center; justify-content: space-between;">
                        <span style="font-size: 11px; color: #8A7E6E;">Stok</span>
                        <span style="font-size: 13px; font-weight: 700; color: {{ $buku->stok > 0 ? '#2D3A1E' : '#8B3A3A' }};">
                            {{ $buku->stok }}
                        </span>
                    </div>

                    {{-- View Only --}}
                    <span style="font-size: 11px; color: #A09080; font-style: italic; margin-top: 6px;">View Only</span>
                </div>
            </div>

            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px 0; color: #8A7E6E;">
                    <p style="font-size: 40px; margin: 0 0 12px;">📭</p>
                    <p style="font-size: 14px; margin: 0;">Tidak ada buku yang ditemukan.</p>
                </div>
            @endforelse

        </div>

    </main>
</div>

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