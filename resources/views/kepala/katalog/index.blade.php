<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Katalog Buku</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

{{-- NAVBAR --}}
<nav class="px-8 h-14 flex items-center justify-between" style="background-color:#db2777;">
    <span class="text-white font-bold text-lg italic">Sistem Perpustakaan</span>
    <span class="text-white text-sm">{{ Auth::user()->name }}</span>
</nav>

<div class="flex flex-1">

   {{-- SIDEBAR --}}
    <aside class="w-44 flex flex-col py-4 gap-2"
        style="background-color:#db2777; min-height: calc(100vh - 56px);">

        <a href="{{ route('kepala.dashboard') }}"
            class="mx-3 px-4 py-2 rounded text-white text-sm text-center {{ request()->routeIs('kepala.dashboard') ? 'font-bold' : '' }}"
            style="background-color: {{ request()->routeIs('kepala.dashboard') ? '#831843' : '#9d174d' }};">
            Dashboard
        </a>

          <a href="{{ route('kepala.petugas.index') }}"
            class="mx-3 px-4 py-2 rounded text-white text-sm text-center {{ request()->routeIs('kepala.petugas.*') ? 'font-bold' : '' }}"
            style="background-color: {{ request()->routeIs('kepala.petugas.*') ? '#831843' : '#9d174d' }};">
            Data Petugas
        </a>

        <a href="{{ route('kepala.katalog') }}"
            class="mx-3 px-4 py-2 rounded text-white text-sm text-center {{ request()->routeIs('kepala.katalog') ? 'font-bold' : '' }}"
            style="background-color: {{ request()->routeIs('kepala.katalog') ? '#831843' : '#9d174d' }};">
            Katalog Buku
        </a>

      

        <a href="{{ route('kepala.anggota.index') }}"
            class="mx-3 px-4 py-2 rounded text-white text-sm text-center {{ request()->routeIs('kepala.anggota.*') ? 'font-bold' : '' }}"
            style="background-color: {{ request()->routeIs('kepala.anggota.*') ? '#831843' : '#9d174d' }};">
            Daftar Anggota
        </a>

        <a href="{{ route('kepala.laporan') }}"
            class="mx-3 px-4 py-2 rounded text-white text-sm text-center {{ request()->routeIs('kepala.laporan') ? 'font-bold' : '' }}"
            style="background-color: {{ request()->routeIs('kepala.laporan') ? '#831843' : '#9d174d' }};">
            Laporan
        </a>

        {{-- LOGOUT --}}
        <div class="mt-auto mx-3 pb-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full px-4 py-2 rounded text-white text-sm"
                    style="background-color:#9d174d;">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- CONTENT --}}
    <main class="flex-1 p-8">

        <h1 class="text-2xl font-bold text-gray-800 mb-6">Katalog Buku</h1>

        {{-- FILTER --}}
        <form method="GET" action="{{ route('kepala.katalog') }}"
              class="flex justify-end gap-3 mb-6">

            <select name="kategori_id"
                onchange="this.form.submit()"
                class="border px-3 py-2 rounded text-sm">
                <option value="">Semua Kategori</option>
                @foreach ($kategoris as $kategori)
                    <option value="{{ $kategori->id }}"
                        {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>

            <input type="text" name="search"
                value="{{ request('search') }}"
                placeholder="Cari Buku..."
                class="border px-3 py-2 rounded text-sm">
        </form>

        {{-- KATALOG --}}
        <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;">

            @foreach ($bukus as $buku)
            <div class="bg-white rounded-xl overflow-hidden shadow hover:shadow-md transition flex flex-col">

                {{-- COVER --}}
                @if($buku->foto)
                    <img src="{{ asset('storage/' . $buku->foto) }}"
                         class="w-full object-cover" style="height:220px;">
                @else
                    <div class="w-full flex items-center justify-center bg-pink-100"
                         style="height:220px;">
                        📚
                    </div>
                @endif

                <div class="p-4 flex flex-col flex-1">

                    <p class="font-semibold text-gray-800 text-base">{{ $buku->judul }}</p>
                    <p class="text-sm text-gray-500">{{ $buku->pengarang }}</p>

                    <span class="inline-block px-2 py-1 text-xs mt-2 rounded-full text-white"
                          style="background:#db2777;">
                        {{ $buku->kategori->nama_kategori ?? '-' }}
                    </span>

                    <p class="text-sm text-gray-400 mt-2">Stok: {{ $buku->stok }}</p>

                    <span class="mt-3 text-xs text-gray-400 italic">View Only</span>

                </div>
            </div>
            @endforeach

        </div>

    </main>
</div>

</body>
</html>