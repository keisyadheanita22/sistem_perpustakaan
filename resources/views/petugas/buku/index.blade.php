<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Buku</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

<nav class="px-8 h-14 flex items-center justify-between" style="background-color:#db2777;">
    <span class="text-white font-bold text-lg italic">Sistem Perpustakaan</span>
    <a href="{{ route('petugas.profil') }}" class="flex items-center gap-2 text-white text-sm hover:opacity-80">
        @if(Auth::user()->foto)
            <img src="{{ asset('storage/' . Auth::user()->foto) }}" class="w-8 h-8 rounded-full object-cover">
        @else
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold text-white" style="background-color:#9d174d;">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
        @endif
        <span>{{ Auth::user()->name }}</span>
    </a>
</nav>

    <div class="flex flex-1">
        <aside class="w-44 flex flex-col py-4 gap-2" style="background-color:#db2777; min-height: calc(100vh - 56px);">
            <a href="{{ route('petugas.dashboard') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Dashboard</a>
            {{-- Menu aktif Data Buku --}}
            <a href="{{ route('buku.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center font-bold" style="background-color:#831843;">Data Buku</a>
            <a href="{{ route('anggota.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Data Anggota</a>
            {{-- Menu Peminjaman dengan badge notifikasi --}}
            <a href="{{ route('peminjaman.index') }}"
               class="mx-3 px-4 py-2 rounded text-white text-sm text-center flex items-center justify-center gap-2"
               style="background-color:#9d174d;">
                Peminjaman
                {{-- Badge hanya muncul kalau ada yang perlu diverifikasi --}}
                @if(!empty($perluVerifikasi) && $perluVerifikasi > 0)
                    <span style="background-color:white; color:#db2777;"
                          class="text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center leading-none">
                        {{ $perluVerifikasi > 9 ? '9+' : $perluVerifikasi }}
                    </span>
                @endif
            </a>
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
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Data Buku</h1>
            </div>

            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm">
                {{ session('success') }}
            </div>
            @endif

            <div class="flex justify-between items-center mb-6">
                <a href="{{ route('buku.create') }}" class="text-white px-4 py-2 rounded text-sm font-medium" style="background-color:#db2777;">+ Tambah Buku</a>
                <form method="GET" action="{{ route('buku.index') }}" class="flex items-center gap-2">
                    <select name="kategori_id" onchange="this.form.submit()" class="border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none bg-white">
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
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr style="background-color:#fce7f3;">
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">No</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Cover</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Judul</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Pengarang</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Kategori</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Stok</th>
                            <th class="px-4 py-3 text-center font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bukus as $index => $buku)
                        <tr class="border-t border-gray-100 hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-gray-500">{{ $index + 1 }}</td>
                            <td class="px-4 py-3">
                                @if($buku->foto)
                                    <img src="{{ asset('storage/' . $buku->foto) }}" alt="{{ $buku->judul }}" class="w-10 h-14 object-cover rounded">
                                @else
                                    <div class="w-10 h-14 flex items-center justify-center rounded" style="background: linear-gradient(135deg, #fce7f3, #fbcfe8);">
                                        <span style="font-size:18px;">📚</span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3 font-medium text-gray-800">{{ $buku->judul }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $buku->pengarang }}</td>
                            <td class="px-4 py-3">
                                @if($buku->kategori)
                                <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium" style="background:#fce7f3; color:#9d174d;">
                                    {{ $buku->kategori->nama_kategori }}
                                </span>
                                @else
                                <span class="text-gray-400 text-xs">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $buku->stok }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('buku.edit', $buku->id) }}" class="text-xs px-3 py-1 rounded font-medium" style="background:#fef3c7; color:#92400e; border: 1px solid #fcd34d;">✏️ Edit</a>
                                    <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" onsubmit="return confirm('Yakin hapus buku ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs px-3 py-1 rounded font-medium" style="background:#fee2e2; color:#991b1b; border: 1px solid #fca5a5;">🗑️ Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </main>
    </div>

</body>
</html>