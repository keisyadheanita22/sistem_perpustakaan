<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Anggota</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- NAVBAR: Menampilkan nama sistem dan inisial user yang bisa diklik ke halaman profil --}}
    <nav class="px-8 h-14 flex items-center justify-between" style="background-color:#db2777;">
        <span class="text-white font-bold text-lg italic">Sistem Perpustakaan</span>

        {{-- Inisial huruf pertama nama user dalam lingkaran, klik untuk ke halaman profil --}}
        <a href="{{ route('anggota.profil') }}" class="flex items-center gap-2 text-white text-sm hover:opacity-80">
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold text-white"
                style="background-color:#9d174d;">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <span>{{ Auth::user()->name }}</span>
        </a>
    </nav>

    <div class="flex flex-1">

        {{-- SIDEBAR: Menu navigasi utama untuk anggota --}}
        <aside class="w-44 flex flex-col py-4 gap-2" style="background-color:#db2777; min-height: calc(100vh - 56px);">

            {{-- Menu Dashboard (aktif/highlight) --}}
            <a href="{{ route('anggota.dashboard') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center font-bold" style="background-color:#831843;">Dashboard</a>

            {{-- Menu Katalog Buku --}}
            <a href="{{ route('katalog.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Katalog Buku</a>

            {{-- Menu Peminjaman Saya --}}
            <a href="{{ route('peminjaman.saya') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Peminjaman Saya</a>

            {{-- Menu Denda Saya --}}
            <a href="{{ route('denda.saya') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Denda Saya</a>

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

        <main class="flex-1 p-8">

            {{-- JUDUL HALAMAN --}}
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-800">Dashboard Anggota</h1>
                <p class="text-gray-500 text-sm mt-1">Selamat datang, {{ Auth::user()->name }}! 👋</p>
            </div>

            {{-- KARTU STATISTIK: Menampilkan total buku, peminjaman, dan denda anggota --}}
            <div class="grid grid-cols-3 gap-6 mb-8">

                {{-- Kartu Total Buku --}}
                <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4 border-l-4" style="border-color:#db2777;">
                    <div class="rounded-full p-3 text-white text-2xl" style="background-color:#db2777;">📚</div>
                    <div>
                        <p class="text-sm text-gray-500">Total Buku</p>
                        <p class="text-3xl font-bold text-gray-800">{{ \App\Models\Buku::count() }}</p>
                        <p class="text-xs text-gray-400 mt-1">Buku tersedia</p>
                    </div>
                </div>

                {{-- Kartu Total Peminjaman milik anggota yang sedang login --}}
                <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4 border-l-4" style="border-color:#db2777;">
                    <div class="rounded-full p-3 text-white text-2xl" style="background-color:#db2777;">📖</div>
                    <div>
                        <p class="text-sm text-gray-500">Peminjaman Saya</p>
                        <p class="text-3xl font-bold text-gray-800">{{ \App\Models\Peminjaman::where('nama_anggota', Auth::user()->name)->count() }}</p>
                        <p class="text-xs text-gray-400 mt-1">Total peminjaman</p>
                    </div>
                </div>

                {{-- Kartu Denda yang belum dibayar milik anggota yang sedang login --}}
                <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4 border-l-4" style="border-color:#db2777;">
                    <div class="rounded-full p-3 text-white text-2xl" style="background-color:#db2777;">⚠️</div>
                    <div>
                        <p class="text-sm text-gray-500">Denda Saya</p>
                        <p class="text-3xl font-bold text-red-500">{{ \App\Models\Denda::where('nama_anggota', Auth::user()->name)->where('status_bayar', 'belum_bayar')->count() }}</p>
                        <p class="text-xs text-gray-400 mt-1">Belum dibayar</p>
                    </div>
                </div>
            </div>

            {{-- AKSES CEPAT: Shortcut ke halaman yang sering diakses anggota --}}
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-base font-semibold text-gray-700 mb-4">⚡ Akses Cepat</h2>
                <div class="grid grid-cols-3 gap-4">

                    {{-- Shortcut ke Katalog Buku --}}
                    <a href="{{ route('katalog.index') }}" class="flex flex-col items-center gap-2 px-4 py-5 rounded-xl text-white text-sm font-medium transition hover:opacity-90" style="background-color:#db2777;">
                        <span class="text-3xl">📚</span>
                        Lihat Katalog Buku
                    </a>

                    {{-- Shortcut ke Peminjaman Saya --}}
                    <a href="{{ route('peminjaman.saya') }}" class="flex flex-col items-center gap-2 px-4 py-5 rounded-xl text-white text-sm font-medium transition hover:opacity-90" style="background-color:#9d174d;">
                        <span class="text-3xl">📋</span>
                        Peminjaman Saya
                    </a>

                    {{-- Shortcut ke Denda Saya --}}
                    <a href="{{ route('denda.saya') }}" class="flex flex-col items-center gap-2 px-4 py-5 rounded-xl text-white text-sm font-medium transition hover:opacity-90" style="background-color:#be185d;">
                        <span class="text-3xl">💰</span>
                        Denda Saya
                    </a>
                </div>
            </div>

        </main>
    </div>

</body>
</html>