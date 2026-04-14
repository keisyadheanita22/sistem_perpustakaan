<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Denda</title>
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

        {{-- ============================== --}}
        {{-- SIDEBAR - Menu navigasi kiri   --}}
        {{-- ============================== --}}
        <aside style="width: 176px; background-color: #2D3A1E; padding: 20px 12px; display: flex; flex-direction: column; gap: 6px; flex-shrink: 0;">

            <span style="font-size: 10px; color: #7A9E5A; text-transform: uppercase; letter-spacing: 0.08em; padding: 0 8px; margin: 0 0 4px 0;">Menu Petugas</span>

            <a href="{{ route('petugas.dashboard') }}"
               style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">
                Dashboard
            </a>
            <a href="{{ route('buku.index') }}"
               style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">
                Data Buku
            </a>
            <a href="{{ route('anggota.index') }}"
               style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">
                Data Anggota
            </a>

            {{-- Link: Peminjaman + badge notifikasi --}}
            <a href="{{ route('peminjaman.index') }}"
               style="display: flex; align-items: center; justify-content: space-between; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">
                <span>Peminjaman</span>
                @if(!empty($perluVerifikasi) && $perluVerifikasi > 0)
                    <span style="background-color: #D4A017; color: #2D3A1E; font-size: 10px; font-weight: bold; border-radius: 50%; width: 18px; height: 18px; display: flex; align-items: center; justify-content: center;">
                        {{ $perluVerifikasi > 9 ? '9+' : $perluVerifikasi }}
                    </span>
                @endif
            </a>

            <a href="{{ route('kategori.index') }}"
               style="display: flex; align-items: center; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">
                Kategori
            </a>

            {{-- Link: Denda - AKTIF, kuning emas karena halaman ini bagian dari Denda --}}
            <a href="{{ route('denda.index') }}"
               style="display: flex; align-items: center; padding: 9px 12px; border-radius: 8px; background: #D4A017; color: #2D3A1E; font-size: 13px; text-decoration: none; font-weight: 600;">
                Denda
            </a>
        </aside>

        {{-- ============================================= --}}
        {{-- KONTEN UTAMA - card di tengah                 --}}
        {{-- ============================================= --}}
        <main style="flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 32px;">

            {{-- Judul halaman --}}
            <div style="width: 100%; max-width: 480px; margin-bottom: 20px;">
                <h1 style="font-size: 24px; font-weight: 700; color: #2D3A1E; margin: 0;">Pengaturan Denda</h1>
                <p style="font-size: 13px; color: #8A7E6E; margin: 6px 0 0 0;">Atur nominal denda keterlambatan per hari</p>
            </div>

            {{-- Notifikasi sukses --}}
            @if(session('success'))
                <div id="flash-success"
                     style="width: 100%; max-width: 480px; background-color: #dcfce7; border: 1px solid #22c55e; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 13px; display: flex; align-items: center; justify-content: space-between; box-sizing: border-box;">
                    <span>✅ {{ session('success') }}</span>
                    <button onclick="document.getElementById('flash-success').style.display='none'"
                            style="background: none; border: none; color: #166534; cursor: pointer; font-size: 18px;">&times;</button>
                </div>
            @endif

            {{-- Card form pengaturan denda --}}
            <div style="width: 100%; max-width: 480px; background: #F9F9F9; border-radius: 16px; border: 1px solid #D4A017; box-shadow: 0 8px 24px rgba(0,0,0,0.10); overflow: hidden;">

                {{-- Header card: ikon gear + deskripsi --}}
                <div style="display: flex; align-items: center; gap: 14px; padding: 18px 24px; border-bottom: 1px solid #E8E2D4; background: #FFFDF8;">
                    {{-- Ikon roda gigi sebagai representasi pengaturan, aksen kuning emas --}}
                    <div style="width: 42px; height: 42px; border-radius: 10px; background-color: #FEF3C7; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 20px;">
                        ⚙️
                    </div>
                    <div>
                        <p style="font-size: 14px; font-weight: 700; color: #2D3A1E; margin: 0;">Ubah Nominal Denda</p>
                        <p style="font-size: 12px; color: #8A7E6E; margin: 4px 0 0 0;">Perubahan berlaku untuk denda yang baru dibuat</p>
                    </div>
                </div>

                {{-- Form pengaturan denda: kirim ke denda.updatePengaturan via POST --}}
                <form action="{{ route('denda.updatePengaturan') }}" method="POST" style="padding: 24px;">
                    @csrf

                    {{-- Input nominal denda per hari --}}
                    <div style="margin-bottom: 8px;">
                        <label style="display: block; font-size: 13px; font-weight: 600; color: #2D3A1E; margin-bottom: 8px;">
                            Denda Per Hari (Rp)
                        </label>

                        {{-- Wrapper input dengan prefix "Rp" --}}
                        <div style="display: flex; align-items: center; border: 1px solid #D4A017; border-radius: 8px; background: white; overflow: hidden;"
                             id="input-wrapper">
                            <span style="padding: 10px 14px; background: #F5F0E8; color: #8A7E6E; font-size: 13px; font-weight: 600; border-right: 1px solid #D4A017;">Rp</span>
                            <input type="number"
                                   name="nilai"
                                   value="{{ $pengaturan->nilai ?? 2000 }}"
                                   min="0"
                                   style="flex: 1; border: none; padding: 10px 14px; font-size: 13px; color: #2D3A1E; outline: none; background: transparent;"
                                   onfocus="document.getElementById('input-wrapper').style.borderColor='#1E3A5F'; document.getElementById('input-wrapper').style.boxShadow='0 0 0 3px rgba(30,58,95,0.1)'"
                                   onblur="document.getElementById('input-wrapper').style.borderColor='#D4A017'; document.getElementById('input-wrapper').style.boxShadow='none'">
                        </div>

                        {{-- Pesan error validasi --}}
                        @error('nilai')
                            <p style="color: #991b1b; font-size: 12px; margin: 6px 0 0 0;">⚠️ {{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Divider tipis sebelum tombol --}}
                    <div style="border-top: 1px solid #E8E2D4; margin: 20px 0;"></div>

                    {{-- Tombol aksi: Simpan dan Batal --}}
                    <div style="display: flex; gap: 10px;">

                        {{-- Tombol simpan, warna hijau gelap --}}
                        <button type="submit"
                                style="display: flex; align-items: center; gap: 6px; padding: 10px 20px; background-color: #2D3A1E; color: #F5F0E8; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer;">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width: 14px; height: 14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan
                        </button>

                        {{-- Tombol batal, kembali ke daftar denda --}}
                        <a href="{{ route('denda.index') }}"
                           style="display: flex; align-items: center; gap: 6px; padding: 10px 20px; background: white; color: #8A7E6E; border: 1px solid #E8E2D4; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none;">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width: 14px; height: 14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Batal
                        </a>
                    </div>
                </form>
            </div>

        </main>
    </div>

</body>
</html>