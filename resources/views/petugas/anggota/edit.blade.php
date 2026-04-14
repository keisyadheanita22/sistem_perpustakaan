<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Anggota</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        {{-- Fungsi buka/tutup dropdown profil --}}
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
        }
        {{-- Tutup dropdown kalau klik di luar area --}}
        window.onclick = function(event) {
            if (!event.target.closest('#userMenu')) {
                const d = document.getElementById('userDropdown');
                if(d) d.style.display = 'none';
            }
        }
    </script>
</head>
<body style="margin: 0; font-family: ui-sans-serif, system-ui; background-color: #F5F0E8;">

    {{-- NAVBAR --}}
    <nav style="background-color: #2D3A1E; height: 56px; padding: 0 32px; display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid #D4A017; position: sticky; top: 0; z-index: 100;">
        {{-- Judul aplikasi --}}
        <span style="color: #F5F0E8; font-size: 17px; font-weight: bold; font-style: italic;">Sistem Perpustakaan</span>

        {{-- Menu dropdown profil pengguna --}}
        <div id="userMenu" style="position: relative; cursor: pointer;" onclick="toggleDropdown()">
            <div style="display: flex; align-items: center; gap: 8px; color: #F5F0E8; font-size: 14px;">
                {{-- Tampilkan foto profil kalau ada, kalau tidak tampilkan inisial --}}
                @if(Auth::user()->foto)
                    <img src="{{ asset('storage/' . Auth::user()->foto) }}" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; border: 1px solid #D4A017;">
                @else
                    <div style="width: 32px; height: 32px; border-radius: 50%; background-color: #D4A017; color: #2D3A1E; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
                <span>{{ Auth::user()->name }} ▾</span>
            </div>

            {{-- Isi dropdown: profil & logout --}}
            <div id="userDropdown" style="display: none; position: absolute; right: 0; top: 45px; width: 160px; background: white; border-radius: 8px; box-shadow: 0 10px 15px rgba(0,0,0,0.1); border: 1px solid #E8E2D4; overflow: hidden;">
                <a href="{{ route('petugas.profil') }}" style="display: block; padding: 12px 16px; color: #2D3A1E; text-decoration: none; font-size: 13px; font-weight: 600; border-bottom: 1px solid #F0EBE0;">Profil Saya</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" style="width: 100%; text-align: left; background: none; border: none; padding: 12px 16px; color: #9d174d; font-size: 13px; font-weight: 600; cursor: pointer;">Logout</button>
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

            {{-- Link data buku --}}
            <a href="{{ route('buku.index') }}" style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">Data Buku</a>

            {{-- Link data anggota - aktif --}}
            <a href="{{ route('anggota.index') }}" style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; background: #D4A017; color: #2D3A1E; font-size: 13px; text-decoration: none; font-weight: 600;">Data Anggota</a>

            {{-- Link peminjaman + badge notifikasi --}}
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
        <main style="flex: 1; padding: 32px;">
 
            {{-- Judul halaman --}}
            <div style="margin-bottom: 24px;">
                <h1 style="font-size: 24px; font-weight: 700; color: #2D3A1E; margin: 0;">Edit Anggota</h1>
            </div>

            {{-- Notifikasi error validasi --}}
            @if($errors->any())
                <div style="background-color: #FFF1F1; border: 1px solid #fca5a5; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 13px;">
                    <ul style="margin: 0; padding-left: 16px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form edit anggota --}}
            <div style="background: white; border-radius: 12px; border: 1px solid #D4A017; padding: 28px; max-width: 520px; margin: 0 auto; box-shadow: 0 4px 10px rgba(0,0,0,0.06);">
                <form action="{{ route('anggota.update', $anggota->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- ID Anggota readonly --}}
                    <div style="margin-bottom: 16px;">
                        <label style="display: block; font-size: 13px; font-weight: 600; color: #2D3A1E; margin-bottom: 6px;">ID Anggota</label>
                        <input type="text" value="{{ $anggota->id_anggota ?? '-' }}"
                            style="width: 100%; border: 1px solid #E8E2D4; border-radius: 8px; padding: 8px 12px; font-size: 13px; background: #F5F0E8; color: #8A7E6E; cursor: not-allowed; box-sizing: border-box;"
                            readonly>
                    </div>

                    {{-- Nama --}}
                    <div style="margin-bottom: 16px;">
                        <label style="display: block; font-size: 13px; font-weight: 600; color: #2D3A1E; margin-bottom: 6px;">Nama</label>
                        <input type="text" name="name" value="{{ old('name', $anggota->name) }}"
                            style="width: 100%; border: 1px solid #D4A017; border-radius: 8px; padding: 8px 12px; font-size: 13px; outline: none; box-sizing: border-box;"
                            required>
                    </div>

                    {{-- Email --}}
                    <div style="margin-bottom: 16px;">
                        <label style="display: block; font-size: 13px; font-weight: 600; color: #2D3A1E; margin-bottom: 6px;">Email</label>
                        <input type="email" name="email" value="{{ old('email', $anggota->email) }}"
                            style="width: 100%; border: 1px solid #D4A017; border-radius: 8px; padding: 8px 12px; font-size: 13px; outline: none; box-sizing: border-box;"
                            required>
                    </div>

                    {{-- No Telepon --}}
                    <div style="margin-bottom: 16px;">
                        <label style="display: block; font-size: 13px; font-weight: 600; color: #2D3A1E; margin-bottom: 6px;">No Telepon</label>
                        <input type="text" name="no_telepon" value="{{ old('no_telepon', $anggota->no_telepon) }}"
                            style="width: 100%; border: 1px solid #D4A017; border-radius: 8px; padding: 8px 12px; font-size: 13px; outline: none; box-sizing: border-box;">
                    </div>

                    {{-- Username --}}
                    <div style="margin-bottom: 16px;">
                        <label style="display: block; font-size: 13px; font-weight: 600; color: #2D3A1E; margin-bottom: 6px;">Username</label>
                        <input type="text" name="username" value="{{ old('username', $anggota->username) }}"
                            style="width: 100%; border: 1px solid #D4A017; border-radius: 8px; padding: 8px 12px; font-size: 13px; outline: none; box-sizing: border-box;">
                    </div>

                    {{-- Password baru --}}
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 13px; font-weight: 600; color: #2D3A1E; margin-bottom: 6px;">
                            Password Baru
                            <span style="color: #8A7E6E; font-weight: 400;">(kosongkan jika tidak diubah)</span>
                        </label>
                        <div style="display: flex; gap: 8px;">
                            {{-- Input password --}}
                            <input type="password" name="password" id="passwordInput"
                                placeholder="Masukkan password baru..."
                                style="flex: 1; border: 1px solid #D4A017; border-radius: 8px; padding: 8px 12px; font-size: 13px; outline: none;">
                            {{-- Tombol reset password --}}
                            <button type="button" onclick="resetPassword()"
                                style="padding: 8px 14px; background-color: #1E3A5F; color: white; border: none; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer;">
                                Reset Default
                            </button>
                        </div>

                        {{-- Hint setelah reset --}}
                        <p id="pwdHint" style="font-size: 11px; color: #8A7E6E; margin-top: 6px; display: none;">
                            Password direset ke: <strong>12345678</strong> — minta anggota ganti setelah login.
                        </p>
                    </div>

                    {{-- Tombol batal dan simpan --}}
                    <div style="display: flex; gap: 10px;">
                        <a href="{{ route('anggota.index') }}"
                            style="padding: 9px 20px; border-radius: 8px; border: 1px solid #E8E2D4; font-size: 13px; color: #8A7E6E; text-decoration: none; background: white;">
                            Batal
                        </a>
                        <button type="submit"
                            style="padding: 9px 20px; border-radius: 8px; background-color: #2D3A1E; color: #D4A017; border: 1px solid #D4A017; font-size: 13px; font-weight: 600; cursor: pointer;">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

        </main>
    </div>

    <script>
        // Fungsi reset password ke default
        function resetPassword() {
            const input = document.getElementById('passwordInput');
            const hint = document.getElementById('pwdHint');
            input.value = '12345678';
            input.type = 'text';
            hint.style.display = 'block';
            setTimeout(() => {
                input.type = 'password';
            }, 3000);
        }
    </script>

</body>
</html>