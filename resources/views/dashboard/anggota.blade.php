<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Anggota</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="margin: 0; font-family: ui-sans-serif, system-ui; background-color: #F5F0E8;">

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

            <div id="dropdownMenu" style="display: none; position: absolute; top: calc(100% + 8px); right: 0; background: #FFFDF8; border: 1px solid #DDD6C8; border-radius: 12px; min-width: 180px; box-shadow: 0 8px 24px rgba(45,58,30,0.15); overflow: hidden;">
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

        {{-- SIDEBAR --}}
        <aside style="width: 176px; background-color: #2D3A1E; padding: 20px 12px; display: flex; flex-direction: column; gap: 6px; flex-shrink: 0;">
            <span style="font-size: 10px; color: #7A9E5A; text-transform: uppercase; letter-spacing: 0.08em; padding: 0 8px; margin: 0 0 4px 0;">Menu Anggota</span>

            <a href="{{ route('anggota.dashboard') }}" style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; background: #D4A017; color: #2D3A1E; font-size: 13px; text-decoration: none; font-weight: 600;">
                Dashboard
            </a>
            <a href="{{ route('katalog.index') }}" style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">
                Katalog Buku
            </a>
            <a href="{{ route('peminjaman.saya') }}" style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">
                Peminjaman Saya
            </a>
            <a href="{{ route('denda.saya') }}" style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">
                Denda Saya
            </a>

        </aside>

        {{-- MAIN --}}
        <main style="flex: 1; padding: 32px;">
            <div style="margin-bottom: 28px;">
                <h1 style="font-size: 22px; font-weight: 700; color: #2D3A1E; margin: 0 0 4px;">Dashboard Anggota</h1>
                <p style="font-size: 13px; color: #8A7E6E; margin: 0;">Selamat datang kembali, {{ Auth::user()->name }}! 👋</p>
            </div>

            {{-- Stat Cards --}}
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 24px;">
                <div style="background: #FFFDF8; border-radius: 14px; padding: 20px 22px; border: 1px solid #E8E2D4; display: flex; align-items: center; gap: 16px;">
                    <div style="width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0; background: #E8F0DC;">📚</div>
                    <div>
                        <p style="margin: 0; font-size: 12px; color: #8A7E6E;">Total Buku</p>
                        <p style="margin: 0; font-size: 28px; font-weight: 700; color: #2D3A1E; line-height: 1.1;">{{ \App\Models\Buku::count() }}</p>
                        <p style="margin: 2px 0 0 0; font-size: 11px; color: #B0A894;">Buku tersedia</p>
                    </div>
                </div>

                <div style="background: #FFFDF8; border-radius: 14px; padding: 20px 22px; border: 1px solid #E8E2D4; display: flex; align-items: center; gap: 16px;">
                    <div style="width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0; background: #DDE8F5;">📖</div>
                    <div>
                        <p style="margin: 0; font-size: 12px; color: #8A7E6E;">Peminjaman Saya</p>
                        <p style="margin: 0; font-size: 28px; font-weight: 700; color: #2D3A1E; line-height: 1.1;">{{ \App\Models\Peminjaman::where('nama_anggota', Auth::user()->name)->count() }}</p>
                        <p style="margin: 2px 0 0 0; font-size: 11px; color: #B0A894;">Total peminjaman</p>
                    </div>
                </div>

                <div style="background: #FFFDF8; border-radius: 14px; padding: 20px 22px; border: 1px solid #E8E2D4; display: flex; align-items: center; gap: 16px;">
                    <div style="width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0; background: #F5E8CC;">⚠️</div>
                    <div>
                        <p style="margin: 0; font-size: 12px; color: #8A7E6E;">Denda Saya</p>
                        <p style="margin: 0; font-size: 28px; font-weight: 700; color: #8B3A3A; line-height: 1.1;">{{ \App\Models\Denda::where('nama_anggota', Auth::user()->name)->where('status_bayar', 'belum_bayar')->count() }}</p>
                        <p style="margin: 2px 0 0 0; font-size: 11px; color: #B0A894;">Belum dibayar</p>
                    </div>
                </div>
            </div>

            {{-- Quick Access --}}
            <div style="background: #FFFDF8; border-radius: 14px; padding: 22px 24px; border: 1px solid #E8E2D4;">
                <p style="font-size: 14px; font-weight: 600; color: #2D3A1E; margin: 0 0 16px;">⚡ Akses Cepat</p>
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;">
                    <a href="{{ route('katalog.index') }}" style="display: flex; flex-direction: column; align-items: center; gap: 8px; padding: 18px 12px; border-radius: 12px; text-decoration: none; font-size: 13px; font-weight: 500; background: #6B4F2A; color: #F5E8D0;">
                        <span style="font-size: 28px;">📚</span> Lihat Katalog Buku
                    </a>
                    <a href="{{ route('peminjaman.saya') }}" style="display: flex; flex-direction: column; align-items: center; gap: 8px; padding: 18px 12px; border-radius: 12px; text-decoration: none; font-size: 13px; font-weight: 500; background: #3A4A6B; color: #D0D8F0;">
                        <span style="font-size: 28px;">📋</span> Peminjaman Saya
                    </a>
                    <a href="{{ route('denda.saya') }}" style="display: flex; flex-direction: column; align-items: center; gap: 8px; padding: 18px 12px; border-radius: 12px; text-decoration: none; font-size: 13px; font-weight: 500; background: #D4A017; color: #2D3A1E;">
                        <span style="font-size: 28px;">💰</span> Denda Saya
                    </a>
                </div>
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