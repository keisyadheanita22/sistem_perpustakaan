<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Petugas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

{{-- ===================== NAVBAR ===================== --}}
<nav class="px-8 h-14 flex items-center justify-between" style="background-color:#db2777;">
    <span class="text-white font-bold text-lg italic">Sistem Perpustakaan</span>

    {{-- Avatar: tampilkan foto jika ada, jika tidak tampilkan inisial nama --}}
    <a href="{{ route('kepala.profil') }}" class="flex items-center gap-2 text-white text-sm hover:opacity-80">
        @if(Auth::user()->foto)
            <img src="{{ asset('storage/' . Auth::user()->foto) }}"
                 style="width:32px; height:32px; border-radius:50%; object-fit:cover;">
        @else
            <div style="width:32px; height:32px; border-radius:50%; background-color:#9d174d;
                        display:flex; align-items:center; justify-content:center;
                        font-size:14px; font-weight:700; color:white;">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
        @endif
        <span>{{ Auth::user()->name }}</span>
    </a>
</nav>

<div class="flex flex-1">

    {{-- ===================== SIDEBAR ===================== --}}
    {{-- Menu aktif ditandai warna lebih gelap (#831843) dan font-bold --}}
    <aside class="w-44 flex flex-col py-4 gap-2"
        style="background-color:#db2777; min-height: calc(100vh - 56px);">

        <a href="{{ route('kepala.dashboard') }}"
            class="mx-3 px-4 py-2 rounded text-white text-sm text-center {{ request()->routeIs('kepala.dashboard') ? 'font-bold' : '' }}"
            style="background-color: {{ request()->routeIs('kepala.dashboard') ? '#831843' : '#9d174d' }};">
            Dashboard
        </a>

        {{-- Menu ini aktif karena kita sedang di halaman Data Petugas --}}
        <a href="{{ route('kepala.petugas.index') }}"
            class="mx-3 px-4 py-2 rounded text-white text-sm text-center {{ request()->routeIs('kepala.petugas.*') ? 'font-bold' : '' }}"
            style="background-color: {{ request()->routeIs('kepala.petugas.*') ? '#831843' : '#9d174d' }};">
            Data Petugas
        </a>

        <a href="{{ route('kepala.katalog') }}"
            class="mx-3 px-4 py-2 rounded text-white text-sm text-center {{ request()->routeIs('kepala.katalog') ? 'font-bold' : '' }}"
            style="background-color: {{ request()->routeIs('kepala.katalog') ? '#831843' : '#9d174d' }};">
            Katalog Buku
        </a>

        <a href="{{ route('kepala.anggota.index') }}"
            class="mx-3 px-4 py-2 rounded text-white text-sm text-center {{ request()->routeIs('kepala.anggota.*') ? 'font-bold' : '' }}"
            style="background-color: {{ request()->routeIs('kepala.anggota.*') ? '#831843' : '#9d174d' }};">
            Daftar Anggota
        </a>

        <a href="{{ route('kepala.laporan') }}"
            class="mx-3 px-4 py-2 rounded text-white text-sm text-center {{ request()->routeIs('kepala.laporan') ? 'font-bold' : '' }}"
            style="background-color: {{ request()->routeIs('kepala.laporan') ? '#831843' : '#9d174d' }};">
            Laporan
        </a>

        {{-- Tombol logout di paling bawah sidebar --}}
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

    {{-- ===================== KONTEN UTAMA ===================== --}}
    <main class="flex-1 p-8">

        {{-- Header halaman: judul + tombol tambah petugas --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Data Petugas</h1>
            <a href="{{ route('kepala.petugas.create') }}"
                class="text-white px-4 py-2 rounded text-sm font-medium"
                style="background-color:#db2777;">
                + Tambah Petugas
            </a>
        </div>

        {{-- Notifikasi sukses setelah tambah / edit / hapus petugas --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- State kosong: tampil jika belum ada petugas sama sekali --}}
        @if($petugas->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 text-gray-400">
                <span class="text-5xl mb-3">👤</span>
                <span>Belum ada data petugas.</span>
            </div>
        @else

            {{-- SEARCH BAR: filter tabel nama & email secara live tanpa reload --}}
            <div class="flex justify-between items-center mb-4">
                <div class="flex items-center gap-2 border border-gray-300 rounded-lg px-3 py-2 bg-white w-64">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                    </svg>
                    <input type="text" id="searchInput" placeholder="Cari nama atau email..."
                        oninput="filterTable()"
                        class="outline-none border-0 text-sm w-full bg-transparent">
                </div>
            </div>

            {{-- Tabel data petugas --}}
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr style="background-color:#fce7f3;">
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">No</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Nama</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Email</th>
                            <th class="px-4 py-3 text-center font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @foreach ($petugas as $index => $p)
                        {{-- data-nama & data-email dipakai JS untuk mencocokkan keyword search --}}
                        <tr class="border-t border-gray-100 hover:bg-gray-50 transition"
                            data-nama="{{ strtolower($p->name) }}"
                            data-email="{{ strtolower($p->email) }}">
                            <td class="px-4 py-3 text-gray-500">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 font-medium text-gray-800">{{ $p->name }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $p->email }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center gap-2">

                                    {{-- Tombol Edit: mengarah ke halaman form edit petugas --}}
                                    <a href="{{ route('kepala.petugas.edit', $p->id) }}"
                                        class="text-xs px-3 py-1 rounded font-medium"
                                        style="background:#fce7f3; color:#9d174d; border: 1px solid #f9a8d4;">
                                        ✏️ Edit
                                    </a>

                                    {{-- Tombol Hapus: minta konfirmasi sebelum submit form DELETE --}}
                                    <form action="{{ route('kepala.petugas.destroy', $p->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin hapus petugas ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs px-3 py-1 rounded font-medium"
                                            style="background:#fee2e2; color:#991b1b; border: 1px solid #fca5a5;">
                                            🗑️ Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pesan ini muncul ketika hasil search tidak ditemukan --}}
                <div id="emptySearch" class="hidden text-center py-10 text-gray-400 text-sm">
                    Tidak ada petugas yang cocok dengan pencarian.
                </div>
            </div>
        @endif

    </main>
</div>

{{-- ===================== JAVASCRIPT: LIVE SEARCH ===================== --}}
{{-- Filter baris tabel secara client-side, cocokkan keyword dengan nama atau email --}}
<script>
    function filterTable() {
        const keyword = document.getElementById('searchInput').value.toLowerCase().trim();
        const rows    = document.querySelectorAll('#tableBody tr');
        const empty   = document.getElementById('emptySearch');
        let visible   = 0;

        rows.forEach(row => {
            // Cek apakah keyword cocok dengan nama atau email di data-attribute baris
            const match = row.dataset.nama.includes(keyword) || row.dataset.email.includes(keyword);
            row.style.display = match ? '' : 'none';
            if (match) visible++;
        });

        // Tampilkan pesan kosong jika tidak ada baris yang cocok
        empty.classList.toggle('hidden', visible > 0);
    }
</script>

</body>
</html>