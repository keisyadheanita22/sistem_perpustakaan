<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Anggota</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <nav class="px-8 h-14 flex items-center" style="background-color:#db2777;">
        <span class="text-white font-bold text-lg italic">Sistem Perpustakaan</span>
    </nav>

    <div class="flex flex-1">
        <aside class="w-44 flex flex-col py-4 gap-2" style="background-color:#db2777; min-height: calc(100vh - 56px);">
            <a href="{{ route('petugas.dashboard') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Dashboard</a>
            <a href="{{ route('buku.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Data Buku</a>
            <a href="{{ route('anggota.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center font-bold" style="background-color:#831843;">Data Anggota</a>
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
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Data Anggota</h1>
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Petugas
                </div>
            </div>

            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex justify-between items-center mb-6">
                    <a href="{{ route('anggota.create') }}" class="text-white px-4 py-2 rounded text-sm font-medium" style="background-color:#db2777;">+ Tambah Anggota</a>
                    <form method="GET" action="{{ route('anggota.index') }}">
                        <div class="flex items-center border border-gray-300 rounded-lg px-3 py-2 text-sm gap-2 bg-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/></svg>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Anggota..." class="outline-none text-sm w-48">
                        </div>
                    </form>
                </div>

                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-white" style="background-color:#db2777;">
                            <th class="px-4 py-3 text-left">No</th>
                            <th class="px-4 py-3 text-left">ID Anggota</th>
                            <th class="px-4 py-3 text-left">Nama</th>
                            <th class="px-4 py-3 text-left">Email</th>
                            <th class="px-4 py-3 text-left">No Telepon</th>
                            <th class="px-4 py-3 text-left">Username</th>
                            <th class="px-4 py-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($anggota as $item)
                        <tr class="border-b hover:bg-pink-50 transition">
                            <td class="px-4 py-4">{{ $loop->iteration }}</td>
                            <td class="px-4 py-4 font-medium">{{ $item->id_anggota }}</td>
                            <td class="px-4 py-4">{{ $item->nama }}</td>
                            <td class="px-4 py-4">{{ $item->email }}</td>
                            <td class="px-4 py-4">{{ $item->no_telepon }}</td>
                            <td class="px-4 py-4">{{ $item->username }}</td>
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('anggota.edit', $item->id) }}" class="text-yellow-500 hover:text-yellow-600 font-medium text-xs">✏️ Edit</a>
                                    <span class="text-gray-300">|</span>
                                    <form action="{{ route('anggota.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus anggota ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-600 font-medium text-xs">🗑️ Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-gray-400">
                                <div class="flex flex-col items-center gap-2">
                                    <span class="text-4xl">👤</span>
                                    <span>Tidak ada data anggota.</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>

</body>
</html>