<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Petugas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body style="margin:0; font-family: ui-sans-serif, system-ui; background: #F5F0E8;">

{{-- ================= NAVBAR ================= --}}
<nav style="background:#2D3A1E; display:flex; justify-content:space-between; align-items:center; padding:0 32px; height:60px; border-bottom: 2px solid #D4A017; position: sticky; top: 0; z-index: 100;">
    <span style="color:#F5F0E8; font-weight:700; font-style: italic; font-size: 18px; letter-spacing: 0.5px;">Sistem Perpustakaan</span>
    <span style="color:#F5F0E8; font-size:14px; background: rgba(255,255,255,0.1); padding: 6px 14px; border-radius: 20px;">
        {{ Auth::user()->name }} <span style="opacity: 0.7; margin-left: 4px;">(Petugas)</span>
    </span>
</nav>

<div style="display:flex;">

    {{-- ================= SIDEBAR ================= --}}
    <aside style="width: 200px; background-color: #2D3A1E; padding: 24px 16px; display: flex; flex-direction: column; gap: 8px; min-height: calc(100vh - 60px); flex-shrink: 0;">
        
        <span style="font-size: 11px; color: #7A9E5A; text-transform: uppercase; letter-spacing: 0.1em; padding: 0 12px; margin-bottom: 8px; font-weight: 700;">Navigasi Petugas</span>

        <a href="{{ route('petugas.dashboard') }}" 
           style="display: block; padding: 10px 14px; border-radius: 10px; color: #C8DDB0; font-size: 14px; text-decoration: none; background: #3d4d2a;">
           Dashboard
        </a>

        <a href="{{ route('buku.index') }}" 
           style="display: block; padding: 10px 14px; border-radius: 10px; color: #C8DDB0; font-size: 14px; text-decoration: none;"
           onmouseover="this.style.background='#3d4d2a'" onmouseout="this.style.background='transparent'">
           Data Buku
        </a>

        <a href="{{ route('anggota.index') }}" 
           style="display: block; padding: 10px 14px; border-radius: 10px; color: #C8DDB0; font-size: 14px; text-decoration: none;"
           onmouseover="this.style.background='#3d4d2a'" onmouseout="this.style.background='transparent'">
           Data Anggota
        </a>

        <a href="{{ route('peminjaman.index') }}" 
           style="display: block; padding: 10px 14px; border-radius: 10px; color: #C8DDB0; font-size: 14px; text-decoration: none;"
           onmouseover="this.style.background='#3d4d2a'" onmouseout="this.style.background='transparent'">
           Peminjaman
        </a>

        <a href="{{ route('kategori.index') }}" 
           style="display: block; padding: 10px 14px; border-radius: 10px; color: #C8DDB0; font-size: 14px; text-decoration: none;"
           onmouseover="this.style.background='#3d4d2a'" onmouseout="this.style.background='transparent'">
           Kategori
        </a>

        <a href="{{ route('denda.index') }}" 
           style="display: block; padding: 10px 14px; border-radius: 10px; color: #C8DDB0; font-size: 14px; text-decoration: none;"
           onmouseover="this.style.background='#3d4d2a'" onmouseout="this.style.background='transparent'">
           Denda
        </a>
    </aside>

    {{-- ================= MAIN CONTENT ================= --}}
    <main style="flex:1; padding:40px;">

        <button onclick="history.back()" 
            style="margin-bottom:24px; background:none; border:none; color:#2D3A1E; cursor:pointer; font-weight: 700; display: flex; align-items: center; gap: 8px; font-size: 15px;">
            ← Kembali
        </button>

        <div style="display:grid; grid-template-columns: 320px 1fr; gap:32px; align-items: start;">

            {{-- CARD FOTO --}}
            <div style="background:#FFFFFF; border-radius:20px; padding:32px; text-align:center; box-shadow:0 10px 25px rgba(0,0,0,0.04); border: 1px solid #E8E2D4;">

                @if(Auth::user()->foto)
                    <img src="{{ asset('storage/' . Auth::user()->foto) }}"
                        style="width:150px; height:150px; border-radius:50%; object-fit:cover; border:4px solid #D4A017; margin-bottom:18px; box-shadow: 0 8px 20px rgba(0,0,0,0.1);">
                @else
                    <div style="width:150px; height:150px; border-radius:50%; background:#D4A017; color:#2D3A1E; display:flex; align-items:center; justify-content:center; font-size:56px; font-weight:bold; margin:0 auto 18px; border: 4px solid #2D3A1E;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif

                <h3 style="margin: 0; color: #2D3A1E; font-size: 20px;">{{ Auth::user()->name }}</h3>
                <p style="font-size:14px; color:#8A7E6E; margin-top: 6px; margin-bottom: 24px; font-weight: 500;">Petugas Perpustakaan</p>

                <form method="POST" action="{{ route('petugas.profil.update') }}" enctype="multipart/form-data" style="border-top: 1px solid #F0EBE0; padding-top: 24px;">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="name" value="{{ Auth::user()->name }}">
                    <input type="hidden" name="email" value="{{ Auth::user()->email }}">

                    <label style="display:block; font-size:12px; color:#8A7E6E; text-align:left; margin-bottom:8px; font-weight: 600;">Ganti Foto Profil:</label>
                    <input type="file" name="foto" style="font-size: 12px; width: 100%; margin-bottom: 20px;">

                    <button type="submit"
                        style="width:100%; padding:12px; background:#2D3A1E; color:#D4A017; border:none; border-radius:10px; cursor:pointer; font-weight:700; font-size: 14px;">
                        Simpan Foto Baru
                    </button>
                </form>
            </div>

            {{-- FORM EDIT DATA --}}
            <div style="display:flex; flex-direction:column; gap:28px;">

                {{-- Box Edit Identitas --}}
                <div style="background:#FFFFFF; padding:32px; border-radius:20px; box-shadow:0 10px 25px rgba(0,0,0,0.04); border: 1px solid #E8E2D4;">
                    <h3 style="margin-top:0; color:#2D3A1E; border-bottom: 2px solid #D4A017; padding-bottom: 12px; display: inline-block; font-size: 18px;">Pengaturan Profil</h3>

                    <form method="POST" action="{{ route('petugas.profil.update') }}" style="margin-top: 20px;">
                        @csrf
                        @method('PUT')

                        <div style="margin-bottom:20px;">
                            <label style="font-size:13px; color:#6b7280; display:block; margin-bottom:8px; font-weight: 600;">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ Auth::user()->name }}"
                                style="width:100%; padding:14px; border:1px solid #E8E2D4; border-radius:10px; box-sizing: border-box; background: #FDFCF9; font-size: 14px;">
                        </div>

                        <div style="margin-bottom:24px;">
                            <label style="font-size:13px; color:#6b7280; display:block; margin-bottom:8px; font-weight: 600;">Alamat Email</label>
                            <input type="email" name="email" value="{{ Auth::user()->email }}"
                                style="width:100%; padding:14px; border:1px solid #E8E2D4; border-radius:10px; box-sizing: border-box; background: #FDFCF9; font-size: 14px;">
                        </div>

                        <button type="submit"
                            style="width:100%; padding:14px; background:#D4A017; color:#2D3A1E; border:none; border-radius:10px; font-weight:700; cursor:pointer; font-size: 14px;">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>

                {{-- Box Keamanan --}}
                <div style="background:#FFFFFF; padding:32px; border-radius:20px; box-shadow:0 10px 25px rgba(0,0,0,0.04); border: 1px solid #E8E2D4;">
                    <h3 style="margin-top:0; color:#2D3A1E; border-bottom: 2px solid #8B3A3A; padding-bottom: 12px; display: inline-block; font-size: 18px;">Keamanan Akun</h3>

                    <form method="POST" action="{{ route('petugas.profil.password') }}">
                        @csrf
                        @method('PUT')

                        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px; margin-top:20px;">
                            <input type="password" name="password_lama" placeholder="Password lama" required
                                style="width:100%; padding:14px; border:1px solid #E8E2D4; border-radius:10px; box-sizing: border-box; font-size: 14px;">
                            <input type="password" name="password" placeholder="Password baru" required
                                style="width:100%; padding:14px; border:1px solid #E8E2D4; border-radius:10px; box-sizing: border-box; font-size: 14px;">
                        </div>

                        <input type="password" name="password_confirmation" placeholder="Ulangi password baru" required
                            style="width:100%; padding:14px; margin-top:20px; border:1px solid #E8E2D4; border-radius:10px; box-sizing: border-box; font-size: 14px;">

                        <button type="submit"
                            style="width:100%; padding:14px; margin-top:24px; background:#2D3A1E; color:#F5F0E8; border:none; border-radius:10px; font-weight:700; cursor:pointer; font-size: 14px;">
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