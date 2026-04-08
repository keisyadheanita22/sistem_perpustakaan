<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Denda Saya</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- NAVBAR --}}
    <nav class="px-8 h-14 flex items-center justify-between" style="background-color:#db2777;">
        <span class="text-white font-bold text-lg italic">Sistem Perpustakaan</span>

        {{-- LINK KE PROFIL DENGAN FOTO --}}
        <a href="{{ route('anggota.profil') }}" class="flex items-center gap-2 text-white text-sm hover:opacity-80">
            @if(Auth::user()->foto)
                <img src="{{ asset('storage/' . Auth::user()->foto) }}" 
                     class="w-8 h-8 rounded-full object-cover border border-pink-300" 
                     alt="Profile">
            @else
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold text-white"
                    style="background-color:#9d174d;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            @endif
            <span>{{ Auth::user()->name }}</span>
        </a>
    </nav>

    <div class="flex flex-1">

        {{-- SIDEBAR --}}
        <aside class="w-44 flex flex-col py-4 gap-2" style="background-color:#db2777; min-height: calc(100vh - 56px);">
            <a href="{{ route('anggota.dashboard') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Dashboard</a>
            <a href="{{ route('katalog.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Katalog Buku</a>
            <a href="{{ route('peminjaman.saya') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Peminjaman Saya</a>
            <a href="{{ route('denda.saya') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center font-bold" style="background-color:#831843;">Denda Saya</a>

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
                <h1 class="text-2xl font-bold text-gray-800">Denda Saya</h1>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-xl shadow p-6">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr style="background-color:#db2777;" class="text-white">
                            <th class="px-4 py-3">No</th>
                            <th class="px-4 py-3">Buku</th>
                            <th class="px-4 py-3">Hari Terlambat</th>
                            <th class="px-4 py-3">Denda/Hari</th>
                            <th class="px-4 py-3">Total Denda</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dendas as $index => $d)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $index + 1 }}</td>
                            <td class="px-4 py-3">{{ $d->judul_buku }}</td>
                            <td class="px-4 py-3">{{ $d->hari_terlambat }} hari</td>
                            <td class="px-4 py-3">Rp {{ number_format($d->denda_per_hari, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 font-bold text-red-500">Rp {{ number_format($d->total_denda, 0, ',', '.') }}</td>
                            <td class="px-4 py-3">
                                @if($d->status_bayar == 'belum_bayar')
                                    <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs">Belum Bayar</span>
                                @else
                                    <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs">Sudah Bayar</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-400 py-6">Tidak ada denda 🎉</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </main>
    </div>

</body>
</html>