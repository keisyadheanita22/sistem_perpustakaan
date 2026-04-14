<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Petugas</title>
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
        .search-input { outline: none; border: 0; font-size: 13px; width: 100%; background: transparent; color: #2D3A1E; }
        .search-input::placeholder { color: #A09080; }
        #emptySearch.hidden { display: none; }
        #emptySearch { text-align: center; padding: 40px 0; color: #8A7E6E; font-size: 13px; }
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
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <div>
                <h1 style="font-size: 22px; font-weight: 700; color: #2D3A1E; margin: 0 0 4px;">Data Petugas</h1>
                <p style="font-size: 13px; color: #8A7E6E; margin: 0;">Kelola akun petugas perpustakaan.</p>
            </div>
            <a href="{{ route('kepala.petugas.create') }}"
               style="display: flex; align-items: center; gap: 6px; padding: 9px 18px; border-radius: 10px; background: #2D3A1E; color: #D4A017; font-size: 13px; font-weight: 700; text-decoration: none;">
                + Tambah Petugas
            </a>
        </div>

        {{-- Notifikasi sukses --}}
        @if(session('success'))
            <div style="background: #E8F0DC; border: 1px solid #7A9E5A; color: #2D3A1E; padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; font-size: 13px;">
                {{ session('success') }}
            </div>
        @endif

        @if($petugas->isEmpty())
            <div style="background: #FFFDF8; border: 1px solid #E8E2D4; border-radius: 14px; padding: 60px 24px; display: flex; flex-direction: column; align-items: center; gap: 12px;">
                <span style="font-size: 48px;">👤</span>
                <p style="margin: 0; color: #8A7E6E; font-size: 14px;">Belum ada data petugas.</p>
            </div>
        @else

            {{-- Search Bar --}}
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
                <div style="display: flex; align-items: center; gap: 8px; background: #FFFDF8; border: 1px solid #DDD6C8; border-radius: 10px; padding: 9px 14px; width: 280px; box-shadow: 0 1px 4px rgba(45,58,30,0.06);">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width: 15px; height: 15px; color: #8A7E6E; flex-shrink: 0;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                    </svg>
                    <input type="text" id="searchInput" placeholder="Cari nama atau email..."
                        oninput="filterTable()" class="search-input">
                </div>
            </div>

            {{-- Tabel --}}
            <div style="background: #FFFDF8; border-radius: 14px; border: 1px solid #E8E2D4; overflow: hidden; box-shadow: 0 2px 12px rgba(45,58,30,0.06);">
                <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                    <thead>
                        <tr style="background: #2D3A1E;">
                            <th style="padding: 13px 18px; text-align: left; font-size: 11px; font-weight: 700; color: #D4A017; text-transform: uppercase; letter-spacing: 0.07em;">No</th>
                            <th style="padding: 13px 18px; text-align: left; font-size: 11px; font-weight: 700; color: #D4A017; text-transform: uppercase; letter-spacing: 0.07em;">Nama</th>
                            <th style="padding: 13px 18px; text-align: left; font-size: 11px; font-weight: 700; color: #D4A017; text-transform: uppercase; letter-spacing: 0.07em;">Username</th>
                            <th style="padding: 13px 18px; text-align: left; font-size: 11px; font-weight: 700; color: #D4A017; text-transform: uppercase; letter-spacing: 0.07em;">Email</th>
                            <th style="padding: 13px 18px; text-align: center; font-size: 11px; font-weight: 700; color: #D4A017; text-transform: uppercase; letter-spacing: 0.07em;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @foreach ($petugas as $index => $p)
                        <tr data-nama="{{ strtolower($p->name) }}"
                            data-email="{{ strtolower($p->email) }}"
                            style="border-top: 1px solid #EDE7DA; transition: background 0.12s;">
                            <td style="padding: 13px 18px; color: #A09080;">{{ $index + 1 }}</td>
                            <td style="padding: 13px 18px; font-weight: 600; color: #2D3A1E;">{{ $p->name }}</td>
                            <td style="padding: 13px 18px; color: #5A6E4A;">{{ $p->username ?? '-' }}</td>
                            <td style="padding: 13px 18px; color: #5A6E4A;">{{ $p->email }}</td>
                            <td style="padding: 13px 18px;">
                                <div style="display: flex; align-items: center; justify-content: center; gap: 8px;">

                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('kepala.petugas.edit', $p->id) }}"
                                       style="font-size: 12px; padding: 5px 12px; border-radius: 8px; background: #E8F0DC; color: #2D3A1E; border: 1px solid #B8D09A; font-weight: 600; text-decoration: none;">
                                        ✏️ Edit
                                    </a>

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('kepala.petugas.destroy', $p->id) }}" method="POST"
                                          onsubmit="return confirm('Yakin hapus petugas ini?')" style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                style="font-size: 12px; padding: 5px 12px; border-radius: 8px; background: #FDE8E8; color: #8B3A3A; border: 1px solid #F5A8A8; font-weight: 600; cursor: pointer;">
                                            🗑️ Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div id="emptySearch" class="hidden">
                    Tidak ada petugas yang cocok dengan pencarian.
                </div>
            </div>
        @endif

    </main>
</div>

<script>
    function filterTable() {
        const keyword = document.getElementById('searchInput').value.toLowerCase().trim();
        const rows    = document.querySelectorAll('#tableBody tr');
        const empty   = document.getElementById('emptySearch');
        let visible   = 0;

        rows.forEach(row => {
            const match = row.dataset.nama.includes(keyword) || row.dataset.email.includes(keyword);
            row.style.display = match ? '' : 'none';
            if (match) visible++;
        });

        empty.classList.toggle('hidden', visible > 0);
    }

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