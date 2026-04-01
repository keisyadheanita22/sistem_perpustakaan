<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Petugas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <nav class="px-8 h-14 flex items-center justify-between" style="background-color:#db2777;">
        <span class="text-white font-bold text-lg italic">Sistem Perpustakaan</span>
        <div class="flex items-center gap-2 text-white text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            <span>{{ Auth::user()->name }}</span>
        </div>
    </nav>

    <div class="flex flex-1">
        <aside class="w-44 flex flex-col py-4 gap-2" style="background-color:#db2777; min-height: calc(100vh - 56px);">
            <a href="{{ route('petugas.dashboard') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center font-bold" style="background-color:#831843;">Dashboard</a>
            <a href="{{ route('buku.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Data Buku</a>
            <a href="{{ route('anggota.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Data Anggota</a>
            <a href="{{ route('peminjaman.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Peminjaman</a>
            <a href="{{ route('kategori.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Kategori</a>
            <a href="{{ route('denda.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Denda</a>
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
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-800">Dashboard Petugas</h1>
                <p class="text-gray-500 text-sm mt-1">Selamat datang, {{ Auth::user()->name }}! 👋</p>
            </div>

            {{-- Statistik --}}
            <div class="grid grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4 border-l-4" style="border-color:#db2777;">
                    <div class="rounded-full p-3 text-white text-2xl" style="background-color:#db2777;">📚</div>
                    <div>
                        <p class="text-sm text-gray-500">Total Buku</p>
                        <p class="text-3xl font-bold text-gray-800">{{ \App\Models\Buku::count() }}</p>
                        <p class="text-xs text-gray-400 mt-1">Buku tersedia</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4 border-l-4" style="border-color:#db2777;">
                    <div class="rounded-full p-3 text-white text-2xl" style="background-color:#db2777;">👤</div>
                    <div>
                        <p class="text-sm text-gray-500">Total Anggota</p>
                        <p class="text-3xl font-bold text-gray-800">{{ \App\Models\Anggota::count() }}</p>
                        <p class="text-xs text-gray-400 mt-1">Anggota terdaftar</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4 border-l-4" style="border-color:#db2777;">
                    <div class="rounded-full p-3 text-white text-2xl" style="background-color:#db2777;">📖</div>
                    <div>
                        <p class="text-sm text-gray-500">Total Peminjaman</p>
                        <p class="text-3xl font-bold text-gray-800">{{ \App\Models\Peminjaman::where('status', 'dipinjam')->count() }}</p>
                        <p class="text-xs text-gray-400 mt-1">Sedang dipinjam</p>
                    </div>
                </div>
            </div>

            {{-- Quick Access --}}
            <div class="grid grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow p-6">
                    <h2 class="text-base font-semibold text-gray-700 mb-4">⚡ Akses Cepat</h2>
                    <div class="flex flex-col gap-3">
                        <a href="{{ route('buku.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white text-sm font-medium transition hover:opacity-90" style="background-color:#db2777;">
                            📚 Tambah Buku Baru
                        </a>
                        <a href="{{ route('anggota.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white text-sm font-medium transition hover:opacity-90" style="background-color:#9d174d;">
                            👤 Data Anggota
                        </a>
                        <a href="{{ route('peminjaman.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white text-sm font-medium transition hover:opacity-90" style="background-color:#be185d;">
                            📖 Tambah Peminjaman
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow p-6">
                    <h2 class="text-base font-semibold text-gray-700 mb-4">📊 Ringkasan</h2>
                    <div class="flex flex-col gap-3">
                        <div class="flex justify-between items-center py-2 border-b">
                            <span class="text-sm text-gray-600">Total Kategori</span>
                            <span class="font-bold text-gray-800">{{ \App\Models\Kategori::count() }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b">
                            <span class="text-sm text-gray-600">Buku Tersedia</span>
                            <span class="font-bold text-gray-800">{{ \App\Models\Buku::where('stok', '>', 0)->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b">
                            <span class="text-sm text-gray-600">Buku Habis</span>
                            <span class="font-bold text-red-500">{{ \App\Models\Buku::where('stok', 0)->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-sm text-gray-600">Anggota Aktif</span>
                            <span class="font-bold text-gray-800">{{ \App\Models\Anggota::count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>