<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Denda</title>
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
        <a href="{{ route('peminjaman.index') }}"
            class="mx-3 px-4 py-2 rounded text-white text-sm text-center flex items-center justify-center gap-2"
            style="background-color:#9d174d;">
            Peminjaman
            @if(!empty($perluVerifikasi) && $perluVerifikasi > 0)
                <span style="background-color:white; color:#db2777;"
                    class="text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center leading-none">
                    {{ $perluVerifikasi > 9 ? '9+' : $perluVerifikasi }}
                </span>
            @endif
        </a>
        <a href="{{ route('kategori.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Kategori</a>
        <a href="{{ route('denda.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center font-bold" style="background-color:#831843;">Denda</a>
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

        {{-- Judul halaman --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Denda</h1>
        </div>

        {{-- Notifikasi sukses --}}
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm">
            {{ session('success') }}
        </div>
        @endif

        {{-- Card ketentuan denda --}}
        <div class="bg-white rounded-xl shadow p-5 mb-6 flex items-center justify-between border-l-4" style="border-left-color:#db2777;">
            <div class="flex items-center gap-4">
                <span class="text-3xl">📌</span>
                <div>
                    <p class="text-sm font-semibold text-gray-700">Ketentuan Denda</p>
                    <p class="text-sm text-gray-500 mt-0.5">
                        Denda keterlambatan =
                        <span class="font-bold text-pink-600">Rp {{ number_format($dendaPerHari, 0, ',', '.') }} / hari</span>
                    </p>
                    <p class="text-sm text-red-500 font-medium mt-0.5">Batas keterlambatan maksimal = 7 hari (1 minggu)</p>
                </div>
            </div>
            <a href="{{ route('denda.pengaturan') }}" class="text-white px-4 py-2 rounded-lg text-sm font-medium" style="background-color:#db2777;">
                ⚙️ Ubah Denda
            </a>
        </div>

        {{-- Tabel denda --}}
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <table class="w-full text-sm">
                {{-- Header tabel selalu tampil meskipun tidak ada data --}}
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
                    <tr class="border-b border-gray-100 hover:bg-pink-50 transition">
                        <td class="px-4 py-4 text-gray-500">{{ $loop->iteration }}</td>
                        <td class="px-4 py-4 font-semibold text-gray-800">{{ $item->nama_anggota }}</td>
                        <td class="px-4 py-4 text-gray-600">{{ $item->judul_buku }}</td>
                        <td class="px-4 py-4">
                            <span class="px-2 py-1 rounded-full text-xs font-bold text-white" style="background-color:#dc2626;">
                                {{ $item->hari_terlambat }} hari
                            </span>
                        </td>
                        <td class="px-4 py-4 text-gray-600">Rp {{ number_format($item->denda_per_hari, 0, ',', '.') }}</td>
                        <td class="px-4 py-4 font-bold text-red-600">Rp {{ number_format($item->total_denda, 0, ',', '.') }}</td>
                        <td class="px-4 py-4">
                            @if($item->status_bayar == 'belum_bayar')
                                <span class="px-2 py-1 rounded-full text-xs font-bold text-white" style="background-color:#dc2626;">Belum Bayar</span>
                            @else
                                <span class="px-2 py-1 rounded-full text-xs font-bold text-white" style="background-color:#16a34a;">Sudah Bayar</span>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex gap-2 items-center">
                                {{-- Tombol konfirmasi pembayaran --}}
                                @if($item->status_bayar == 'belum_bayar')
                                <form action="{{ route('denda.konfirmasi', $item->id) }}" method="POST" onsubmit="return confirm('Konfirmasi pembayaran denda ini?')">
                                    @csrf
                                    <button type="submit" class="text-white px-3 py-1 rounded-lg text-xs font-medium" style="background-color:#16a34a;">✓ Konfirmasi</button>
                                </form>
                                @else
                                    <span class="text-gray-400 text-xs">Lunas ✓</span>
                                @endif

                                {{-- Tombol cetak bukti denda --}}
                                <button
                                    type="button"
                                    class="btn-cetak text-white px-3 py-1 rounded-lg text-xs font-medium"
                                    style="background-color:#db2777;"
                                    data-nama="{{ $item->nama_anggota }}"
                                    data-judul="{{ $item->judul_buku }}"
                                    data-hari="{{ $item->hari_terlambat }}"
                                    data-per-hari="{{ $item->denda_per_hari }}"
                                    data-total="{{ $item->total_denda }}"
                                    data-status="{{ $item->status_bayar }}">
                                    🖨️ Cetak
                                </button>
                            </div>
                        </td>
                    </tr>

                    {{-- Kalau tidak ada data denda --}}
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-12 text-gray-400">
                            <div class="flex flex-col items-center gap-2">
                                <span class="text-4xl">✅</span>
                                <span class="text-sm">Tidak ada denda saat ini.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </main>
</div>

{{-- ===== MODAL CETAK ===== --}}
<div id="print-modal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:16px; width:480px; max-width:95vw; overflow:hidden; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <div id="print-area" style="padding:40px; font-family:Arial, sans-serif; color:#333;">
            <h2 style="text-align:center; color:#db2777; margin-bottom:4px; font-size:20px;">BUKTI DENDA PERPUSTAKAAN</h2>
            <p style="text-align:center; color:#888; font-size:13px; margin-bottom:20px;">Sistem Perpustakaan</p>
            <hr style="border:1px solid #db2777; margin-bottom:20px;">
            <table style="width:100%; font-size:14px; border-collapse:collapse;">
                <tr><td style="padding:6px 0; color:#555; width:45%;">Nama Anggota</td><td style="padding:6px 0;">: <strong id="p-nama"></strong></td></tr>
                <tr><td style="padding:6px 0; color:#555;">Judul Buku</td><td style="padding:6px 0;">: <strong id="p-judul"></strong></td></tr>
                <tr><td style="padding:6px 0; color:#555;">Hari Terlambat</td><td style="padding:6px 0;">: <strong id="p-hari"></strong> hari</td></tr>
                <tr><td style="padding:6px 0; color:#555;">Denda/Hari</td><td style="padding:6px 0;">: <strong id="p-per-hari"></strong></td></tr>
                <tr><td style="padding:6px 0; color:#555;">Total Denda</td><td style="padding:6px 0;">: <strong id="p-total" style="color:#dc2626;"></strong></td></tr>
                <tr><td style="padding:6px 0; color:#555;">Status</td><td style="padding:6px 0;">: <strong id="p-status"></strong></td></tr>
                <tr><td style="padding:6px 0; color:#555;">Tanggal Cetak</td><td style="padding:6px 0;">: <strong id="p-tanggal"></strong></td></tr>
            </table>
            <hr style="border:1px solid #eee; margin-top:20px; margin-bottom:16px;">
            <p style="text-align:center; font-size:12px; color:#aaa;">Terima kasih telah menggunakan layanan perpustakaan kami.</p>
        </div>
        <div style="display:flex; gap:10px; padding:0 40px 30px; justify-content:flex-end;" class="no-print">
            <button onclick="closePrintModal()" style="padding:8px 20px; border:1px solid #ddd; border-radius:8px; background:white; cursor:pointer; font-size:13px;">Tutup</button>
            <button onclick="doPrint()" style="padding:8px 20px; background:#db2777; color:white; border:none; border-radius:8px; cursor:pointer; font-size:13px; font-weight:600;">🖨️ Print</button>
        </div>
    </div>
</div>

<style>
    @media print {
        body > *:not(#print-overlay) { display: none !important; }
        #print-overlay { display: block !important; position: static !important; background: none !important; }
        #print-overlay > div { box-shadow: none !important; width: 100% !important; }
        .no-print { display: none !important; }
    }
</style>

<script>
    // Buka modal cetak saat tombol cetak diklik
    document.querySelectorAll('.btn-cetak').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const nama    = this.dataset.nama;
            const judul   = this.dataset.judul;
            const hari    = this.dataset.hari;
            const perHari = this.dataset.perHari;
            const total   = this.dataset.total;
            const status  = this.dataset.status;

            const statusLabel = status === 'belum_bayar' ? 'Belum Bayar' : 'Sudah Bayar';
            const tanggal = new Date().toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });

            document.getElementById('p-nama').textContent     = nama;
            document.getElementById('p-judul').textContent    = judul;
            document.getElementById('p-hari').textContent     = hari;
            document.getElementById('p-per-hari').textContent = 'Rp ' + parseInt(perHari).toLocaleString('id-ID');
            document.getElementById('p-total').textContent    = 'Rp ' + parseInt(total).toLocaleString('id-ID');
            document.getElementById('p-status').textContent   = statusLabel;
            document.getElementById('p-tanggal').textContent  = tanggal;

            document.getElementById('print-modal').style.display = 'flex';
        });
    });

    // Tutup modal cetak
    function closePrintModal() {
        document.getElementById('print-modal').style.display = 'none';
    }

    // Proses print
    function doPrint() {
        const printContents = document.getElementById('print-area').innerHTML;
        const original = document.body.innerHTML;
        document.body.innerHTML = `<div style="padding:50px; font-family:Arial,sans-serif;">${printContents}</div>`;
        window.print();
        document.body.innerHTML = original;
        location.reload();
    }

    // Tutup modal kalau klik di luar area modal
    document.getElementById('print-modal').addEventListener('click', function(e) {
        if (e.target === this) closePrintModal();
    });
</script>

</body>
</html>