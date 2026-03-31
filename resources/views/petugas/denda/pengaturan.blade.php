<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Denda</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <nav class="px-8 h-14 flex items-center" style="background-color:#db2777;">
        <span class="text-white font-bold text-lg italic">Perpustakaan Digital</span>
    </nav>

    <div class="flex flex-1">
        <aside class="w-44 flex flex-col py-4 gap-2" style="background-color:#db2777; min-height: calc(100vh - 56px);">
            <a href="{{ route('petugas.dashboard') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Dashboard</a>
            <a href="{{ route('buku.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Data Buku</a>
            <a href="{{ route('anggota.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Data Anggota</a>
            <a href="{{ route('peminjaman.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Peminjaman</a>
            <a href="{{ route('kategori.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Kategori</a>
            <a href="{{ route('denda.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center font-bold" style="background-color:#831843;">Denda</a>
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

        <main class="flex-1 flex items-start justify-center p-8">
            <div class="w-full max-w-md">
                <div class="rounded-xl overflow-hidden shadow-lg">
                    <div class="px-6 py-3 text-white text-sm font-semibold" style="background-color:#db2777;">
                        ⚙️ Pengaturan Denda
                    </div>
                    <div class="bg-white px-8 py-6">

                        @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm">
                            {{ session('success') }}
                        </div>
                        @endif

                        <p class="text-sm text-gray-500 mb-6">Atur nominal denda keterlambatan per hari. Perubahan akan berlaku untuk denda yang baru dibuat.</p>

                        <form action="{{ route('denda.updatePengaturan') }}" method="POST">
                            @csrf

                            <div class="mb-6 text-center">
                                <label class="block text-sm text-gray-600 mb-1">Denda Per Hari (Rp)</label>
                                <input type="number" name="nilai" value="{{ $pengaturan->nilai ?? 2000 }}" min="0"
                                    class="border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400 w-64">
                                @error('nilai') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="flex justify-center gap-3">
                                <button type="submit" class="text-white px-8 py-2 rounded text-sm font-medium" style="background-color:#22c55e;">Simpan</button>
                                <a href="{{ route('denda.index') }}" class="text-white px-8 py-2 rounded text-sm font-medium" style="background-color:#ef4444;">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>