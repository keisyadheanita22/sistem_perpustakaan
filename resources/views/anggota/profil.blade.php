<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="box-sizing: border-box; margin: 0; padding: 0; font-family: ui-sans-serif, system-ui, sans-serif; background: #f3f4f6; min-height: 100vh; display: grid; grid-template-rows: 56px 1fr;">

{{-- NAVBAR --}}
<nav style="background: #db2777; display: flex; align-items: center; justify-content: space-between; padding: 0 24px; height: 56px; position: sticky; top: 0; z-index: 10;">
    <span style="font-size: 15px; font-weight: 700; font-style: italic; color: #fff;">Sistem Perpustakaan</span>
    <div style="display: flex; align-items: center; gap: 8px;">
        <div style="width: 32px; height: 32px; border-radius: 50%; background: #9d174d; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; color: #fff; flex-shrink: 0;">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
        <span style="font-size: 13px; color: #fff;">{{ Auth::user()->name }}</span>
    </div>
</nav>

<div style="display: flex; min-height: calc(100vh - 56px);">

    {{-- SIDEBAR --}}
    <aside style="width: 176px; background: #db2777; display: flex; flex-direction: column; flex-shrink: 0;">
        <nav style="padding: 12px 10px; flex: 1; display: flex; flex-direction: column; gap: 6px;">
            <a href="{{ route('anggota.dashboard') }}" style="display: block; padding: 8px 14px; border-radius: 6px; background: #9d174d; color: #fce7f3; font-size: 13px; text-align: center; text-decoration: none;">Dashboard</a>
            <a href="{{ route('katalog.index') }}" style="display: block; padding: 8px 14px; border-radius: 6px; background: #9d174d; color: #fce7f3; font-size: 13px; text-align: center; text-decoration: none;">Katalog Buku</a>
            <a href="{{ route('peminjaman.saya') }}" style="display: block; padding: 8px 14px; border-radius: 6px; background: #9d174d; color: #fce7f3; font-size: 13px; text-align: center; text-decoration: none;">Peminjaman Saya</a>
            <a href="{{ route('denda.saya') }}" style="display: block; padding: 8px 14px; border-radius: 6px; background: #9d174d; color: #fce7f3; font-size: 13px; text-align: center; text-decoration: none;">Denda Saya</a>
        </nav>
        <div style="padding: 10px; border-top: 1px solid rgba(0,0,0,0.1);">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 6px; padding: 8px 14px; border-radius: 6px; background: #9d174d; color: #fce7f3; font-size: 13px; border: none; cursor: pointer; font-family: inherit;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 14px; height: 14px; flex-shrink: 0;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <main style="flex: 1; padding: 28px; overflow: auto;">

        <!-- TOMBOL KEMBALI -->
        <button onclick="history.back()" style="margin-bottom: 10px; padding: 6px 10px; border-radius: 6px; border: none; background: transparent; color: #9d174d; font-size: 13px; cursor: pointer; font-weight: 500;">← Kembali</button>

        <h1 style="font-size: 20px; font-weight: 700; color: #1f2937; margin-bottom: 2px;">Profil Saya</h1>
        <p style="font-size: 13px; color: #6b7280; margin-bottom: 20px;">Kelola informasi akun kamu</p>

        {{-- Alert sukses --}}
        @if(session('success'))
            <div style="padding: 10px 14px; border-radius: 8px; font-size: 13px; margin-bottom: 16px; background: #dcfce7; border: 1px solid #86efac; color: #166534;">
                {{ session('success') }}
            </div>
        @endif

        {{-- Alert error --}}
        @if($errors->any())
            <div style="padding: 10px 14px; border-radius: 8px; font-size: 13px; margin-bottom: 16px; background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b;">
                <ul style="padding-left: 16px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">

            {{-- FORM EDIT PROFIL --}}
            <div style="background: #e9eaec; border: 1px solid #d1d5db; border-radius: 12px; padding: 22px;">
                <div style="font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 18px; display: flex; align-items: center; gap: 6px;">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width: 15px; height: 15px; color: #db2777;">
                        <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    Edit Profil
                </div>
                <form method="POST" action="{{ route('anggota.profil.update') }}">
                    @csrf
                    @method('PUT')

                    <div style="margin-bottom: 14px;">
                        <label style="display: block; font-size: 12px; color: #6b7280; margin-bottom: 5px;">Nama Lengkap</label>
                        <input type="text" name="name"
                            style="width: 100%; padding: 8px 12px; font-size: 13px; border: 1px solid #d1d5db; border-radius: 8px; outline: none; font-family: inherit; color: #111827; background: #fff;"
                            value="{{ Auth::user()->name }}">
                    </div>
                    <div style="margin-bottom: 14px;">
                        <label style="display: block; font-size: 12px; color: #6b7280; margin-bottom: 5px;">Email</label>
                        <input type="email" name="email"
                            style="width: 100%; padding: 8px 12px; font-size: 13px; border: 1px solid #d1d5db; border-radius: 8px; outline: none; font-family: inherit; color: #111827; background: #fff;"
                            value="{{ Auth::user()->email }}">
                    </div>
                    <div style="margin-bottom: 14px;">
                        <label style="display: block; font-size: 12px; color: #6b7280; margin-bottom: 5px;">No Telepon</label>
                        <input type="text" name="no_telepon"
                            style="width: 100%; padding: 8px 12px; font-size: 13px; border: 1px solid #d1d5db; border-radius: 8px; outline: none; font-family: inherit; color: #111827; background: #fff;"
                            value="{{ Auth::user()->no_telepon }}">
                    </div>
                    <div style="margin-bottom: 14px;">
                        <label style="display: block; font-size: 12px; color: #6b7280; margin-bottom: 5px;">Username</label>
                        <input type="text" name="username"
                            style="width: 100%; padding: 8px 12px; font-size: 13px; border: 1px solid #d1d5db; border-radius: 8px; outline: none; font-family: inherit; color: #111827; background: #fff;"
                            value="{{ Auth::user()->username }}">
                    </div>

                    <button type="submit"
                        style="width: 100%; padding: 9px; border: none; border-radius: 8px; font-size: 13px; font-weight: 500; cursor: pointer; font-family: inherit; margin-top: 4px; color: #fff; background: #db2777;">
                        Simpan Perubahan
                    </button>
                </form>
            </div>

            {{-- FORM GANTI PASSWORD --}}
            <div style="background: #e9eaec; border: 1px solid #d1d5db; border-radius: 12px; padding: 22px;">
                <div style="font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 18px; display: flex; align-items: center; gap: 6px;">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width: 15px; height: 15px; color: #db2777;">
                        <rect x="3" y="11" width="18" height="11" rx="2"/>
                        <path d="M7 11V7a5 5 0 0110 0v4"/>
                    </svg>
                    Ganti Password
                </div>
                <form method="POST" action="{{ route('anggota.profil.password') }}">
                    @csrf
                    @method('PUT')

                    <div style="margin-bottom: 14px;">
                        <label style="display: block; font-size: 12px; color: #6b7280; margin-bottom: 5px;">Password Lama</label>
                        <input type="password" name="password_lama"
                            style="width: 100%; padding: 8px 12px; font-size: 13px; border: 1px solid #d1d5db; border-radius: 8px; outline: none; font-family: inherit; color: #111827; background: #fff;"
                            placeholder="Masukkan password lama">
                    </div>
                    <div style="margin-bottom: 14px;">
                        <label style="display: block; font-size: 12px; color: #6b7280; margin-bottom: 5px;">Password Baru</label>
                        <input type="password" name="password"
                            style="width: 100%; padding: 8px 12px; font-size: 13px; border: 1px solid #d1d5db; border-radius: 8px; outline: none; font-family: inherit; color: #111827; background: #fff;"
                            placeholder="Masukkan password baru">
                    </div>
                    <div style="margin-bottom: 14px;">
                        <label style="display: block; font-size: 12px; color: #6b7280; margin-bottom: 5px;">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation"
                            style="width: 100%; padding: 8px 12px; font-size: 13px; border: 1px solid #d1d5db; border-radius: 8px; outline: none; font-family: inherit; color: #111827; background: #fff;"
                            placeholder="Ulangi password baru">
                    </div>

                    <button type="submit"
                        style="width: 100%; padding: 9px; border: none; border-radius: 8px; font-size: 13px; font-weight: 500; cursor: pointer; font-family: inherit; margin-top: 4px; color: #fff; background: #9d174d;">
                        Ganti Password
                    </button>
                </form>
            </div>

        </div>
    </main>
</div>

</body>
</html>