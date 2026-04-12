<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Peminjaman</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

{{-- ===== NAVBAR ===== --}}
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

    {{-- ===== SIDEBAR ===== --}}
    <aside class="w-44 flex flex-col py-4 gap-2" style="background-color:#db2777; min-height: calc(100vh - 56px);">
        <a href="{{ route('petugas.dashboard') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Dashboard</a>
        <a href="{{ route('buku.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Data Buku</a>
        <a href="{{ route('anggota.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Data Anggota</a>
        <a href="{{ route('peminjaman.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center font-bold" style="background-color:#831843;">Peminjaman</a>
        <a href="{{ route('kategori.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Kategori</a>
        <a href="{{ route('denda.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Denda</a>
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

    {{-- ===== MAIN CONTENT ===== --}}
    <main class="flex-1 p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Peminjaman</h1>

        <div class="bg-white rounded-xl shadow p-6 max-w-lg">
            <form method="POST" action="{{ route('peminjaman.update', $peminjaman->id) }}">
                @csrf
                @method('PUT')

                {{-- ID Peminjaman (tidak bisa diedit) --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">ID Peminjaman</label>
                    <input type="text" value="{{ $peminjaman->id_peminjaman }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm bg-gray-50 text-gray-400" disabled/>
                </div>

                {{-- Nama Anggota (tidak bisa diedit) --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Anggota</label>
                    <input type="text" value="{{ $peminjaman->nama_anggota }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm bg-gray-50 text-gray-400" disabled/>
                </div>

                {{-- Buku (tidak bisa diedit) --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Buku</label>
                    <input type="text" value="{{ $peminjaman->buku->judul ?? '-' }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm bg-gray-50 text-gray-400" disabled/>
                </div>

                {{-- Tanggal Pinjam (tidak bisa diedit) --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tgl Pinjam</label>
                    <input type="text" value="{{ $peminjaman->tanggal_pinjam }}" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm bg-gray-50 text-gray-400" disabled/>
                </div>

                {{-- Batas Kembali (bisa diedit petugas, misal perpanjang peminjaman) --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Batas Kembali</label>
                    <input type="date" name="tanggal_kembali" value="{{ old('tanggal_kembali', $peminjaman->tanggal_kembali) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400"/>
                    @error('tanggal_kembali') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- ✅ Field "Tgl Kembali" dihapus karena tidak dipakai di sistem --}}

                {{-- Status (bisa diedit petugas untuk koreksi data) --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400 bg-white">
                        <option value="dipinjam" {{ $peminjaman->status == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                        <option value="dikembalikan" {{ $peminjaman->status == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                    </select>
                    @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Tombol aksi --}}
                <div class="flex gap-3 mt-6">
                    <button type="submit" class="px-6 py-2 rounded text-white text-sm font-medium" style="background-color:#16a34a;">Update</button>
                    <a href="{{ route('peminjaman.index') }}" class="px-6 py-2 rounded text-white text-sm font-medium" style="background-color:#dc2626;">Batal</a>
                </div>
            </form>
        </div>
    </main>
</div>

</body>
</html>