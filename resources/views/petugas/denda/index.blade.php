<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Denda</title>
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
 
        <main class="flex-1 p-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Denda</h1>
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
 
            {{-- Info denda --}}
            <div class="bg-white rounded-xl shadow p-4 mb-6 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">📌</span>
                    <div>
                        <p class="text-sm font-semibold text-gray-700">Ketentuan Denda</p>
                      <p class="text-sm text-gray-500">
    Denda keterlambatan = 
    <span class="font-bold text-pink-600">
        Rp {{ number_format($dendaPerHari, 0, ',', '.') }} / hari
    </span>
</p>

<p class="text-sm text-red-500 font-medium">
    Batas keterlambatan maksimal = 7 hari (1 minggu)
</p>
                    </div>
                </div>
                <a href="{{ route('denda.pengaturan') }}" class="text-white px-4 py-2 rounded text-sm font-medium" style="background-color:#db2777;">
                    ⚙️ Ubah Denda
                </a>
            </div>
 
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-white" style="background-color:#db2777;">
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">Nama Anggota</th>
                        <th class="px-4 py-3 text-left">Judul Buku</th>
                        <th class="px-4 py-3 text-left">Terlambat</th>
                        <th class="px-4 py-3 text-left">Denda/Hari</th>
                        <th class="px-4 py-3 text-left">Total Denda</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dendas as $item)
                    <tr class="border-b hover:bg-pink-50 transition">
                        <td class="px-4 py-4">{{ $loop->iteration }}</td>
                        <td class="px-4 py-4 font-medium">{{ $item->nama_anggota }}</td>
                        <td class="px-4 py-4">{{ $item->judul_buku }}</td>
                        <td class="px-4 py-4">
                            <span class="px-2 py-1 rounded-full text-xs font-medium text-white" style="background-color:#dc2626;">
                                {{ $item->hari_terlambat }} hari
                            </span>
                        </td>
                        <td class="px-4 py-4">Rp {{ number_format($item->denda_per_hari, 0, ',', '.') }}</td>
                        <td class="px-4 py-4 font-bold text-red-600">Rp {{ number_format($item->total_denda, 0, ',', '.') }}</td>
                        <td class="px-4 py-4">
                            @if($item->status_bayar == 'belum_bayar')
                                <span class="px-2 py-1 rounded-full text-xs font-medium text-white" style="background-color:#dc2626;">Belum Bayar</span>
                            @else
                                <span class="px-2 py-1 rounded-full text-xs font-medium text-white" style="background-color:#16a34a;">Sudah Bayar</span>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex gap-2 items-center">
                                @if($item->status_bayar == 'belum_bayar')
                                <form action="{{ route('denda.konfirmasi', $item->id) }}" method="POST" onsubmit="return confirm('Konfirmasi pembayaran denda ini?')">
                                    @csrf
                                    <button type="submit" class="text-white px-3 py-1 rounded text-xs font-medium" style="background-color:#16a34a;">
                                        ✓ Konfirmasi
                                    </button>
                                </form>
                                @else
                                    <span class="text-gray-400 text-xs">Lunas ✓</span>
                                @endif
 
                                {{-- Tombol Cetak --}}
                                <button
                                    onclick="cetakDenda('{{ addslashes($item->nama_anggota) }}', '{{ addslashes($item->judul_buku) }}', {{ $item->hari_terlambat }}, {{ $item->denda_per_hari }}, {{ $item->total_denda }}, '{{ $item->status_bayar }}')"
                                    class="text-white px-3 py-1 rounded text-xs font-medium"
                                    style="background-color:#db2777;">
                                    🖨️ Cetak
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-8 text-gray-400">
                            <div class="flex flex-col items-center gap-2">
                                <span class="text-4xl">✅</span>
                                <span>Tidak ada denda.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </main>
    </div>
 
    <script>
    function cetakDenda(nama, judul, hari, dendaPerHari, total, status) {
        const statusLabel = status === 'belum_bayar' ? 'Belum Bayar' : 'Sudah Bayar';
        const statusColor = status === 'belum_bayar' ? '#dc2626' : '#16a34a';
        const tanggal = new Date().toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
 
        const win = window.open('', '_blank');
        win.document.write(`
            <!DOCTYPE html>
            <html lang="id">
            <head>
                <meta charset="UTF-8">
                <title>Bukti Denda - ${nama}</title>
                <style>
                    body { font-family: Arial, sans-serif; padding: 50px; color: #333; }
                    h2 { text-align: center; color: #db2777; margin-bottom: 4px; }
                    p.sub { text-align: center; color: #888; font-size: 13px; margin-bottom: 30px; }
                    hr { border: 1px solid #db2777; margin-bottom: 24px; }
                    table { width: 100%; border-collapse: collapse; }
                    td { padding: 10px 14px; border: 1px solid #e5e7eb; font-size: 14px; }
                    td:first-child { background: #fdf2f8; font-weight: bold; width: 40%; }
                    .status { display: inline-block; padding: 4px 12px; border-radius: 999px; color: white; font-size: 13px; background-color: ${statusColor}; }
                    .total { color: #dc2626; font-weight: bold; font-size: 15px; }
                    .footer { text-align: center; margin-top: 40px; font-size: 12px; color: #aaa; }
                    @media print { button { display: none; } }
                </style>
            </head>
            <body>
                <h2>Perpustakaan Digital</h2>
                <p class="sub">Bukti Denda Keterlambatan Pengembalian Buku</p>
                <hr>
                <table>
                    <tr><td>Nama Anggota</td><td>${nama}</td></tr>
                    <tr><td>Judul Buku</td><td>${judul}</td></tr>
                    <tr><td>Hari Terlambat</td><td>${hari} hari</td></tr>
                    <tr><td>Denda / Hari</td><td>Rp ${Number(dendaPerHari).toLocaleString('id-ID')}</td></tr>
                    <tr><td>Total Denda</td><td class="total">Rp ${Number(total).toLocaleString('id-ID')}</td></tr>
                    <tr><td>Status</td><td><span class="status">${statusLabel}</span></td></tr>
                </table>
                <div class="footer">Dicetak pada: ${tanggal}</div>
                <br>
                <div style="text-align:center;">
                    <button onclick="window.print()" style="background:#db2777;color:white;border:none;padding:10px 28px;border-radius:6px;font-size:14px;cursor:pointer;">
                        🖨️ Print
                    </button>
                </div>
            </body>
            </html>
        `);
        win.document.close();
    }
    </script>
 
</body>
</html>