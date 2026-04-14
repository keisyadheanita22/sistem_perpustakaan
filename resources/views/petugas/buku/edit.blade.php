<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku - Petugas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        // Fungsi untuk buka-tutup menu profil di pojok kanan atas
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
        }

        // Fungsi untuk menampilkan preview foto saat user memilih file baru
        function previewFoto(input) {
            const img = document.getElementById('preview-img');
            const icon = document.getElementById('preview-icon');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    img.style.display = 'block';
                    icon.style.display = 'none';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Menutup dropdown profil secara otomatis jika user klik di luar area menu
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
                {{-- Foto profil atau inisial --}}
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
            <a href="{{ route('petugas.dashboard') }}" style="display: flex; align-items: center; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">Dashboard</a>

            {{-- Link data buku - aktif --}}
            <a href="{{ route('buku.index') }}" style="display: flex; align-items: center; padding: 9px 12px; border-radius: 8px; background: #D4A017; color: #2D3A1E; font-size: 13px; text-decoration: none; font-weight: 600;">Data Buku</a>

            {{-- Link data anggota --}}
            <a href="{{ route('anggota.index') }}" style="display: flex; align-items: center; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">Data Anggota</a>

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
        <main style="flex: 1; padding: 32px; display: flex; justify-content: center; align-items: flex-start;">
            <div style="width: 100%; max-width: 420px;">

                {{-- Tombol kembali + judul halaman --}}
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px;">
                    <a href="{{ route('buku.index') }}" style="display: flex; align-items: center; gap: 4px; color: #2D3A1E; text-decoration: none; font-size: 13px; font-weight: 600;">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width: 16px; height: 16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Kembali
                    </a>
                    <h1 style="font-size: 22px; font-weight: 700; color: #2D3A1E; margin: 0;">Edit Data Buku</h1>
                </div>

                {{-- Kartu form edit buku --}}
                <div style="background: white; border-radius: 12px; border: 1px solid #D4A017; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.06);">

                    {{-- Header kartu warna biru tua --}}
                    <div style="background-color: #1E3A5F; color: white; padding: 14px 24px; font-weight: bold; font-size: 15px; border-bottom: 2px solid #D4A017;">
                        ✎ Edit Data Buku
                    </div>

                    <div style="padding: 24px;">
                        <form action="{{ route('buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 16px;">
                            @csrf
                            @method('PUT')

                            {{-- Preview foto sampul buku --}}
                            <div style="text-align: center;">
                                <div style="margin: 0 auto 12px; width: 100px; height: 130px; background: #F5F0E8; border-radius: 8px; border: 2px dashed #D4A017; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                    @if($buku->foto)
                                        <img id="preview-img" src="{{ asset('storage/' . $buku->foto) }}" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                                        <span id="preview-icon" style="font-size: 30px; display: none;">📚</span>
                                    @else
                                        <img id="preview-img" src="" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                                        <span id="preview-icon" style="font-size: 30px; display: block;">📚</span>
                                    @endif
                                </div>
                                <input type="file" name="foto" onchange="previewFoto(this)" style="font-size: 11px; color: #2D3A1E; width: 100%;">
                                @error('foto') <p style="color: #dc2626; font-size: 11px; margin-top: 4px; text-align: left;">{{ $message }}</p> @enderror
                            </div>

                            {{-- Input judul buku --}}
                            <div>
                                <label style="display: block; font-size: 13px; font-weight: 600; color: #2D3A1E; margin-bottom: 4px;">Judul Buku</label>
                                <input type="text" name="judul" value="{{ old('judul', $buku->judul) }}"
                                    style="width: 100%; padding: 10px 12px; border: 1px solid #D4A017; border-radius: 8px; font-size: 13px; box-sizing: border-box; outline: none;">
                                @error('judul') <p style="color: #dc2626; font-size: 11px; margin-top: 2px;">{{ $message }}</p> @enderror
                            </div>

                            {{-- Input pengarang --}}
                            <div>
                                <label style="display: block; font-size: 13px; font-weight: 600; color: #2D3A1E; margin-bottom: 4px;">Pengarang</label>
                                <input type="text" name="pengarang" value="{{ old('pengarang', $buku->pengarang) }}"
                                    style="width: 100%; padding: 10px 12px; border: 1px solid #D4A017; border-radius: 8px; font-size: 13px; box-sizing: border-box; outline: none;">
                                @error('pengarang') <p style="color: #dc2626; font-size: 11px; margin-top: 2px;">{{ $message }}</p> @enderror
                            </div>

                            {{-- Input penerbit --}}
                            <div>
                                <label style="display: block; font-size: 13px; font-weight: 600; color: #2D3A1E; margin-bottom: 4px;">Penerbit</label>
                                <input type="text" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}"
                                    style="width: 100%; padding: 10px 12px; border: 1px solid #D4A017; border-radius: 8px; font-size: 13px; box-sizing: border-box; outline: none;">
                                @error('penerbit') <p style="color: #dc2626; font-size: 11px; margin-top: 2px;">{{ $message }}</p> @enderror
                            </div>

                            {{-- Dropdown pilih kategori --}}
                            <div>
                                <label style="display: block; font-size: 13px; font-weight: 600; color: #2D3A1E; margin-bottom: 4px;">Kategori</label>
                                <div style="position: relative;">
                                    <select name="kategori_id" style="width: 100%; padding: 10px 12px; border: 1px solid #D4A017; border-radius: 8px; font-size: 13px; background: white; box-sizing: border-box; appearance: none; -webkit-appearance: none; cursor: pointer; outline: none;">
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}" {{ old('kategori_id', $buku->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                                {{ $kategori->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #2D3A1E; font-size: 10px;">▼</div>
                                </div>
                                @error('kategori_id') <p style="color: #dc2626; font-size: 11px; margin-top: 2px;">{{ $message }}</p> @enderror
                            </div>

                            {{-- Input jumlah stok --}}
                            <div>
                                <label style="display: block; font-size: 13px; font-weight: 600; color: #2D3A1E; margin-bottom: 4px;">Jumlah Stok</label>
                                <input type="number" name="stok" value="{{ old('stok', $buku->stok) }}" min="0"
                                    style="width: 100%; padding: 10px 12px; border: 1px solid #D4A017; border-radius: 8px; font-size: 13px; box-sizing: border-box; outline: none;">
                                @error('stok') <p style="color: #dc2626; font-size: 11px; margin-top: 2px;">{{ $message }}</p> @enderror
                            </div>

                            {{-- Tombol simpan dan batal --}}
                            <div style="margin-top: 8px; display: flex; flex-direction: column; gap: 10px;">
                                <button type="submit" style="width: 100%; background-color: #2D3A1E; color: #D4A017; padding: 12px; border-radius: 8px; border: 1px solid #D4A017; font-weight: bold; cursor: pointer; font-size: 13px;">
                                    Simpan Perubahan
                                </button>
                                <a href="{{ route('buku.index') }}" style="width: 100%; text-align: center; text-decoration: none; background-color: #F5F0E8; color: #2D3A1E; padding: 12px; border-radius: 8px; border: 1px solid #E8E2D4; font-weight: bold; font-size: 13px; box-sizing: border-box;">
                                    Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>