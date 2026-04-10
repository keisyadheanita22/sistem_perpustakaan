<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Katalog Buku</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

{{-- Background abu-abu untuk seluruh halaman --}}
<body class="bg-gray-100 min-h-screen flex flex-col">

{{-- ============================================================ --}}
{{-- NAVBAR - Bar atas dengan logo dan info user yang sedang login --}}
{{-- ============================================================ --}}
<nav class="px-8 h-14 flex items-center justify-between" style="background-color:#db2777;">

    {{-- Logo / Nama Sistem --}}
    <span class="text-white font-bold text-lg italic">Sistem Perpustakaan</span>

    {{-- Foto & Nama User (klik ke halaman profil) --}}
    <a href="{{ route('kepala.profil') }}" class="flex items-center gap-2 text-white text-sm hover:opacity-80">
        @if(Auth::user()->foto)
            {{-- Tampilkan foto profil kalau ada --}}
            <img src="{{ asset('storage/' . Auth::user()->foto) }}"
                 style="width:32px; height:32px; border-radius:50%; object-fit:cover;">
        @else
            {{-- Tampilkan inisial nama kalau belum ada foto --}}
            <div style="width:32px; height:32px; border-radius:50%; background-color:#9d174d;
                        display:flex; align-items:center; justify-content:center;
                        font-size:14px; font-weight:700; color:white;">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
        @endif
        <span>{{ Auth::user()->name }}</span>
    </a>
</nav>

{{-- ============================================================ --}}
{{-- LAYOUT UTAMA - Sidebar + Content berdampingan               --}}
{{-- ============================================================ --}}
<div class="flex flex-1">

    {{-- ========================================================= --}}
    {{-- SIDEBAR - Navigasi menu untuk kepala perpustakaan          --}}
    {{-- ========================================================= --}}
    <aside class="w-44 flex flex-col py-4 gap-2"
           style="background-color:#db2777; min-height: calc(100vh - 56px);">

        {{-- Menu Dashboard --}}
        <a href="{{ route('kepala.dashboard') }}"
           class="mx-3 px-4 py-2 rounded text-white text-sm text-center {{ request()->routeIs('kepala.dashboard') ? 'font-bold' : '' }}"
           style="background-color: {{ request()->routeIs('kepala.dashboard') ? '#831843' : '#9d174d' }};">
            Dashboard
        </a>

        {{-- Menu Data Petugas --}}
        <a href="{{ route('kepala.petugas.index') }}"
           class="mx-3 px-4 py-2 rounded text-white text-sm text-center {{ request()->routeIs('kepala.petugas.*') ? 'font-bold' : '' }}"
           style="background-color: {{ request()->routeIs('kepala.petugas.*') ? '#831843' : '#9d174d' }};">
            Data Petugas
        </a>

        {{-- Menu Katalog Buku (halaman ini) --}}
        <a href="{{ route('kepala.katalog') }}"
           class="mx-3 px-4 py-2 rounded text-white text-sm text-center {{ request()->routeIs('kepala.katalog') ? 'font-bold' : '' }}"
           style="background-color: {{ request()->routeIs('kepala.katalog') ? '#831843' : '#9d174d' }};">
            Katalog Buku
        </a>

        {{-- Menu Daftar Anggota --}}
        <a href="{{ route('kepala.anggota.index') }}"
           class="mx-3 px-4 py-2 rounded text-white text-sm text-center {{ request()->routeIs('kepala.anggota.*') ? 'font-bold' : '' }}"
           style="background-color: {{ request()->routeIs('kepala.anggota.*') ? '#831843' : '#9d174d' }};">
            Daftar Anggota
        </a>

        {{-- Menu Laporan --}}
        <a href="{{ route('kepala.laporan') }}"
           class="mx-3 px-4 py-2 rounded text-white text-sm text-center {{ request()->routeIs('kepala.laporan') ? 'font-bold' : '' }}"
           style="background-color: {{ request()->routeIs('kepala.laporan') ? '#831843' : '#9d174d' }};">
            Laporan
        </a>

        {{-- Tombol Logout - selalu di paling bawah sidebar --}}
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

    {{-- ========================================================= --}}
    {{-- CONTENT UTAMA - Area katalog buku                          --}}
    {{-- ========================================================= --}}
    <main class="flex-1 p-8">

        {{-- Judul Halaman --}}
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Katalog Buku</h1>

        {{-- ===================================================== --}}
        {{-- FILTER - Dropdown kategori dan kolom pencarian buku    --}}
        {{-- ===================================================== --}}
        <form method="GET" action="{{ route('kepala.katalog') }}"
              class="flex justify-end gap-3 mb-6">

            {{-- Dropdown filter berdasarkan kategori --}}
            <select name="kategori_id"
                    onchange="this.form.submit()"
                    class="border px-3 py-1 rounded text-sm">
                <option value="">Semua Kategori</option>
                @foreach ($kategoris as $kategori)
                    <option value="{{ $kategori->id }}"
                        {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>

           {{-- Input pencarian berdasarkan judul atau pengarang --}}
            <div class="flex items-center gap-2 border border-gray-300 rounded-lg px-3 py-2 bg-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                </svg>
                <input type="text" name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari Buku..."
                    class="outline-none border-0 text-sm w-48 bg-transparent">
            </div>
        </form>

        {{-- ===================================================== --}}
        {{-- GRID KATALOG - Tampilkan semua buku dalam bentuk card  --}}
        {{-- Setiap card tingginya sama karena pakai flex-col + h-full --}}
        {{-- ===================================================== --}}
        <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; align-items: stretch;">

            @forelse ($bukus as $buku)

            {{-- Card Buku - tinggi rata karena pakai h-full --}}
            <div class="bg-white rounded-xl overflow-hidden shadow hover:shadow-md transition flex flex-col h-full">

                {{-- Cover Buku --}}
                @if($buku->foto)
                    {{-- Tampilkan foto cover kalau ada --}}
                    <img src="{{ asset('storage/' . $buku->foto) }}"
                         class="w-full object-cover flex-shrink-0"
                         style="height:320px;">
                @else
                    {{-- Placeholder kalau tidak ada foto cover --}}
                    <div class="w-full flex items-center justify-center bg-pink-100 flex-shrink-0"
                         style="height:240px; font-size:48px;">
                        📚
                    </div>
                @endif

                {{-- Informasi Buku --}}
                <div class="p-4 flex flex-col flex-1">

                    {{-- Judul buku - clamp 2 baris supaya card tidak melar --}}
                    <p class="font-semibold text-gray-800 text-sm leading-snug mb-1"
                       style="display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; min-height:2.5rem;">
                        {{ $buku->judul }}
                    </p>

                    {{-- Nama pengarang --}}
                    <p class="text-xs text-gray-500 mb-2 truncate">{{ $buku->pengarang }}</p>

                    {{-- Badge kategori --}}
                    <span class="inline-block px-3 py-1 text-xs rounded-full text-white text-center mb-2"
                          style="background:#db2777;">
                        {{ $buku->kategori->nama_kategori ?? '-' }}
                    </span>

                    {{-- Info stok --}}
                    <p class="text-xs text-gray-400 mt-auto pt-2">Stok: {{ $buku->stok }}</p>

                    {{-- Label view only karena kepala tidak bisa meminjam --}}
                    <span class="mt-1 text-xs text-gray-400 italic">View Only</span>

                </div>
            </div>

            @empty
                {{-- Tampilkan pesan kalau tidak ada buku yang ditemukan --}}
                <div class="col-span-full text-center text-gray-400 py-16">
                    <p class="text-4xl mb-3">📭</p>
                    <p class="text-sm">Tidak ada buku yang ditemukan.</p>
                </div>
            @endforelse

        </div>

    </main>
</div>

</body>
</html>