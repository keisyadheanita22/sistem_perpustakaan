<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kepala Perpustakaan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- Navbar --}}
    <nav class="bg-pink-500 px-8 h-14 flex items-center justify-between">
        <span class="text-white font-bold text-lg italic">Perpustakaan Digital</span>
        <div class="flex items-center gap-2 text-white text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            <span>Kepala Perpustakaan</span>
        </div>
    </nav>

    <div class="flex flex-1">

        {{-- Sidebar --}}
        <aside class="w-40 bg-pink-500 flex flex-col py-4 gap-1 min-h-screen">
            <a href="{{ route('kepala.dashboard') }}"
                class="mx-3 px-4 py-2 rounded text-white text-sm font-semibold bg-pink-700">
                Dashboard
            </a>
            <a href="#"
                class="mx-3 px-4 py-2 rounded text-white text-sm hover:bg-pink-600 transition">
                Data Buku
            </a>
            <a href="#"
                class="mx-3 px-4 py-2 rounded text-white text-sm hover:bg-pink-600 transition">
                Data Anggota
            </a>
            <a href="#"
                class="mx-3 px-4 py-2 rounded text-white text-sm hover:bg-pink-600 transition">
                Data Petugas
            </a>
            <a href="#"
                class="mx-3 px-4 py-2 rounded text-white text-sm hover:bg-pink-600 transition">
                Laporan
            </a>

            {{-- Logout --}}
            <div class="mt-auto mx-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-2 px-4 py-2 rounded text-white text-sm hover:bg-pink-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- Content --}}
        <main class="flex-1 p-8">
            <h1 class="text-xl font-semibold text-gray-800 mb-6">Dashboard</h1>

           <div class="grid grid-cols-4 gap-4">
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-pink-500">
        <p class="text-sm text-gray-500">Total Buku</p>
        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalBuku }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-pink-400">
        <p class="text-sm text-gray-500">Total Anggota</p>
        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalAnggota }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-pink-300">
        <p class="text-sm text-gray-500">Total Petugas</p>
        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalPetugas }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-pink-200">
        <p class="text-sm text-gray-500">Peminjaman Aktif</p>
        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $peminjamanAktif }}</p>
    </div>
</div>
            </div>
        </main>

    </div>

</body>
</html>