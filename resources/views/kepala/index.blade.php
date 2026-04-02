<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Buku</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <nav class="px-8 h-14 flex items-center justify-between" style="background-color:#db2777;">
        <span class="text-white font-bold text-lg">Perpustakaan Digital</span>
        <span class="text-white text-sm">{{ auth()->user()->name }}</span>
    </nav>

    <div class="flex flex-1">
        <aside class="w-44 flex flex-col py-4 gap-2" style="background-color:#db2777; min-height: calc(100vh - 56px);">
            <a href="{{ route('kepala.dashboard') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Dashboard</a>
            <a href="{{ route('kepala.katalog') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center font-bold" style="background-color:#831843;">Katalog Buku</a>
            <a href="{{ route(' class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Data Anggota</a>
            <a href="#" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Data Petugas</a>
            <a href="#" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Laporan</a>
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
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Katalog Buku</h1>

            <div class="flex justify-end items-center mb-6">
                <form method="GET" action="{{ route('kepala.katalog') }}" class="flex items-center gap-2">
                    <select name="kategori_id" onchange="this.form.submit()"
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none bg-white">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    <div class="flex items-center border border-gray-300 rounded-lg px-3 py-2 text-sm gap-2 bg-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/></svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Buku..." class="outline-none text-sm w-48">
                    </div>
                </form>
            </div>

            @if($bukus->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 text-gray-400">
                <span class="text-5xl mb-3">📚</span>
                <span>Tidak ada data buku.</span>
            </div>
            @else
            <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;">
                @foreach ($bukus as $buku)
                <div class="bg-white rounded-xl overflow-hidden shadow hover:shadow-md transition flex flex-col">
                    @if($buku->foto)
                        <img src="{{ asset('storage/' . $buku->foto) }}" alt="{{ $buku->judul }}"
                            class="w-full object-cover" style="height:220px;">
                    @else
                        <div class="w-full flex flex-col items-center justify-center" style="height:220px; background: linear-gradient(135deg, #fce7f3, #fbcfe8);">
                            <span style="font-size:36px;">📚</span>
                            <span class="text-xs font-medium mt-1 px-2 text-center" style="color:#9d174d;">{{ Str::limit($buku->judul, 20) }}</span>
                        </div>
                    @endif
                    <div class="p-4 flex flex-col flex-1">
                        <p class="font-semibold text-gray-800 text-base truncate">{{ $buku->judul }}</p>
                        <p class="text-sm text-gray-500 truncate">{{ $buku->pengarang }}</p>
                        <p class="text-sm text-gray-500 truncate">{{ $buku->penerbit }}</p>
                        @if($buku->kategori)
                        <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium mt-2" style="background:#fce7f3; color:#9d174d;">
                            {{ $buku->kategori->nama_kategori }}
                        </span>
                        @endif
                        <p class="text-sm text-gray-400 mt-2">Stok: {{ $buku->stok }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </main>
    </div>

</body>
</html>