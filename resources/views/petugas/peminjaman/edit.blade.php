<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Peminjaman</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        // Fungsi buka/tutup dropdown profil
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
        }
        // Tutup dropdown kalau klik di luar
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

        {{-- Dropdown profil --}}
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

            {{-- Isi dropdown --}}
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

            {{-- Link data anggota --}}
            <a href="{{ route('anggota.index') }}" style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">Data Anggota</a>

            {{-- Link peminjaman - aktif --}}
            <a href="{{ route('peminjaman.index') }}" style="display: flex; align-items: center; padding: 9px 12px; border-radius: 8px; background: #D4A017; color: #2D3A1E; font-size: 13px; text-decoration: none; font-weight: 600;">Peminjaman</a>

            {{-- Link kategori --}}
            <a href="{{ route('kategori.index') }}" style="display: flex; align-items: center; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">Kategori</a>

            {{-- Link denda --}}
            <a href="{{ route('denda.index') }}" style="display: flex; align-items: center; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">Denda</a>
        </aside>

        {{-- KONTEN UTAMA --}}
        <main style="flex: 1; padding: 32px;">

            {{-- Judul halaman --}}
            <div style="margin-bottom: 24px;">
                <h1 style="font-size: 24px; font-weight: 700; color: #2D3A1E; margin: 0;">Edit Peminjaman</h1>
            </div>

            {{-- Form edit peminjaman --}}
             <div style="background: white; border-radius: 12px; border: 1px solid #D4A017; padding: 28px; max-width: 520px; margin: 0 auto; box-shadow: 0 4px 10px rgba(0,0,0,0.06);">

                {{-- Header kartu biru tua --}}
                <div style="background-color: #1E3A5F; color: white; padding: 14px 24px; font-weight: bold; font-size: 15px; border-bottom: 2px solid #D4A017;">
                    ✎ Edit Data Peminjaman
                </div>

                <div style="padding: 24px;">
                    <form method="POST" action="{{ route('peminjaman.update', $peminjaman->id) }}" style="display: flex; flex-direction: column; gap: 16px;">
                        @csrf
                        @method('PUT')

                        {{-- ID peminjaman readonly --}}
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #2D3A1E; margin-bottom: 6px;">ID Peminjaman</label>
                            <input type="text" value="{{ $peminjaman->id_peminjaman }}"
                                style="width: 100%; border: 1px solid #E8E2D4; border-radius: 8px; padding: 8px 12px; font-size: 13px; background: #F5F0E8; color: #8A7E6E; cursor: not-allowed; box-sizing: border-box;"
                                disabled>
                        </div>

                        {{-- Nama anggota readonly --}}
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #2D3A1E; margin-bottom: 6px;">Nama Anggota</label>
                            <input type="text" value="{{ $peminjaman->nama_anggota }}"
                                style="width: 100%; border: 1px solid #E8E2D4; border-radius: 8px; padding: 8px 12px; font-size: 13px; background: #F5F0E8; color: #8A7E6E; cursor: not-allowed; box-sizing: border-box;"
                                disabled>
                        </div>

                        {{-- Buku readonly --}}
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #2D3A1E; margin-bottom: 6px;">Buku</label>
                            <input type="text" value="{{ $peminjaman->buku->judul ?? '-' }}"
                                style="width: 100%; border: 1px solid #E8E2D4; border-radius: 8px; padding: 8px 12px; font-size: 13px; background: #F5F0E8; color: #8A7E6E; cursor: not-allowed; box-sizing: border-box;"
                                disabled>
                        </div>

                        {{-- Tanggal pinjam readonly --}}
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #2D3A1E; margin-bottom: 6px;">Tgl Pinjam</label>
                            <input type="text" value="{{ $peminjaman->tanggal_pinjam }}"
                                style="width: 100%; border: 1px solid #E8E2D4; border-radius: 8px; padding: 8px 12px; font-size: 13px; background: #F5F0E8; color: #8A7E6E; cursor: not-allowed; box-sizing: border-box;"
                                disabled>
                        </div>

                        {{-- Batas kembali bisa diedit untuk perpanjang --}}
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #2D3A1E; margin-bottom: 6px;">Batas Kembali</label>
                            <input type="date" name="tanggal_kembali" value="{{ old('tanggal_kembali', $peminjaman->tanggal_kembali) }}"
                                style="width: 100%; border: 1px solid #D4A017; border-radius: 8px; padding: 8px 12px; font-size: 13px; outline: none; box-sizing: border-box;">
                            @error('tanggal_kembali') <p style="color: #dc2626; font-size: 11px; margin-top: 2px;">{{ $message }}</p> @enderror
                        </div>

                        {{-- Status bisa diedit untuk koreksi data --}}
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #2D3A1E; margin-bottom: 6px;">Status</label>
                            <select name="status" style="width: 100%; border: 1px solid #D4A017; border-radius: 8px; padding: 8px 12px; font-size: 13px; background: white; outline: none; box-sizing: border-box;">
                                <option value="dipinjam" {{ $peminjaman->status == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                <option value="dikembalikan" {{ $peminjaman->status == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                            </select>
                            @error('status') <p style="color: #dc2626; font-size: 11px; margin-top: 2px;">{{ $message }}</p> @enderror
                        </div>

                        {{-- Tombol update dan batal --}}
                        <div style="display: flex; gap: 10px; margin-top: 8px;">
                            <button type="submit" style="padding: 9px 20px; border-radius: 8px; background-color: #2D3A1E; color: #D4A017; border: 1px solid #D4A017; font-size: 13px; font-weight: 600; cursor: pointer;">
                                Update
                            </button>
                            <a href="{{ route('peminjaman.index') }}" style="padding: 9px 20px; border-radius: 8px; border: 1px solid #E8E2D4; font-size: 13px; color: #8A7E6E; text-decoration: none; background: white;">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </main>
    </div>

</body>
</html>