<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Petugas</title>
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
        .form-input {
            width: 100%; border: 1px solid #DDD6C8; border-radius: 10px;
            padding: 9px 12px; font-size: 13px; color: #2D3A1E;
            background: #FDFAF5; outline: none;
            transition: border-color 0.15s;
        }
        .form-input:focus { border-color: #D4A017; box-shadow: 0 0 0 3px rgba(212,160,23,0.12); }
        .form-input.error { border-color: #E05252; }
        .form-label { display: block; font-size: 12px; font-weight: 600; color: #2D3A1E; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.05em; }
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
    <main style="flex: 1; padding: 32px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
        <div style="width: 100%; max-width: 480px;">

            {{-- Header --}}
            <div style="margin-bottom: 24px;">
                <a href="{{ route('kepala.petugas.index') }}" style="font-size: 12px; color: #8A7E6E; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; margin-bottom: 8px;">
                    ← Kembali ke Data Petugas
                </a>
                <h1 style="font-size: 22px; font-weight: 700; color: #2D3A1E; margin: 0 0 4px;">Tambah Petugas</h1>
                <p style="font-size: 13px; color: #8A7E6E; margin: 0;">Isi data akun petugas baru.</p>
            </div>

            {{-- Form Card --}}
            <div style="background: #FFFDF8; border-radius: 14px; border: 1px solid #E8E2D4; padding: 28px; box-shadow: 0 2px 12px rgba(45,58,30,0.06);">

                {{-- Error validasi --}}
                @if($errors->any())
                <div style="background: #FDE8E8; border: 1px solid #F5A8A8; color: #8B3A3A; padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 13px;">
                    <ul style="margin: 0; padding-left: 16px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('kepala.petugas.store') }}">
                    @csrf

                    {{-- Nama Lengkap --}}
                    <div style="margin-bottom: 16px;">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               placeholder="Masukkan nama petugas"
                               class="form-input @error('name') error @enderror">
                    </div>

                    {{-- Email --}}
                    <div style="margin-bottom: 16px;">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               placeholder="Masukkan email petugas"
                               class="form-input @error('email') error @enderror">
                    </div>

                    {{-- Username --}}
                    <div style="margin-bottom: 16px;">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" value="{{ old('username') }}"
                               placeholder="Masukkan username untuk login"
                               class="form-input @error('username') error @enderror">
                    </div>

                    {{-- Password --}}
                    <div style="margin-bottom: 16px;">
                        <label class="form-label">Password</label>
                        <input type="password" name="password"
                               placeholder="Minimal 8 karakter"
                               class="form-input @error('password') error @enderror">
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div style="margin-bottom: 24px;">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation"
                               placeholder="Ulangi password"
                               class="form-input">
                    </div>

                    {{-- Tombol --}}
                    <div style="display: flex; gap: 10px;">
                        <button type="submit"
                                style="padding: 10px 22px; border-radius: 10px; background: #2D3A1E; color: #D4A017; font-size: 13px; font-weight: 700; border: none; cursor: pointer;">
                            Simpan Petugas
                        </button>
                        <a href="{{ route('kepala.petugas.index') }}"
                           style="padding: 10px 22px; border-radius: 10px; background: #F0EBE0; color: #5A4E3A; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center;">
                            Batal
                        </a>
                    </div>
                </form>
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