<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- NAVBAR: Menampilkan nama sistem dan inisial user --}}
    <nav class="px-8 h-14 flex items-center justify-between" style="background-color:#db2777;">
        <span class="text-white font-bold text-lg italic">Sistem Perpustakaan</span>

        {{-- Inisial huruf pertama nama petugas dalam lingkaran --}}
        <div class="flex items-center gap-2 text-white text-sm">
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold text-white"
                style="background-color:#9d174d;">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <span>{{ Auth::user()->name }}</span>
        </div>
    </nav>

    <div class="flex flex-1">

        {{-- SIDEBAR: Menu navigasi utama untuk petugas --}}
        <aside class="w-44 flex flex-col py-4 gap-2" style="background-color:#db2777; min-height: calc(100vh - 56px);">

            {{-- Menu Dashboard --}}
            <a href="{{ route('petugas.dashboard') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Dashboard</a>

            {{-- Menu Data Buku (aktif/highlight) --}}
            <a href="{{ route('buku.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center font-bold" style="background-color:#831843;">Data Buku</a>

            {{-- Menu Data Anggota --}}
            <a href="{{ route('anggota.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Data Anggota</a>

            {{-- Menu Peminjaman --}}
            <a href="{{ route('peminjaman.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Peminjaman</a>

            {{-- Menu Kategori --}}
            <a href="{{ route('kategori.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Kategori</a>

            {{-- Menu Denda --}}
            <a href="{{ route('denda.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Denda</a>

            {{-- Tombol Logout di bagian bawah sidebar --}}
            <div class="mt-auto mx-3 pb-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 rounded text-white text-sm" style="background-color:#9d174d;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 flex items-start justify-center p-8">
            <div class="w-full max-w-md">
                <div class="rounded-xl overflow-hidden shadow-lg">

                    {{-- Header form --}}
                    <div class="px-6 py-3 text-white text-sm font-semibold" style="background-color:#db2777;">
                        + Tambah Buku
                    </div>

                    <div class="bg-white px-8 py-6">

                        {{-- FORM TAMBAH BUKU: Kirim data ke BukuController@store --}}
                        <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- Preview foto sebelum diupload --}}
                            <div class="mb-4 text-center">
                                <div id="preview-container" class="mx-auto mb-2 rounded-lg overflow-hidden flex items-center justify-center" style="width:120px; height:160px; background:#fce7f3;">
                                    <img id="preview-img" src="" alt="" class="hidden w-full h-full object-cover">
                                    <span id="preview-icon" style="font-size:40px;">📚</span>
                                </div>
                                <label class="block text-sm text-gray-600 mb-1">Foto Sampul <span class="text-gray-400">(opsional)</span></label>
                                {{-- Input upload foto, trigger preview saat file dipilih --}}
                                <input type="file" name="foto" id="foto" accept="image/*"
                                    onchange="previewFoto(this)"
                                    class="border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400 w-64">
                                @error('foto') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Input judul buku --}}
                            <div class="mb-4 text-center">
                                <label class="block text-sm text-gray-600 mb-1">Judul</label>
                                <input type="text" name="judul" value="{{ old('judul') }}"
                                    class="border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400 w-64">
                                @error('judul') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Input nama pengarang --}}
                            <div class="mb-4 text-center">
                                <label class="block text-sm text-gray-600 mb-1">Pengarang</label>
                                <input type="text" name="pengarang" value="{{ old('pengarang') }}"
                                    class="border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400 w-64">
                                @error('pengarang') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Input nama penerbit --}}
                            <div class="mb-4 text-center">
                                <label class="block text-sm text-gray-600 mb-1">Penerbit</label>
                                <input type="text" name="penerbit" value="{{ old('penerbit') }}"
                                    class="border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400 w-64">
                                @error('penerbit') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Dropdown pilih kategori buku --}}
                            <div class="mb-4 text-center">
                                <label class="block text-sm text-gray-600 mb-1">Kategori</label>
                                <select name="kategori_id"
                                    class="border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400 w-64">
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                            {{ $kategori->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Input jumlah stok buku --}}
                            <div class="mb-6 text-center">
                                <label class="block text-sm text-gray-600 mb-1">Stok</label>
                                <input type="number" name="stok" value="{{ old('stok') }}" min="0"
                                    class="border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400 w-64">
                                @error('stok') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Tombol simpan dan batal --}}
                            <div class="flex justify-center gap-3">
                                <button type="submit" class="text-white px-8 py-2 rounded text-sm font-medium" style="background-color:#22c55e;">Simpan</button>
                                <a href="{{ route('buku.index') }}" class="text-white px-8 py-2 rounded text-sm font-medium" style="background-color:#ef4444;">Batal</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    {{-- SCRIPT: Preview foto sebelum diupload --}}
    <script>
    function previewFoto(input) {
        const img = document.getElementById('preview-img');
        const icon = document.getElementById('preview-icon');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Tampilkan foto yang dipilih dan sembunyikan icon default
                img.src = e.target.result;
                img.classList.remove('hidden');
                icon.classList.add('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>

</body>
</html>