<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya</title>
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
<body style="margin: 0; font-family: ui-sans-serif, system-ui; background-color: #F5F0E8; min-height: 100vh;">

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
                <a href="{{ route('anggota.profil') }}"
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

    <div style="display: flex; min-height: calc(100vh - 56px);">

        {{-- ============================== --}}
        {{-- SIDEBAR - Menu navigasi kiri   --}}
        {{-- ============================== --}}
        <aside style="width: 176px; background-color: #2D3A1E; padding: 20px 12px; display: flex; flex-direction: column; gap: 6px; flex-shrink: 0;">

            <span style="font-size: 10px; color: #7A9E5A; text-transform: uppercase; letter-spacing: 0.08em; padding: 0 8px; margin: 0 0 4px 0;">Menu Anggota</span>

            {{-- Link: Dashboard --}}
            <a href="{{ route('anggota.dashboard') }}"
               style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">
                Dashboard
            </a>

            {{-- Link: Katalog Buku --}}
            <a href="{{ route('katalog.index') }}"
               style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">
                Katalog Buku
            </a>

            {{-- Link: Peminjaman Saya --}}
            <a href="{{ route('peminjaman.saya') }}"
               style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">
                Peminjaman Saya
            </a>

            {{-- Link: Denda Saya --}}
            <a href="{{ route('denda.saya') }}"
               style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">
                Denda Saya
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
        <main style="flex: 1; padding: 32px; overflow: auto;">

            {{-- Tombol kembali --}}
            <a href="{{ route('anggota.dashboard') }}"
               style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; color: #8A7E6E; text-decoration: none; margin-bottom: 16px;">
                ← Kembali ke Dashboard
            </a>

            {{-- Judul halaman --}}
            <h1 style="font-size: 24px; font-weight: 700; color: #2D3A1E; margin: 0 0 4px 0;">Profil Saya</h1>
            <p style="font-size: 13px; color: #8A7E6E; margin: 0 0 24px 0;">Kelola informasi akun kamu</p>

            {{-- Notifikasi sukses --}}
            @if(session('success'))
                <div id="flash-success"
                     style="background-color: #dcfce7; border: 1px solid #22c55e; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; display: flex; align-items: center; justify-content: space-between;">
                    <span>✅ {{ session('success') }}</span>
                    <button onclick="document.getElementById('flash-success').style.display='none'"
                            style="background: none; border: none; color: #166534; cursor: pointer; font-size: 18px;">&times;</button>
                </div>
            @endif

            {{-- Notifikasi error validasi --}}
            @if ($errors->any())
                <div style="background-color: #FEE2E2; border: 1px solid #fca5a5; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 13px;">
                    <ul style="margin: 0; padding-left: 18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Grid dua kolom: foto kiri, form kanan --}}
            <div style="display: grid; grid-template-columns: 280px 1fr; gap: 20px; align-items: start;">

                {{-- ======================== --}}
                {{-- KOLOM KIRI: FOTO PROFIL  --}}
                {{-- ======================== --}}
                <div style="background: #F9F9F9; border: 1px solid #D4A017; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.08);">

                    {{-- Header card foto --}}
                    <div style="padding: 14px 20px; background: #FFFDF8; border-bottom: 1px solid #E8E2D4;">
                        <p style="font-size: 13px; font-weight: 700; color: #2D3A1E; margin: 0;">Foto Profil</p>
                    </div>

                    <div style="padding: 24px 20px; text-align: center;">

                        {{-- Tampilan foto atau inisial --}}
                        <div style="display: flex; justify-content: center; margin-bottom: 16px;">
                            @if(Auth::user()->foto)
                                <img src="{{ asset('storage/' . Auth::user()->foto) }}"
                                     style="width: 110px; height: 110px; border-radius: 50%; object-fit: cover; border: 4px solid #D4A017;">
                            @else
                                <div style="width: 110px; height: 110px; border-radius: 50%; background-color: #D4A017; color: #2D3A1E; display: flex; align-items: center; justify-content: center; font-size: 40px; font-weight: bold; border: 4px solid #D4A017;">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>

                        {{-- Nama dan email --}}
                        <h2 style="font-size: 15px; font-weight: 700; color: #2D3A1E; margin: 0 0 4px 0;">{{ Auth::user()->name }}</h2>
                        <p style="font-size: 12px; color: #8A7E6E; margin: 0 0 20px 0;">{{ Auth::user()->email }}</p>

                        {{-- Form upload foto profil --}}
                        <form action="{{ route('anggota.profil.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- Input file --}}
                            <input type="file" name="foto" required
                                   style="font-size: 11px; width: 100%; margin-bottom: 12px; color: #8A7E6E;">

                            {{-- Tombol update foto, kuning emas --}}
                            <button type="submit"
                                    style="width: 100%; padding: 9px; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; color: #2D3A1E; background: #D4A017;">
                                Update Foto
                            </button>
                        </form>
                    </div>
                </div>

                {{-- ============================ --}}
                {{-- KOLOM KANAN: FORM & PASSWORD --}}
                {{-- ============================ --}}
                <div style="display: flex; flex-direction: column; gap: 20px;">

                    {{-- Card edit data profil --}}
                    <div style="background: #F9F9F9; border: 1px solid #D4A017; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.08);">

                        {{-- Header card edit profil --}}
                        <div style="display: flex; align-items: center; gap: 10px; padding: 14px 20px; background: #FFFDF8; border-bottom: 1px solid #E8E2D4;">
                            <div style="width: 32px; height: 32px; border-radius: 8px; background-color: #DBEAFE; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <svg fill="none" stroke="#1E3A5F" stroke-width="2" viewBox="0 0 24 24" style="width: 15px; height: 15px;">
                                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </div>
                            <p style="font-size: 14px; font-weight: 700; color: #2D3A1E; margin: 0;">Edit Profil</p>
                        </div>

                        {{-- Form edit data diri --}}
                        <form method="POST" action="{{ route('anggota.profil.update') }}" style="padding: 20px;">
                            @csrf
                            @method('PUT')

                            {{-- Grid 2 kolom untuk field data --}}
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">

                                {{-- Nama Lengkap --}}
                                <div>
                                    <label style="display: block; font-size: 12px; font-weight: 600; color: #8A7E6E; margin-bottom: 6px;">Nama Lengkap</label>
                                    <input type="text" name="name" value="{{ Auth::user()->name }}"
                                           style="width: 100%; padding: 9px 12px; font-size: 13px; border: 1px solid #D4A017; border-radius: 8px; color: #2D3A1E; background: white; outline: none; box-sizing: border-box;"
                                           onfocus="this.style.borderColor='#1E3A5F'; this.style.boxShadow='0 0 0 3px rgba(30,58,95,0.1)'"
                                           onblur="this.style.borderColor='#D4A017'; this.style.boxShadow='none'">
                                </div>

                                {{-- Email --}}
                                <div>
                                    <label style="display: block; font-size: 12px; font-weight: 600; color: #8A7E6E; margin-bottom: 6px;">Email</label>
                                    <input type="email" name="email" value="{{ Auth::user()->email }}"
                                           style="width: 100%; padding: 9px 12px; font-size: 13px; border: 1px solid #D4A017; border-radius: 8px; color: #2D3A1E; background: white; outline: none; box-sizing: border-box;"
                                           onfocus="this.style.borderColor='#1E3A5F'; this.style.boxShadow='0 0 0 3px rgba(30,58,95,0.1)'"
                                           onblur="this.style.borderColor='#D4A017'; this.style.boxShadow='none'">
                                </div>

                                {{-- No Telepon --}}
                                <div>
                                    <label style="display: block; font-size: 12px; font-weight: 600; color: #8A7E6E; margin-bottom: 6px;">No Telepon</label>
                                    <input type="text" name="no_telepon" value="{{ Auth::user()->no_telepon }}"
                                           style="width: 100%; padding: 9px 12px; font-size: 13px; border: 1px solid #D4A017; border-radius: 8px; color: #2D3A1E; background: white; outline: none; box-sizing: border-box;"
                                           onfocus="this.style.borderColor='#1E3A5F'; this.style.boxShadow='0 0 0 3px rgba(30,58,95,0.1)'"
                                           onblur="this.style.borderColor='#D4A017'; this.style.boxShadow='none'">
                                </div>

                                {{-- Username --}}
                                <div>
                                    <label style="display: block; font-size: 12px; font-weight: 600; color: #8A7E6E; margin-bottom: 6px;">Username</label>
                                    <input type="text" name="username" value="{{ Auth::user()->username }}"
                                           style="width: 100%; padding: 9px 12px; font-size: 13px; border: 1px solid #D4A017; border-radius: 8px; color: #2D3A1E; background: white; outline: none; box-sizing: border-box;"
                                           onfocus="this.style.borderColor='#1E3A5F'; this.style.boxShadow='0 0 0 3px rgba(30,58,95,0.1)'"
                                           onblur="this.style.borderColor='#D4A017'; this.style.boxShadow='none'">
                                </div>
                            </div>

                            {{-- Divider --}}
                            <div style="border-top: 1px solid #E8E2D4; margin: 18px 0;"></div>

                            {{-- Tombol simpan perubahan --}}
                            <button type="submit"
                                    style="display: flex; align-items: center; gap: 6px; padding: 10px 20px; background-color: #2D3A1E; color: #F5F0E8; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer;">
                                <svg xmlns="http://www.w3.org/2000/svg" style="width: 14px; height: 14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Simpan Perubahan
                            </button>
                        </form>
                    </div>

                    {{-- Card ganti password --}}
                    <div style="background: #F9F9F9; border: 1px solid #D4A017; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.08);">

                        {{-- Header card ganti password --}}
                        <div style="display: flex; align-items: center; gap: 10px; padding: 14px 20px; background: #FFFDF8; border-bottom: 1px solid #E8E2D4;">
                            <div style="width: 32px; height: 32px; border-radius: 8px; background-color: #FEE2E2; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <svg fill="none" stroke="#991b1b" stroke-width="2" viewBox="0 0 24 24" style="width: 15px; height: 15px;">
                                    <rect x="3" y="11" width="18" height="11" rx="2"/>
                                    <path d="M7 11V7a5 5 0 0110 0v4"/>
                                </svg>
                            </div>
                            <p style="font-size: 14px; font-weight: 700; color: #2D3A1E; margin: 0;">Ganti Password</p>
                        </div>

                        {{-- Form ganti password --}}
                        <form method="POST" action="{{ route('anggota.profil.password') }}" style="padding: 20px;">
                            @csrf
                            @method('PUT')

                            {{-- Password lama --}}
                            <div style="margin-bottom: 12px;">
                                <label style="display: block; font-size: 12px; font-weight: 600; color: #8A7E6E; margin-bottom: 6px;">Password Lama</label>
                                <input type="password" name="password_lama" placeholder="Masukkan password lama"
                                       style="width: 100%; padding: 9px 12px; font-size: 13px; border: 1px solid #D4A017; border-radius: 8px; color: #2D3A1E; background: white; outline: none; box-sizing: border-box;"
                                       onfocus="this.style.borderColor='#1E3A5F'; this.style.boxShadow='0 0 0 3px rgba(30,58,95,0.1)'"
                                       onblur="this.style.borderColor='#D4A017'; this.style.boxShadow='none'">
                            </div>

                            {{-- Password baru --}}
                            <div style="margin-bottom: 12px;">
                                <label style="display: block; font-size: 12px; font-weight: 600; color: #8A7E6E; margin-bottom: 6px;">Password Baru</label>
                                <input type="password" name="password" placeholder="Masukkan password baru"
                                       style="width: 100%; padding: 9px 12px; font-size: 13px; border: 1px solid #D4A017; border-radius: 8px; color: #2D3A1E; background: white; outline: none; box-sizing: border-box;"
                                       onfocus="this.style.borderColor='#1E3A5F'; this.style.boxShadow='0 0 0 3px rgba(30,58,95,0.1)'"
                                       onblur="this.style.borderColor='#D4A017'; this.style.boxShadow='none'">
                            </div>

                            {{-- Konfirmasi password baru --}}
                            <div style="margin-bottom: 4px;">
                                <label style="display: block; font-size: 12px; font-weight: 600; color: #8A7E6E; margin-bottom: 6px;">Ulangi Password Baru</label>
                                <input type="password" name="password_confirmation" placeholder="Ulangi password baru"
                                       style="width: 100%; padding: 9px 12px; font-size: 13px; border: 1px solid #D4A017; border-radius: 8px; color: #2D3A1E; background: white; outline: none; box-sizing: border-box;"
                                       onfocus="this.style.borderColor='#1E3A5F'; this.style.boxShadow='0 0 0 3px rgba(30,58,95,0.1)'"
                                       onblur="this.style.borderColor='#D4A017'; this.style.boxShadow='none'">
                            </div>

                            {{-- Divider --}}
                            <div style="border-top: 1px solid #E8E2D4; margin: 18px 0;"></div>

                            {{-- Tombol ganti password, merah gelap sebagai aksen peringatan --}}
                            <button type="submit"
                                    style="display: flex; align-items: center; gap: 6px; padding: 10px 20px; background-color: #991b1b; color: #FEF2F2; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer;">
                                <svg xmlns="http://www.w3.org/2000/svg" style="width: 14px; height: 14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                Ganti Password
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </main>
    </div>

</body>
</html>