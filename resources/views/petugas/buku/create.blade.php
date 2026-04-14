<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku - Petugas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
        }
        function previewFoto(input) {
            const img = document.getElementById('preview-img');
            const icon = document.getElementById('preview-icon');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    img.classList.remove('hidden');
                    icon.classList.add('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
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
        <span style="color: #F5F0E8; font-size: 17px; font-weight: bold; font-style: italic;">Sistem Perpustakaan</span>
        
        <div id="userMenu" style="position: relative; cursor: pointer;" onclick="toggleDropdown()">
            <div style="display: flex; align-items: center; gap: 8px; color: #F5F0E8; font-size: 14px;">
                @if(Auth::user()->foto)
                    <img src="{{ asset('storage/' . Auth::user()->foto) }}" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; border: 1px solid #D4A017;">
                @else
                    <div style="width: 32px; height: 32px; border-radius: 50%; background-color: #D4A017; color: #2D3A1E; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
                <span>{{ Auth::user()->name }} ▾</span>
            </div>

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