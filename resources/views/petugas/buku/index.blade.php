<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Buku</title>
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

        <main class="flex-1 p-8">

            {{-- JUDUL HALAMAN --}}
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Data Buku</h1>
            </div>

            {{-- NOTIFIKASI SUKSES: Muncul setelah berhasil tambah/edit/hapus buku --}}
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm">
                {{ session('success') }}
            </div>
            @endif

            {{-- TOMBOL TAMBAH & FILTER PENCARIAN --}}
            <div class="flex justify-between items-center mb-6">

                {{-- Tombol tambah buku baru --}}
                <a href="{{ route('buku.create') }}" class="text-white px-4 py-2 rounded text-sm font-medium" style="background-color:#db2777;">+ Tambah Buku</a>

                {{-- Filter kategori dan pencarian buku --}}
                <form method="GET" action="{{ route('buku.index') }}" class="flex items-center gap-2">

                    {{-- Dropdown filter berdasarkan kategori --}}
                    <select name="kategori_id" onchange="this.form.submit()"
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none bg-white">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>

                    {{-- Input pencarian berdasarkan judul atau pengarang --}}
                    <div class="flex items-center border border-gray-300 rounded-lg px-3 py-2 text-sm gap-2 bg-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/></svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Buku..." class="outline-none text-sm w-48">
                    </div>
                </form>
            </div>

            {{-- DAFTAR BUKU --}}
            @if($bukus->isEmpty())
            {{-- Tampilan jika tidak ada buku --}}
            <div class="flex flex-col items-center justify-center py-16 text-gray-400">
                <span class="text-5xl mb-3">📚</span>
                <span>Tidak ada data buku.</span>
            </div>
            @else
            {{-- Grid kartu buku --}}
            <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 20px;">
                @foreach ($bukus as $buku)
                <div class="bg-white rounded-xl overflow-hidden shadow hover:shadow-md transition">

                    {{-- Foto buku atau placeholder jika tidak ada foto --}}
                    @if($buku->foto)
                        <img src="{{ asset('storage/' . $buku->foto) }}" alt="{{ $buku->judul }}"
                            class="w-full object-cover" style="height:180px;">
                    @else
                        <div class="w-full flex flex-col items-center justify-center" style="height:180px; background: linear-gradient(135deg, #fce7f3, #fbcfe8);">
                            <span style="font-size:36px;">📚</span>
                            <span class="text-xs font-medium mt-1 px-2 text-center" style="color:#9d174d;">{{ Str::limit($buku->judul, 20) }}</span>
                        </div>
                    @endif

                    <div class="p-3">
                        {{-- Judul dan pengarang buku --}}
                        <p class="font-medium text-gray-800 text-sm truncate">{{ $buku->judul }}</p>
                        <p class="text-xs text-gray-500 mb-2 truncate">{{ $buku->pengarang }}</p>

                        {{-- Badge kategori buku --}}
                        @if($buku->kategori)
                        <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium mb-2" style="background:#fce7f3; color:#9d174d;">
                            {{ $buku->kategori->nama_kategori }}
                        </span>
                        @endif

                        {{-- Info stok buku --}}
                        <p class="text-xs text-gray-400 mb-3">Stok: {{ $buku->stok }}</p>

                        {{-- Tombol Edit dan Hapus --}}
                        <div class="flex gap-2">
                            {{-- Tombol edit buku --}}
                            <a href="{{ route('buku.edit', $buku->id) }}"
                                class="flex-1 text-center text-xs py-1 rounded font-medium"
                                style="background:#fef3c7; color:#92400e; border: 1px solid #fcd34d;">
                                ✏️ Edit
                            </a>

                            {{-- Tombol hapus buku dengan konfirmasi --}}
                            <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" onsubmit="return confirm('Yakin hapus buku ini?')" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full text-xs py-1 rounded font-medium"
                                    style="background:#fee2e2; color:#991b1b; border: 1px solid #fca5a5;">
                                    🗑️ Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </main>
    </div>

</body>
</html>