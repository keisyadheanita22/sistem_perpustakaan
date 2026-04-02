<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Kepala')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- Navbar --}}
    <nav class="px-8 h-14 flex items-center justify-between" style="background-color:#db2777;">
        <span class="text-white font-bold text-lg">Perpustakaan Digital</span>
        <span class="text-white text-sm">{{ auth()->user()->name }}</span>
    </nav>

    <div class="flex flex-1">

        {{-- Sidebar --}}
        <aside class="w-44 flex flex-col py-4 gap-2" style="background-color:#db2777; min-height: calc(100vh - 56px);">
            <a href="{{ route('kepala.dashboard') }}"
                class="mx-3 px-4 py-2 rounded text-white text-sm text-center {{ request()->routeIs('kepala.dashboard') ? 'font-bold' : '' }}"
                style="background-color:{{ request()->routeIs('kepala.dashboard') ? '#831843' : '#9d174d' }}">
                Dashboard
            </a>
            <a href="{{ route('kepala.katalog') }}"
                class="mx-3 px-4 py-2 rounded text-white text-sm text-center {{ request()->routeIs('kepala.katalog') ? 'font-bold' : '' }}"
                style="background-color:{{ request()->routeIs('kepala.katalog') ? '#831843' : '#9d174d' }}">
                Katalog Buku
            </a>
            
            <a href="#"
                class="mx-3 px-4 py-2 rounded text-white text-sm text-center"
                style="background-color:#9d174d;">
                Data Petugas
            </a>
            <a href="{{ route('kepala.laporan') }}"
                class="mx-3 px-4 py-2 rounded text-white text-sm text-center"
                style="background-color:#9d174d;">
                Laporan
            </a>

            {{-- Logout --}}
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

        {{-- Konten Halaman --}}
        <main class="flex-1 p-8">
            @yield('content')
        </main>

    </div>

</body>
</html>