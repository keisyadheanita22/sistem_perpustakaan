<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Peminjaman</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <nav class="px-8 h-14 flex items-center" style="background-color:#db2777;">
        <span class="text-white font-bold text-lg italic">Perpustakaan Digital</span>
    </nav>

    <div class="flex flex-1">
        <aside class="w-44 flex flex-col py-4 gap-2" style="background-color:#db2777; min-height: calc(100vh - 56px);">
            <a href="{{ route('petugas.dashboard') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Dashboard</a>
            <a href="{{ route('buku.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Data Buku</a>
            <a href="{{ route('anggota.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Data Anggota</a>
            <a href="{{ route('peminjaman.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center font-bold" style="background-color:#831843;">Peminjaman</a>
            <a href="{{ route('kategori.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Kategori</a>
            <a href="#" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Denda</a>
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

        <main class="flex-1 p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Peminjaman</h1>

            <div class="bg-white rounded-xl shadow p-6 max-w-lg">
                <form method="POST" action="{{ route('peminjaman.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">ID Peminjaman</label>
                        <input type="text" name="id_peminjaman" value="{{ old('id_peminjaman') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400"
                            placeholder="Contoh: PM001"/>
                        @error('id_peminjaman')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Anggota</label>
                        <select name="anggota_id"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400 bg-white">
                            <option value="">-- Pilih Anggota --</option>
                            @foreach($anggota as $a)
                                <option value="{{ $a->id }}" {{ old('anggota_id') == $a->id ? 'selected' : '' }}>
                                    {{ $a->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('anggota_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Buku</label>
                        <select name="buku_id"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400 bg-white">
                            <option value="">-- Pilih Buku --</option>
                            @foreach($bukus as $buku)
                                <option value="{{ $buku->id }}" {{ old('buku_id') == $buku->id ? 'selected' : '' }}>
                                    {{ $buku->judul }} (Stok: {{ $buku->stok }})
                                </option>
                            @endforeach
                        </select>
                        @error('buku_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400"/>
                        @error('tanggal_pinjam')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Batas Kembali</label>
                        <input type="date" name="tanggal_kembali" value="{{ old('tanggal_kembali') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400"/>
                        @error('tanggal_kembali')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-3 mt-6">
                        <button type="submit" class="px-6 py-2 rounded text-white text-sm font-medium" style="background-color:#16a34a;">Simpan</button>
                        <a href="{{ route('peminjaman.index') }}" class="px-6 py-2 rounded text-white text-sm font-medium" style="background-color:#dc2626;">Batal</a>
                    </div>
                </form>
            </div>
        </main>
    </div>

</body>
</html>