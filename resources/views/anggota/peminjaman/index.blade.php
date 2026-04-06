<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Saya</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- NAVBAR: Menampilkan nama sistem dan inisial user yang bisa diklik ke halaman profil --}}
    <nav class="px-8 h-14 flex items-center justify-between" style="background-color:#db2777;">
        <span class="text-white font-bold text-lg italic">Sistem Perpustakaan</span>

        {{-- Inisial huruf pertama nama user dalam lingkaran, klik untuk ke halaman profil --}}
        <a href="{{ route('anggota.profil') }}" class="flex items-center gap-2 text-white text-sm hover:opacity-80">
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold text-white"
                style="background-color:#9d174d;">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <span>{{ Auth::user()->name }}</span>
        </a>
    </nav>

    <div class="flex flex-1">

        {{-- SIDEBAR: Menu navigasi utama untuk anggota --}}
        <aside class="w-44 flex flex-col py-4 gap-2" style="background-color:#db2777; min-height: calc(100vh - 56px);">

            {{-- Menu Dashboard --}}
            <a href="{{ route('anggota.dashboard') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Dashboard</a>

            {{-- Menu Katalog Buku --}}
            <a href="{{ route('katalog.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Katalog Buku</a>

            {{-- Menu Peminjaman Saya (aktif/highlight) --}}
            <a href="{{ route('peminjaman.saya') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center font-bold" style="background-color:#831843;">Peminjaman Saya</a>

            {{-- Menu Denda Saya --}}
            <a href="{{ route('denda.saya') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Denda Saya</a>

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
                <h1 class="text-2xl font-bold text-gray-800">Peminjaman Saya</h1>
            </div>

            {{-- NOTIFIKASI SUKSES --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- NOTIFIKASI ERROR --}}
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            {{-- TABEL PEMINJAMAN: Menampilkan daftar peminjaman milik anggota yang sedang login --}}
            <div class="bg-white rounded-xl shadow p-6">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="text-white" style="background-color:#db2777;">
                            <th class="px-4 py-3">No</th>
                            <th class="px-4 py-3">ID Pinjam</th>
                            <th class="px-4 py-3">Buku</th>
                            <th class="px-4 py-3">Tanggal Pinjam</th>
                            <th class="px-4 py-3">Batas Kembali</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjamans as $index => $p)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $index + 1 }}</td>

                            {{-- ID peminjaman --}}
                            <td class="px-4 py-3 font-bold">{{ $p->id_peminjaman }}</td>

                            {{-- Judul buku yang dipinjam --}}
                            <td class="px-4 py-3">{{ $p->buku->judul ?? '-' }}</td>

                            {{-- Tanggal pinjam --}}
                            <td class="px-4 py-3">{{ $p->tanggal_pinjam }}</td>

                            {{-- Batas tanggal pengembalian --}}
                            <td class="px-4 py-3">{{ $p->tanggal_kembali }}</td>

                            {{-- Badge status peminjaman --}}
                            <td class="px-4 py-3">
                                @if($p->status == 'menunggu')
                                    {{-- Kuning: menunggu verifikasi pinjam dari petugas --}}
                                    <span style="background:#f59e0b; color:white; padding:2px 10px; border-radius:999px; font-size:12px;">Menunggu</span>

                                @elseif($p->status == 'dipinjam')
                                    {{-- Merah: buku sedang dipinjam --}}
                                    <span style="background:#ef4444; color:white; padding:2px 10px; border-radius:999px; font-size:12px;">Dipinjam</span>

                                @elseif($p->status == 'mengembalikan')
                                    {{-- Ungu: anggota sudah klik kembalikan, tunggu verifikasi petugas --}}
                                    <span style="background:#8b5cf6; color:white; padding:2px 10px; border-radius:999px; font-size:12px;">Menunggu Verifikasi</span>

                                @else
                                    {{-- Hijau: sudah dikembalikan dan diverifikasi petugas --}}
                                    <span style="background:#22c55e; color:white; padding:2px 10px; border-radius:999px; font-size:12px;">Dikembalikan</span>
                                @endif
                            </td>

                            {{-- Tombol aksi berdasarkan status peminjaman --}}
                            <td class="px-4 py-3">
                                @if($p->status == 'menunggu')
                                    {{-- Anggota bisa batalkan selama masih menunggu verifikasi pinjam --}}
                                    <form method="POST" action="{{ route('peminjaman.batalkan', $p->id) }}">
                                        @csrf
                                        <button type="submit"
                                            style="background:#6b7280; color:white; padding:4px 12px; border-radius:6px; font-size:12px;"
                                            onclick="return confirm('Batalkan peminjaman ini?')">
                                            Batalkan
                                        </button>
                                    </form>

                                @elseif($p->status == 'dipinjam')
                                    {{-- Anggota klik kembalikan -> status jadi 'mengembalikan', tunggu verifikasi petugas --}}
                                    <form method="POST" action="{{ route('peminjaman.kembalikan', $p->id) }}">
                                        @csrf
                                        <button type="submit"
                                            style="background:#db2777; color:white; padding:4px 12px; border-radius:6px; font-size:12px;"
                                            onclick="return confirm('Kembalikan buku ini? Pengembalian akan diverifikasi oleh petugas.')">
                                            Kembalikan
                                        </button>
                                    </form>

                                @elseif($p->status == 'mengembalikan')
                                    {{-- Tidak ada tombol, tinggal tunggu petugas verifikasi --}}
                                    <span style="color:#8b5cf6; font-size:12px; font-style:italic;">Menunggu verifikasi petugas...</span>

                                @else
                                    {{-- Peminjaman sudah selesai --}}
                                    <span style="color:#9ca3af; font-size:12px;">Selesai</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        {{-- Tampilan jika belum ada peminjaman --}}
                        <tr>
                            <td colspan="7" class="text-center text-gray-400 py-6">Belum ada peminjaman</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>

</body>
</html>