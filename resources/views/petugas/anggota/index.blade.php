<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Anggota</title>
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

            {{-- Menu Data Buku --}}
            <a href="{{ route('buku.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Data Buku</a>

            {{-- Menu Data Anggota (aktif/highlight) --}}
            <a href="{{ route('anggota.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center font-bold" style="background-color:#831843;">Data Anggota</a>

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

        {{-- KONTEN UTAMA --}}
        <main class="flex-1 p-8">

            {{-- JUDUL HALAMAN --}}
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Data Anggota</h1>
            </div>

            {{-- NOTIFIKASI SUKSES: Muncul setelah berhasil hapus anggota --}}
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white rounded-xl shadow p-6">

                {{-- FORM PENCARIAN: Cari anggota berdasarkan nama atau email --}}
                <div class="flex justify-end items-center mb-6">
                    <form method="GET" action="{{ route('anggota.index') }}">
                        <div class="flex items-center border border-gray-300 rounded-lg px-3 py-2 text-sm gap-2 bg-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/></svg>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Anggota..." class="outline-none text-sm w-48">
                        </div>
                    </form>
                </div>

                {{-- TABEL DATA ANGGOTA: Menampilkan daftar anggota yang sudah registrasi --}}
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

                            {{-- ID anggota otomatis (AG001, AG002, dst) --}}
                            <td class="px-4 py-4 font-medium">{{ $item->id_anggota ?? '-' }}</td>

                            {{-- Nama lengkap anggota --}}
                            <td class="px-4 py-4">{{ $item->name }}</td>

                            {{-- Email anggota --}}
                            <td class="px-4 py-4">{{ $item->email }}</td>

                            {{-- No telepon anggota --}}
                            <td class="px-4 py-4">{{ $item->no_telepon ?? '-' }}</td>

                            {{-- Username anggota --}}
                            <td class="px-4 py-4">{{ $item->username ?? '-' }}</td>

                            {{-- Tombol hapus anggota dengan konfirmasi --}}
                            <td class="px-4 py-4">
                                <form action="{{ route('anggota.destroy', $item->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin hapus anggota {{ $item->name }}?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600 font-medium text-xs">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        {{-- Tampilan jika tidak ada data anggota --}}
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