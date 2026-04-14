<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku - Petugas</title>
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
        {{-- SIDEBAR --}}
        <aside style="width: 176px; background-color: #2D3A1E; padding: 20px 12px; display: flex; flex-direction: column; gap: 6px; flex-shrink: 0;">
            <span style="font-size: 10px; color: #7A9E5A; text-transform: uppercase; letter-spacing: 0.08em; padding: 0 8px; margin: 0 0 4px 0;">Menu Petugas</span>
            <a href="{{ route('petugas.dashboard') }}" style="display: flex; align-items: center; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">Dashboard</a>
            <a href="{{ route('buku.index') }}" style="display: flex; align-items: center; padding: 9px 12px; border-radius: 8px; background: #D4A017; color: #2D3A1E; font-size: 13px; text-decoration: none; font-weight: 600;">Data Buku</a>
            <a href="{{ route('anggota.index') }}" style="display: flex; align-items: center; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">Data Anggota</a>
            <a href="{{ route('peminjaman.index') }}" style="display: flex; align-items: center; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">Peminjaman</a>
            <a href="{{ route('kategori.index') }}" style="display: flex; align-items: center; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">Kategori</a>
            <a href="{{ route('denda.index') }}" style="display: flex; align-items: center; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">Denda</a>
        </aside>

        {{-- MAIN CONTENT --}}
        <main style="flex: 1; padding: 32px; display: flex; justify-content: center; align-items: flex-start;">
            <div style="width: 100%; max-width: 400px; background: white; border-radius: 12px; border: 1px solid #E8E2D4; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                <div style="background-color: #2D3A1E; color: #D4A017; padding: 14px 24px; font-weight: bold; font-size: 15px; border-bottom: 2px solid #D4A017;">
                    + Tambah Buku Baru
                </div>
                
                <div style="padding: 24px;">
                    <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 16px;">
                        @csrf
                        
                        {{-- Preview Foto --}}
                        <div style="text-align: center;">
                            <div style="margin: 0 auto 12px; width: 100px; height: 130px; background: #F5F0E8; border-radius: 8px; border: 2px dashed #D4A017; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                <img id="preview-img" src="" class="hidden" style="width: 100%; height: 100%; object-fit: cover;">
                                <span id="preview-icon" style="font-size: 30px;">📚</span>
                            </div>
                            <input type="file" name="foto" onchange="previewFoto(this)" style="font-size: 11px; color: #2D3A1E; width: 100%;">
                            @error('foto') <p style="color: #dc2626; font-size: 11px; margin-top: 4px; text-align: left;">{{ $message }}</p> @enderror
                        </div>

                        {{-- Judul --}}
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #2D3A1E; margin-bottom: 4px;">Judul Buku</label>
                            <input type="text" name="judul" value="{{ old('judul') }}" placeholder="Masukkan judul buku" style="width: 100%; padding: 10px 12px; border: 1px solid #E8E2D4; border-radius: 8px; font-size: 13px; box-sizing: border-box;">
                            @error('judul') <p style="color: #dc2626; font-size: 11px; margin-top: 2px;">{{ $message }}</p> @enderror
                        </div>

                        {{-- Pengarang --}}
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #2D3A1E; margin-bottom: 4px;">Pengarang</label>
                            <input type="text" name="pengarang" value="{{ old('pengarang') }}" placeholder="Nama pengarang" style="width: 100%; padding: 10px 12px; border: 1px solid #E8E2D4; border-radius: 8px; font-size: 13px; box-sizing: border-box;">
                            @error('pengarang') <p style="color: #dc2626; font-size: 11px; margin-top: 2px;">{{ $message }}</p> @enderror
                        </div>

                        {{-- Penerbit --}}
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #2D3A1E; margin-bottom: 4px;">Penerbit</label>
                            <input type="text" name="penerbit" value="{{ old('penerbit') }}" placeholder="Nama penerbit" style="width: 100%; padding: 10px 12px; border: 1px solid #E8E2D4; border-radius: 8px; font-size: 13px; box-sizing: border-box;">
                            @error('penerbit') <p style="color: #dc2626; font-size: 11px; margin-top: 2px;">{{ $message }}</p> @enderror
                        </div>

                     {{-- Kategori --}}
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #2D3A1E; margin-bottom: 4px;">Kategori</label>
                            <div style="position: relative;">
                                <select name="kategori_id" style="width: 100%; padding: 10px 12px; border: 1px solid #E8E2D4; border-radius: 8px; font-size: 13px; background: white; box-sizing: border-box; appearance: none; -webkit-appearance: none; cursor: pointer;">
                                    <option value="">Pilih Kategori ▾</option>
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                            {{ $kategori->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                <div style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #2D3A1E; font-size: 10px;">
                                    ▼
                                </div>
                            </div>
                            @error('kategori_id') <p style="color: #dc2626; font-size: 11px; margin-top: 2px;">{{ $message }}</p> @enderror
                        </div>

                        {{-- Stok --}}
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #2D3A1E; margin-bottom: 4px;">Jumlah Stok</label>
                            <input type="number" name="stok" value="{{ old('stok') }}" min="0" placeholder="0" style="width: 100%; padding: 10px 12px; border: 1px solid #E8E2D4; border-radius: 8px; font-size: 13px; box-sizing: border-box;">
                            @error('stok') <p style="color: #dc2626; font-size: 11px; margin-top: 2px;">{{ $message }}</p> @enderror
                        </div>

                        {{-- Tombol Aksi --}}
                        <div style="margin-top: 8px; display: flex; flex-direction: column; gap: 10px;">
                            <button type="submit" style="width: 100%; background-color: #2D3A1E; color: #D4A017; padding: 12px; border-radius: 8px; border: 1px solid #D4A017; font-weight: bold; cursor: pointer; font-size: 13px;">Simpan Buku</button>
                            <a href="{{ route('buku.index') }}" style="width: 100%; text-align: center; text-decoration: none; background-color: #F5F0E8; color: #2D3A1E; padding: 12px; border-radius: 8px; border: 1px solid #E8E2D4; font-weight: bold; font-size: 13px; box-sizing: border-box;">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>