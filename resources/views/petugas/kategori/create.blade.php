<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- ===================== NAVBAR ===================== --}}
    {{-- Navigasi atas: logo sistem di kiri, nama petugas di kanan --}}
    <nav class="px-8 h-14 flex items-center justify-between" style="background-color:#db2777;">
        <span class="text-white font-bold text-lg italic">Sistem Perpustakaan</span>

        {{-- Inisial huruf pertama nama petugas dalam lingkaran, klik untuk ke halaman profil --}}
        <a href="{{ route('petugas.profil') }}" class="flex items-center gap-2 text-white text-sm hover:opacity-80">
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold text-white"
                style="background-color:#9d174d;">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <span>{{ Auth::user()->name }}</span>
        </a>
    </nav>

    <div class="flex flex-1">

        {{-- ===================== SIDEBAR ===================== --}}
        {{-- Menu navigasi utama untuk petugas, tampil di sisi kiri --}}
        <aside class="w-44 flex flex-col py-4 gap-2" style="background-color:#db2777; min-height: calc(100vh - 56px);">

            {{-- Menu Dashboard --}}
            <a href="{{ route('petugas.dashboard') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Dashboard</a>

            {{-- Menu Data Buku --}}
            <a href="{{ route('buku.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Data Buku</a>

            {{-- Menu Data Anggota --}}
            <a href="{{ route('anggota.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Data Anggota</a>

            {{-- Menu Peminjaman: tampilkan badge notifikasi jika ada peminjaman yang perlu diverifikasi --}}
            <a href="{{ route('peminjaman.index') }}"
                class="mx-3 px-4 py-2 rounded text-white text-sm text-center flex items-center justify-center gap-2"
                style="background-color:#9d174d;">
                Peminjaman
                @if(!empty($perluVerifikasi) && $perluVerifikasi > 0)
                    {{-- Badge jumlah peminjaman yang menunggu verifikasi, maks tampil "9+" --}}
                    <span style="background-color:white; color:#db2777;"
                        class="text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center leading-none">
                        {{ $perluVerifikasi > 9 ? '9+' : $perluVerifikasi }}
                    </span>
                @endif
            </a>

            {{-- Menu Kategori: aktif/highlight karena halaman ini adalah Tambah Kategori --}}
            <a href="{{ route('kategori.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center font-bold" style="background-color:#831843;">Kategori</a>

            {{-- Menu Denda --}}
            <a href="{{ route('denda.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Denda</a>

            {{-- Tombol Logout di bagian bawah sidebar --}}
            <div class="mt-auto mx-3 pb-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 rounded text-white text-sm" style="background-color:#9d174d;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- ===================== KONTEN UTAMA ===================== --}}
        {{-- items-center justify-center supaya card selalu berada di tengah area konten --}}
        <main class="flex-1 flex flex-col items-center justify-center p-8">

            {{-- Judul halaman --}}
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Kategori</h1>

            {{-- ===================== CARD FORM ===================== --}}
            {{-- max-w-md membatasi lebar card agar tidak terlalu lebar, w-full agar responsif --}}
            <div class="bg-white rounded-xl shadow p-6 w-full max-w-md">

                {{-- Header card: ikon kategori + deskripsi singkat --}}
                <div class="flex items-center gap-3 mb-5 pb-4 border-b border-gray-100">
                    {{-- Ikon tag/label sebagai representasi kategori --}}
                    <div class="w-9 h-9 rounded-lg flex items-center justify-center" style="background-color:#fce7f3;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="#db2777">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-800">Kategori baru</p>
                        <p class="text-xs text-gray-500">Isi nama kategori yang ingin ditambahkan</p>
                    </div>
                </div>

                {{-- FORM TAMBAH KATEGORI: kirim data ke KategoriController@store via POST --}}
                <form method="POST" action="{{ route('kategori.store') }}">
                    @csrf

                    {{-- Input nama kategori baru --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                        {{-- old('nama_kategori') menjaga nilai input tetap ada jika validasi gagal --}}
                        <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400"
                           

                        {{-- Pesan error validasi dari server, muncul jika input kosong atau tidak valid --}}
                        @error('nama_kategori')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tombol aksi: Simpan (hijau) dan Batal (abu-abu, kembali ke daftar kategori) --}}
                    <div class="flex gap-3 mt-6">
                        <button type="submit" class="px-6 py-2 rounded text-white text-sm font-medium" style="background-color:#16a34a;">Simpan</button>
                        <a href="{{ route('kategori.index') }}" class="px-6 py-2 rounded text-sm font-medium text-gray-600 border border-gray-300 bg-white hover:bg-gray-50">Batal</a>
                    </div>
                </form>

            </div>
        </main>
    </div>

</body>
</html>