<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Petugas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="margin: 0; font-family: ui-sans-serif, system-ui, sans-serif; background-color: #F5F0E8; box-sizing: border-box;">

    {{-- NAVBAR --}}
    <nav style="background-color: #2D3A1E; height: 56px; padding: 0 32px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; border-bottom: 2px solid #D4A017;">
        <span style="color: #F5F0E8; font-size: 17px; font-weight: bold; font-style: italic; letter-spacing: 0.02em;">Sistem Perpustakaan</span>

        {{-- DROPDOWN PROFIL --}}
        <div class="profile-wrapper" id="profileWrapper" style="position: relative;">
            <button class="profile-btn" onclick="toggleDropdown()" style="display: flex; align-items: center; gap: 8px; color: #F5F0E8; font-size: 14px; cursor: pointer; background: none; border: none; padding: 6px 10px; border-radius: 8px;">
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

                <a href="{{ route('petugas.profil') }}" style="display: flex; align-items: center; gap: 10px; padding: 10px 16px; font-size: 13px; color: #3A3020; text-decoration: none; transition: background 0.12s;">
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

            <a href="{{ route('petugas.dashboard') }}" style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; background: #D4A017; color: #2D3A1E; font-size: 13px; text-decoration: none; font-weight: 600;">
                Dashboard
            </a>

            <a href="{{ route('buku.index') }}" style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">
                Data Buku
            </a>

            <a href="{{ route('anggota.index') }}" style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">
                Data Anggota
            </a>

            <a href="{{ route('peminjaman.index') }}" style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none; position: relative;">
                Peminjaman
                @if(!empty($perluVerifikasi) && $perluVerifikasi > 0)
                    <span style="background-color:#D4A017; color:#2D3A1E; font-size: 10px; font-weight: bold; border-radius: 50%; width: 18px; height: 18px; display: flex; align-items: center; justify-content: center; position: absolute; right: 8px;">
                        {{ $perluVerifikasi > 9 ? '9+' : $perluVerifikasi }}
                    </span>
                @endif
            </a>

            <a href="{{ route('kategori.index') }}" style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">
                Kategori
            </a>

            <a href="{{ route('denda.index') }}" style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">
                Denda
            </a>
        </aside>

        {{-- MAIN CONTENT --}}
        <main style="flex: 1; padding: 32px;">
            <div style="margin-bottom: 28px;">
                <h1 style="font-size: 24px; font-weight: 700; color: #2D3A1E; margin: 0 0 4px;">Dashboard Petugas</h1>
                <p style="font-size: 14px; color: #8A7E6E; margin: 0;">Halo {{ Auth::user()->name }}, mari kelola perpustakaan hari ini! 👋</p>
            </div>

            {{-- Stat Cards --}}
<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 24px;">

    {{-- Card 1: Total Buku (Biru Gelap) --}}
    <div style="background: #1E3A5F; border-radius: 16px; padding: 24px; border: 1px solid #16304F; display: flex; align-items: center; gap: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <div style="width: 52px; height: 52px; border-radius: 12px; background: rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center; font-size: 24px;">📚</div>
        <div>
            <p style="margin: 0; font-size: 13px; color: rgba(255,255,255,0.7);">Total Buku</p>
            <p style="margin: 0; font-size: 28px; font-weight: 700; color: #FFFFFF;">{{ \App\Models\Buku::count() }}</p>
        </div>
    </div>

    {{-- Card 2: Total Anggota (Kuning Gelap) --}}
    <div style="background: #7A5C00; border-radius: 16px; padding: 24px; border: 1px solid #664E00; display: flex; align-items: center; gap: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <div style="width: 52px; height: 52px; border-radius: 12px; background: rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center; font-size: 24px;">👤</div>
        <div>
            <p style="margin: 0; font-size: 13px; color: rgba(255,255,255,0.7);">Total Anggota</p>
            <p style="margin: 0; font-size: 28px; font-weight: 700; color: #FFFFFF;">{{ \App\Models\User::where('role', 'anggota')->count() }}</p>
        </div>
    </div>

    {{-- Card 3: Pinjaman Aktif (Hijau Gelap) --}}
    <div style="background: #1A3D1F; border-radius: 16px; padding: 24px; border: 1px solid #132D17; display: flex; align-items: center; gap: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <div style="width: 52px; height: 52px; border-radius: 12px; background: rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center; font-size: 24px;">📖</div>
        <div>
            <p style="margin: 0; font-size: 13px; color: rgba(255,255,255,0.7);">Pinjaman Aktif</p>
            <p style="margin: 0; font-size: 28px; font-weight: 700; color: #FFFFFF;">{{ \App\Models\Peminjaman::where('status', 'dipinjam')->count() }}</p>
        </div>
    </div>

</div>    

            {{-- Bottom Section --}}
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                {{-- Quick Access --}}
                <div style="background: white; border-radius: 16px; padding: 24px; border: 1px solid #E8E2D4;">
                    <p style="font-size: 15px; font-weight: 700; color: #2D3A1E; margin-bottom: 20px; border-left: 4px solid #D4A017; padding-left: 12px;">⚡ Akses Cepat</p>
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <a href="{{ route('buku.create') }}" style="display: flex; align-items: center; gap: 12px; padding: 14px; border-radius: 12px; text-decoration: none; background: #2D3A1E; color: #D4A017; font-weight: 600; font-size: 13px;">
                            <span>➕</span> Tambah Buku Baru
                        </a>
                        <a href="{{ route('peminjaman.index') }}" style="display: flex; align-items: center; gap: 12px; padding: 14px; border-radius: 12px; text-decoration: none; background: #D4A017; color: #2D3A1E; font-weight: 600; font-size: 13px;">
                            <span>🔍</span> Verifikasi Peminjaman
                        </a>
                    </div>
                </div>

                {{-- Status Koleksi --}}
                <div style="background: white; border-radius: 16px; padding: 24px; border: 1px solid #E8E2D4;">
                    <p style="font-size: 15px; font-weight: 700; color: #2D3A1E; margin-bottom: 20px; border-left: 4px solid #D4A017; padding-left: 12px;">📊 Status Koleksi</p>
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 13px; color: #8A7E6E;">Buku Stok Habis</span>
                            <span style="background: #FFF1F1; color: #991B1B; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700;">
                                {{ \App\Models\Buku::where('stok', 0)->count() }} Judul
                            </span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 13px; color: #8A7E6E;">Total Kategori</span>
                            <span style="background: #F5F0E8; color: #2D3A1E; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700;">
                                {{ \App\Models\Kategori::count() }} Jenis
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    {{-- SCRIPTS --}}
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
</body>
</html>