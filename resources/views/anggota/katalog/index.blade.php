<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Buku</title>
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
               style="display: flex; align-items: center; padding: 9px 12px; border-radius: 8px; background: #D4A017; color: #2D3A1E; font-size: 13px; text-decoration: none; font-weight: 600;">
                Katalog Buku
            </a>

            <a href="{{ route('peminjaman.saya') }}"
               style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">
                Peminjaman Saya
            </a>

            <a href="{{ route('denda.saya') }}"
               style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">
                Denda Saya
            </a>

        </aside>

        {{-- ============================== --}}
        {{-- KONTEN UTAMA                   --}}
        {{-- ============================== --}}
        <main style="flex: 1; padding: 32px;">

            {{-- Judul halaman --}}
            <div style="margin-bottom: 24px;">
                <h1 style="font-size: 24px; font-weight: 700; color: #2D3A1E; margin: 0;">Katalog Buku</h1>
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

            {{-- Filter kategori dan pencarian --}}
            <div style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 24px; gap: 10px;">
                <form method="GET" action="{{ route('katalog.index') }}" style="display: flex; align-items: center; gap: 10px;">

                    {{-- Dropdown kategori --}}
                    <select name="kategori_id" onchange="this.form.submit()"
                        style="border: 1px solid #D4A017; border-radius: 8px; padding: 8px 12px; font-size: 13px; outline: none; background: #FFFDF8; color: #2D3A1E; cursor: pointer;">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>

                    {{-- Input pencarian --}}
                    <div style="display: flex; align-items: center; border: 1px solid #D4A017; border-radius: 8px; padding: 8px 12px; gap: 8px; background: #FFFDF8;">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width: 14px; height: 14px; color: #8A7E6E;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                        </svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Buku..."
                               style="outline: none; font-size: 13px; width: 180px; background: transparent; color: #2D3A1E; border: none;">
                    </div>
                </form>
            </div>

            {{-- Kosong --}}
            @if($bukus->isEmpty())
            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 64px 0; color: #8A7E6E;">
                <span style="font-size: 48px; margin-bottom: 12px;">📚</span>
                <span style="font-style: italic; font-size: 14px;">Tidak ada data buku.</span>
            </div>

            @else
            {{-- ===== GRID KARTU BUKU ===== --}}
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;">
                @foreach ($bukus as $buku)
                <div style="background: #FFFFFF; border-radius: 12px; overflow: hidden; border: 1px solid #E8E2D4; box-shadow: 0 4px 10px rgba(0,0,0,0.06); display: flex; flex-direction: column; transition: box-shadow 0.2s;"
                     onmouseover="this.style.boxShadow='0 8px 20px rgba(0,0,0,0.12)'"
                     onmouseout="this.style.boxShadow='0 4px 10px rgba(0,0,0,0.06)'">

                    {{-- Cover buku --}}
                    @if($buku->foto)
                        <img src="{{ asset('storage/' . $buku->foto) }}" alt="{{ $buku->judul }}"
                             style="width: 100%; height: 300px; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 260px; background: linear-gradient(135deg, #2D3A1E, #4a5c2e); display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px;">
                            <span style="font-size: 36px;">📚</span>
                            <span style="font-size: 11px; font-weight: 600; color: #C8DDB0; text-align: center; padding: 0 12px;">{{ Str::limit($buku->judul, 20) }}</span>
                        </div>
                    @endif

                    <div style="padding: 14px; display: flex; flex-direction: column; flex: 1; gap: 4px;">

                        <p style="font-weight: 700; color: #2D3A1E; font-size: 13px; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $buku->judul }}</p>
                        <p style="font-size: 12px; color: #8A7E6E; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $buku->pengarang }}</p>

                        {{-- Badge kategori --}}
                        @if($buku->kategori)
                        <span style="display: inline-block; padding: 2px 10px; border-radius: 20px; font-size: 10px; font-weight: 600; background-color: #FEF3C7; color: #92400e; margin-top: 2px; width: fit-content;">
                            {{ $buku->kategori->nama_kategori }}
                        </span>
                        @endif

                        <p style="font-size: 12px; color: #8A7E6E; margin: 4px 0 10px 0;">Stok: {{ $buku->stok }}</p>

                        {{-- Tombol pinjam / stok habis --}}
                        @if($buku->stok > 0)
                        <form action="{{ route('peminjaman.pinjam', $buku->id) }}" method="POST" style="margin-top: auto;">
                            @csrf
                            <button type="submit"
                                    style="width: 100%; padding: 10px; border-radius: 8px; font-weight: 700; font-size: 13px;color:#D4A017; background-color: #1E3A5F;; border: none; cursor: pointer; transition: background 0.15s;"
                                    onmouseover="this.style.backgroundColor='#162d4a'"
                                    onmouseout="this.style.backgroundColor='#1E3A5F'">
                                📖 Pinjam
                            </button>
                        </form>
                        @else
                        <button disabled
                                style="width: 100%; padding: 10px; border-radius: 8px; font-weight: 700; font-size: 13px; color: #8A7E6E; background-color: #E8E2D4; border: none; cursor: not-allowed; margin-top: auto;">
                            Stok Habis
                        </button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @endif

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