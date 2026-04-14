<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        {{-- Fungsi buka/tutup dropdown profil --}}
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
        }
        {{-- Tutup dropdown kalau klik di luar area menu --}}
        window.onclick = function(event) {
            if (!event.target.closest('#userMenu')) {
                const d = document.getElementById('userDropdown');
                if (d) d.style.display = 'none';
            }
        }
    </script>
</head>
<body style="margin: 0; font-family: ui-sans-serif, system-ui; background-color: #F5F0E8;">

    {{-- ============================== --}}
    {{-- NAVBAR - Sticky bar atas       --}}
    {{-- ============================== --}}
    <nav style="background-color: #2D3A1E; height: 56px; padding: 0 32px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 100;">

        {{-- Nama aplikasi --}}
        <span style="color: #F5F0E8; font-size: 17px; font-weight: bold; font-style: italic;">Sistem Perpustakaan</span>

        {{-- Dropdown profil pengguna --}}
        <div id="userMenu" style="position: relative; cursor: pointer;" onclick="toggleDropdown()">
            <div style="display: flex; align-items: center; gap: 8px; color: #F5F0E8; font-size: 14px;">

                {{-- Foto profil atau inisial nama --}}
                @if(Auth::user()->foto)
                    <img src="{{ asset('storage/' . Auth::user()->foto) }}"
                         style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; border: 1px solid #D4A017;">
                @else
                    <div style="width: 32px; height: 32px; border-radius: 50%; background-color: #D4A017; color: #2D3A1E; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif

                <span>{{ Auth::user()->name }} ▾</span>
            </div>

            {{-- Isi dropdown: profil & logout --}}
            <div id="userDropdown" style="display: none; position: absolute; right: 0; top: 45px; width: 160px; background: white; border-radius: 8px; box-shadow: 0 10px 15px rgba(0,0,0,0.1); border: 1px solid #E8E2D4; overflow: hidden;">
                <a href="{{ route('petugas.profil') }}"
                   style="display: block; padding: 12px 16px; color: #2D3A1E; text-decoration: none; font-size: 13px; font-weight: 600; border-bottom: 1px solid #F0EBE0;">
                    Profil Saya
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            style="width: 100%; text-align: left; background: none; border: none; padding: 12px 16px; color: #9d174d; font-size: 13px; font-weight: 600; cursor: pointer;">
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

            {{-- Link: Kategori - AKTIF, kuning emas karena halaman ini bagian dari Kategori --}}
            <a href="{{ route('kategori.index') }}"
               style="display: flex; align-items: center; padding: 9px 12px; border-radius: 8px; background: #D4A017; color: #2D3A1E; font-size: 13px; text-decoration: none; font-weight: 600;">
                Kategori
            </a>

            {{-- Link: Denda --}}
            <a href="{{ route('denda.index') }}"
               style="display: flex; align-items: center; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">
                Denda
            </a>

            {{-- Tombol logout di bagian bawah sidebar --}}
            <div style="margin-top: auto; padding-top: 16px;">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 6px; padding: 9px 12px; border-radius: 8px; background: none; border: 1px solid #4a5c2e; color: #C8DDB0; font-size: 13px; cursor: pointer;">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width: 14px; height: 14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- ============================== --}}
        {{-- KONTEN UTAMA                   --}}
        {{-- ============================== --}}
        <main style="flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 32px;">

            {{-- Judul halaman --}}
            <div style="width: 100%; max-width: 480px; margin-bottom: 20px;">
                <h1 style="font-size: 24px; font-weight: 700; color: #2D3A1E; margin: 0;">Tambah Kategori</h1>
                <p style="font-size: 13px; color: #8A7E6E; margin: 6px 0 0 0;">Tambahkan kategori buku baru ke sistem</p>
            </div>

            {{-- ============================================= --}}
            {{-- CARD FORM - di tengah, border kuning          --}}
            {{-- ============================================= --}}
            <div style="width: 100%; max-width: 480px; background: #F9F9F9; border-radius: 16px; border: 1px solid #D4A017; box-shadow: 0 8px 24px rgba(0,0,0,0.10); overflow: hidden;">

                {{-- Header card: ikon tag + deskripsi singkat --}}
                <div style="display: flex; align-items: center; gap: 14px; padding: 18px 24px; border-bottom: 1px solid #E8E2D4; background: #FFFDF8;">
                    {{-- Ikon tag/label sebagai representasi kategori, aksen biru tua --}}
                    <div style="width: 42px; height: 42px; border-radius: 10px; background-color: #DBEAFE; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width: 20px; height: 20px;" fill="none" viewBox="0 0 24 24" stroke="#1E3A5F">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <div>
                        <p style="font-size: 14px; font-weight: 700; color: #2D3A1E; margin: 0;">Kategori Baru</p>
                        <p style="font-size: 12px; color: #8A7E6E; margin: 4px 0 0 0;">Isi nama kategori yang ingin ditambahkan</p>
                    </div>
                </div>

                {{-- FORM TAMBAH KATEGORI: kirim data ke KategoriController@store via POST --}}
                <form method="POST" action="{{ route('kategori.store') }}" style="padding: 24px;">
                    @csrf

                    {{-- Input nama kategori baru --}}
                    <div style="margin-bottom: 8px;">
                        <label style="display: block; font-size: 13px; font-weight: 600; color: #2D3A1E; margin-bottom: 8px;">
                            Nama Kategori
                        </label>
                        {{-- old('nama_kategori') menjaga nilai input tetap ada jika validasi gagal --}}
                        <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}"
                               placeholder="Masukkan nama kategori..."
                               style="width: 100%; border: 1px solid #D4A017; border-radius: 8px; padding: 10px 14px; font-size: 13px; color: #2D3A1E; background: white; outline: none; box-sizing: border-box; transition: border-color 0.2s;"
                               onfocus="this.style.borderColor='#1E3A5F'; this.style.boxShadow='0 0 0 3px rgba(30,58,95,0.1)'"
                               onblur="this.style.borderColor='#D4A017'; this.style.boxShadow='none'">

                        {{-- Pesan error validasi dari server, muncul jika input kosong atau tidak valid --}}
                        @error('nama_kategori')
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

                        {{-- Tombol batal, kembali ke daftar kategori --}}
                        <a href="{{ route('kategori.index') }}"
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