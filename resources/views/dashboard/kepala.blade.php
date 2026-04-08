<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kepala Perpustakaan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- NAVBAR: Menampilkan nama sistem dan inisial user --}}
    <nav class="px-8 h-14 flex items-center justify-between" style="background-color:#db2777;">
        <span class="text-white font-bold text-lg italic">Sistem Perpustakaan</span>

        {{-- Foto profil atau inisial kepala --}}
        <a href="#" class="flex items-center gap-2 text-white text-sm hover:opacity-80">
            @if(Auth::user()->foto)
                <img src="{{ asset('storage/' . Auth::user()->foto) }}"
                     class="w-8 h-8 rounded-full object-cover">
            @else
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold text-white"
                    style="background-color:#9d174d;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            @endif
            <span>{{ Auth::user()->name }}</span>
        </a>
    </nav>

    <div class="flex flex-1">

        {{-- SIDEBAR: Menu navigasi utama untuk kepala --}}
        <aside class="w-44 flex flex-col py-4 gap-2" style="background-color:#db2777; min-height: calc(100vh - 56px);">

            {{-- Menu Dashboard (aktif/highlight) --}}
            <a href="{{ route('kepala.dashboard') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center font-bold" style="background-color:#831843;">Dashboard</a>

            {{-- Menu Data Petugas --}}
            <a href="{{ route('kepala.petugas.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Data Petugas</a>

            {{-- Menu Katalog Buku --}}
            <a href="{{ route('kepala.katalog') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Katalog Buku</a>

            {{-- Menu Daftar Anggota --}}
            <a href="{{ route('kepala.anggota.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Daftar Anggota</a>

            {{-- Menu Laporan --}}
            <a href="{{ route('kepala.laporan') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Laporan</a>

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

        <main class="flex-1 p-8">

            {{-- JUDUL HALAMAN --}}
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-800">Dashboard Kepala</h1>
                <p class="text-gray-500 text-sm mt-1">Selamat datang, {{ Auth::user()->name }}! 👋</p>
            </div>

            {{-- KARTU STATISTIK: Menampilkan total buku, anggota, petugas, dan peminjaman aktif --}}
            <div class="grid grid-cols-4 gap-6 mb-8">

                {{-- Kartu Total Buku --}}
                <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4 border-l-4" style="border-color:#db2777;">
                    <div class="rounded-full p-3 text-white text-2xl" style="background-color:#db2777;">📚</div>
                    <div>
                        <p class="text-sm text-gray-500">Total Buku</p>
                        <p class="text-3xl font-bold text-gray-800">{{ \App\Models\Buku::count() }}</p>
                        <p class="text-xs text-gray-400 mt-1">Buku tersedia</p>
                    </div>
                </div>

                {{-- Kartu Total Anggota yang terdaftar --}}
                <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4 border-l-4" style="border-color:#db2777;">
                    <div class="rounded-full p-3 text-white text-2xl" style="background-color:#db2777;">👤</div>
                    <div>
                        <p class="text-sm text-gray-500">Total Anggota</p>
                        <p class="text-3xl font-bold text-gray-800">{{ \App\Models\User::where('role', 'anggota')->count() }}</p>
                        <p class="text-xs text-gray-400 mt-1">Anggota terdaftar</p>
                    </div>
                </div>

                {{-- Kartu Total Petugas yang terdaftar --}}
                <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4 border-l-4" style="border-color:#db2777;">
                    <div class="rounded-full p-3 text-white text-2xl" style="background-color:#db2777;">🛡️</div>
                    <div>
                        <p class="text-sm text-gray-500">Total Petugas</p>
                        <p class="text-3xl font-bold text-gray-800">{{ \App\Models\User::where('role', 'petugas')->count() }}</p>
                        <p class="text-xs text-gray-400 mt-1">Petugas aktif</p>
                    </div>
                </div>

                {{-- Kartu Peminjaman yang sedang aktif --}}
                <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4 border-l-4" style="border-color:#db2777;">
                    <div class="rounded-full p-3 text-white text-2xl" style="background-color:#db2777;">📖</div>
                    <div>
                        <p class="text-sm text-gray-500">Peminjaman Aktif</p>
                        <p class="text-3xl font-bold text-gray-800">{{ \App\Models\Peminjaman::where('status', 'dipinjam')->count() }}</p>
                        <p class="text-xs text-gray-400 mt-1">Sedang dipinjam</p>
                    </div>
                </div>
            </div>

            {{-- AKSES CEPAT & RINGKASAN --}}
            <div class="grid grid-cols-2 gap-6">

                {{-- AKSES CEPAT: Shortcut ke fitur yang sering dipakai kepala --}}
                <div class="bg-white rounded-xl shadow p-6">
                    <h2 class="text-base font-semibold text-gray-700 mb-4">⚡ Akses Cepat</h2>
                    <div class="flex flex-col gap-3">

                        {{-- Shortcut tambah petugas baru --}}
                        <a href="{{ route('kepala.petugas.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white text-sm font-medium transition hover:opacity-90" style="background-color:#db2777;">
                            🛡️ Tambah Petugas Baru
                        </a>

                        {{-- Shortcut ke halaman daftar anggota --}}
                        <a href="{{ route('kepala.anggota.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white text-sm font-medium transition hover:opacity-90" style="background-color:#9d174d;">
                            👤 Daftar Anggota
                        </a>

                        {{-- Shortcut ke halaman laporan --}}
                        <a href="{{ route('kepala.laporan') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white text-sm font-medium transition hover:opacity-90" style="background-color:#be185d;">
                            📄 Lihat Laporan
                        </a>
                    </div>
                </div>

                {{-- RINGKASAN: Statistik detail perpustakaan --}}
                <div class="bg-white rounded-xl shadow p-6">
                    <h2 class="text-base font-semibold text-gray-700 mb-4">📊 Ringkasan</h2>
                    <div class="flex flex-col gap-3">

                        {{-- Total kategori buku --}}
                        <div class="flex justify-between items-center py-2 border-b">
                            <span class="text-sm text-gray-600">Total Kategori</span>
                            <span class="font-bold text-gray-800">{{ \App\Models\Kategori::count() }}</span>
                        </div>

                        {{-- Jumlah buku yang masih ada stok --}}
                        <div class="flex justify-between items-center py-2 border-b">
                            <span class="text-sm text-gray-600">Buku Tersedia</span>
                            <span class="font-bold text-gray-800">{{ \App\Models\Buku::where('stok', '>', 0)->count() }}</span>
                        </div>

                        {{-- Jumlah buku yang stoknya habis --}}
                        <div class="flex justify-between items-center py-2 border-b">
                            <span class="text-sm text-gray-600">Buku Habis</span>
                            <span class="font-bold text-red-500">{{ \App\Models\Buku::where('stok', 0)->count() }}</span>
                        </div>

                        {{-- Jumlah anggota aktif --}}
                        <div class="flex justify-between items-center py-2">
                            <span class="text-sm text-gray-600">Anggota Aktif</span>
                            <span class="font-bold text-gray-800">{{ \App\Models\User::where('role', 'anggota')->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>