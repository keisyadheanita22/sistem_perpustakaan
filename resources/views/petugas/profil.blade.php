<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Petugas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body style="margin:0; font-family: ui-sans-serif, system-ui; background: linear-gradient(to bottom right, #fdf2f8, #f3f4f6);">

{{-- ================= NAVBAR ================= --}}
<nav style="background:#db2777; display:flex; justify-content:space-between; align-items:center; padding:0 24px; height:56px;">
    <span style="color:#fff; font-weight:700;">Sistem Perpustakaan</span>
    <span style="color:#fff; font-size:13px;">{{ Auth::user()->name }}</span>
</nav>

<div style="display:flex;">

    {{-- ================= SIDEBAR ================= --}}
    <aside class="w-44 flex flex-col py-4 gap-2"
    style="background:#db2777; min-height:calc(100vh - 56px);">

    <a href="{{ route('petugas.dashboard') }}"
        class="mx-3 px-4 py-2 rounded text-white text-sm text-center"
        style="background-color:#9d174d;">
        Dashboard
    </a>

    <a href="{{ route('buku.index') }}"
        class="mx-3 px-4 py-2 rounded text-white text-sm text-center"
        style="background-color:#9d174d;">
        Data Buku
    </a>

    {{-- ❌ DIHAPUS AKTIFNYA BIAR GA KE PENCET --}}
    <a href="{{ route('anggota.index') }}"
        class="mx-3 px-4 py-2 rounded text-white text-sm text-center"
        style="background-color:#9d174d;">
        Data Anggota
    </a>

    <a href="{{ route('peminjaman.index') }}"
        class="mx-3 px-4 py-2 rounded text-white text-sm text-center"
        style="background-color:#9d174d;">
        Peminjaman
    </a>

    <a href="{{ route('kategori.index') }}"
        class="mx-3 px-4 py-2 rounded text-white text-sm text-center"
        style="background-color:#9d174d;">
        Kategori
    </a>

    <a href="{{ route('denda.index') }}"
        class="mx-3 px-4 py-2 rounded text-white text-sm text-center"
        style="background-color:#9d174d;">
        Denda
    </a>

</aside>

    {{-- ================= MAIN ================= --}}
    <main style="flex:1; padding:30px;">

        <button onclick="history.back()" 
            style="margin-bottom:15px; background:none; border:none; color:#db2777; cursor:pointer;">
            ← Kembali
        </button>

        <div style="display:grid; grid-template-columns: 300px 1fr; gap:25px;">

            {{-- ================= CARD FOTO ================= --}}
            <div style="background:#fff; border-radius:16px; padding:25px; text-align:center; box-shadow:0 6px 18px rgba(0,0,0,0.06);">

                @if(Auth::user()->foto)
                    <img src="{{ asset('storage/' . Auth::user()->foto) }}"
                        style="width:120px; height:120px; border-radius:50%; object-fit:cover; border:4px solid #db2777; margin-bottom:15px;">
                @else
                    <div style="
                        width:120px;
                        height:120px;
                        border-radius:50%;
                        background:#db2777;
                        color:white;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        font-size:40px;
                        font-weight:bold;
                        margin:0 auto 15px;
                    ">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif

                <h3>{{ Auth::user()->name }}</h3>
                <p style="font-size:13px; color:gray;">{{ Auth::user()->email }}</p>

                <form method="POST" action="{{ route('petugas.profil.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="name" value="{{ Auth::user()->name }}">
                    <input type="hidden" name="email" value="{{ Auth::user()->email }}">

                    <input type="file" name="foto" style="margin-top:10px;">

                    <button type="submit"
                        style="margin-top:10px; width:100%; padding:8px; background:#db2777; color:#fff; border:none; border-radius:8px;">
                        Update Foto
                    </button>
                </form>

            </div>

            {{-- ================= BAGIAN KANAN ================= --}}
            <div style="display:flex; flex-direction:column; gap:20px;">

                {{-- EDIT PROFIL --}}
                <div style="background:#fff; padding:20px; border-radius:16px; box-shadow:0 6px 18px rgba(0,0,0,0.06);">
                    <h3>Edit Profil</h3>

                    <form method="POST" action="{{ route('petugas.profil.update') }}">
                        @csrf
                        @method('PUT')

                        <input type="text" name="name" value="{{ Auth::user()->name }}"
                            style="width:100%; padding:10px; margin-bottom:10px; border:1px solid #ddd; border-radius:8px;">

                        <input type="email" name="email" value="{{ Auth::user()->email }}"
                            style="width:100%; padding:10px; margin-bottom:10px; border:1px solid #ddd; border-radius:8px;">

                        <button type="submit"
                            style="width:100%; padding:10px; background:#db2777; color:#fff; border:none; border-radius:8px;">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>

                {{-- GANTI PASSWORD --}}
                <div style="background:#fff; padding:20px; border-radius:16px; box-shadow:0 6px 18px rgba(0,0,0,0.06);">
                    <h3>Ganti Password</h3>

                    <form method="POST" action="{{ route('petugas.profil.password') }}">
                        @csrf
                        @method('PUT')

                        <input type="password" name="password_lama" placeholder="Password lama"
                            style="width:100%; padding:10px; margin-bottom:10px; border:1px solid #ddd; border-radius:8px;">

                        <input type="password" name="password" placeholder="Password baru"
                            style="width:100%; padding:10px; margin-bottom:10px; border:1px solid #ddd; border-radius:8px;">

                        <input type="password" name="password_confirmation" placeholder="Konfirmasi password"
                            style="width:100%; padding:10px; margin-bottom:10px; border:1px solid #ddd; border-radius:8px;">

                        <button type="submit"
                            style="width:100%; padding:10px; background:#9d174d; color:#fff; border:none; border-radius:8px;">
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