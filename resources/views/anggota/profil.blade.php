<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: ui-sans-serif, system-ui, sans-serif;
            background: #f3f4f6;
            min-height: 100vh;
            display: grid;
            grid-template-rows: 56px 1fr;
        }

        /* ── NAVBAR ── */
        .navbar {
            background: #db2777;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            height: 56px;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .navbar-brand {
            font-size: 15px;
            font-weight: 700;
            font-style: italic;
            color: #fff;
        }
        .navbar-user {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #9d174d;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }
        .navbar-user span { font-size: 13px; color: #fff; }

        /* ── LAYOUT ── */
        .layout {
            display: flex;
            min-height: calc(100vh - 56px);
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: 176px;
            background: #db2777;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }
        .sidebar-nav {
            padding: 12px 10px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .nav-link {
            display: block;
            padding: 8px 14px;
            border-radius: 6px;
            background: #9d174d;
            color: #fce7f3;
            font-size: 13px;
            text-align: center;
            text-decoration: none;
            transition: opacity 0.12s;
        }
        .nav-link:hover { opacity: 0.85; }
        .nav-link.active { background: #831843; color: #fff; }
        .sidebar-footer {
            padding: 10px;
            border-top: 1px solid rgba(0,0,0,0.1);
        }
        .btn-logout {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: 6px;
            background: #9d174d;
            color: #fce7f3;
            font-size: 13px;
            border: none;
            cursor: pointer;
            font-family: inherit;
            transition: opacity 0.12s;
        }
        .btn-logout:hover { opacity: 0.85; }
        .btn-logout svg { width: 14px; height: 14px; flex-shrink: 0; }

        /* ── MAIN ── */
        .main { flex: 1; padding: 28px; overflow: auto; }
        .page-title { font-size: 20px; font-weight: 700; color: #1f2937; margin-bottom: 2px; }
        .page-sub { font-size: 13px; color: #6b7280; margin-bottom: 20px; }

        /* ── ALERTS ── */
        .alert { padding: 10px 14px; border-radius: 8px; font-size: 13px; margin-bottom: 16px; }
        .alert-success { background: #dcfce7; border: 1px solid #86efac; color: #166534; }
        .alert-error { background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; }
        .alert-error ul { padding-left: 16px; }

        /* ── GRID ── */
        .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        @media (max-width: 720px) { .two-col { grid-template-columns: 1fr; } }

        /* ── CARD ── */
        .card {
            background: #e9eaec;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            padding: 22px;
        }
        .card-title {
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .card-title svg { width: 15px; height: 15px; color: #db2777; }

        /* ── FORM ── */
        .form-group { margin-bottom: 14px; }
        .form-label { display: block; font-size: 12px; color: #6b7280; margin-bottom: 5px; }
        .form-input {
            width: 100%;
            padding: 8px 12px;
            font-size: 13px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            outline: none;
            font-family: inherit;
            color: #111827;
            background: #fff;
            transition: border-color 0.12s, box-shadow 0.12s;
        }
        .form-input:focus {
            border-color: #db2777;
            box-shadow: 0 0 0 3px rgba(219,39,119,0.12);
        }
        .form-input::placeholder { color: #9ca3af; }

        /* ── BUTTONS ── */
        .btn {
            width: 100%;
            padding: 9px;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            font-family: inherit;
            transition: opacity 0.12s;
            margin-top: 4px;
            color: #fff;
        }
        .btn:hover { opacity: 0.88; }
        .btn-pink { background: #db2777; }
        .btn-dark  { background: #9d174d; }
    </style>
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="navbar">
        <span class="navbar-brand">Sistem Perpustakaan</span>
        <div class="navbar-user">
            <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            <span>{{ Auth::user()->name }}</span>
        </div>
    </nav>

      <div class="layout">

        {{-- SIDEBAR --}}
        <aside class="sidebar">
            <nav class="sidebar-nav">
                <a href="{{ route('anggota.dashboard') }}" class="nav-link">Dashboard</a>
                <a href="{{ route('katalog.index') }}" class="nav-link">Katalog Buku</a>
                <a href="{{ route('peminjaman.saya') }}" class="nav-link">Peminjaman Saya</a>
                <a href="{{ route('denda.saya') }}" class="nav-link">Denda Saya</a>
                <a href="#" class="nav-link active">Profil Saya</a>
            </nav>
            <div class="sidebar-footer">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <main class="main">

            <h1 class="page-title">Profil Saya</h1>
            <p class="page-sub">Kelola informasi akun kamu</p>

            {{-- Alert sukses --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Alert error --}}
            @if($errors->any())
                <div class="alert alert-error">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="two-col">

                {{-- FORM EDIT PROFIL --}}
                <div class="card">
                    <div class="card-title">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                        Edit Profil
                    </div>
                    <form method="POST" action="{{ route('anggota.profil.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-input"
                                value="{{ Auth::user()->name }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-input"
                                value="{{ Auth::user()->email }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">No Telepon</label>
                            <input type="text" name="no_telepon" class="form-input"
                                value="{{ Auth::user()->no_telepon }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-input"
                                value="{{ Auth::user()->username }}">
                        </div>

                        <button type="submit" class="btn btn-pink">Simpan Perubahan</button>
                    </form>
                </div>

                {{-- FORM GANTI PASSWORD --}}
                <div class="card">
                    <div class="card-title">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="11" width="18" height="11" rx="2"/>
                            <path d="M7 11V7a5 5 0 0110 0v4"/>
                        </svg>
                        Ganti Password
                    </div>
                    <form method="POST" action="{{ route('anggota.profil.password') }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label class="form-label">Password Lama</label>
                            <input type="password" name="password_lama" class="form-input"
                                placeholder="Masukkan password lama">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="password" class="form-input"
                                placeholder="Masukkan password baru">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-input"
                                placeholder="Ulangi password baru">
                        </div>

                        <button type="submit" class="btn btn-dark">Ganti Password</button>
                    </form>
                </div>

            </div>
        </main>
    </div>

</body>
</html>