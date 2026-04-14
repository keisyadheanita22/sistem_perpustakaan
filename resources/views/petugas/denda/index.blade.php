<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Denda</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        {{-- Fungsi buka/tutup dropdown profil --}}
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
        }
        {{-- Tutup dropdown kalau klik di luar area menu --}}
        window.onclick = function(event) {
            if (!event.target.closest('#userMenu') && !event.target.closest('#print-modal')) {
                const d = document.getElementById('userDropdown');
                if (d) d.style.display = 'none';
            }
        }
    </script>
</head>
<body style="margin: 0; font-family: ui-sans-serif, system-ui; background-color: #F5F0E8;">

    {{-- ============================== --}}
    {{-- NAVBAR - Sticky bar atas       --}}
    {{-- ============================== --}}
    <nav style="background-color: #2D3A1E; height: 56px; padding: 0 32px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 100;">

        {{-- Nama aplikasi --}}
        <span style="color: #F5F0E8; font-size: 17px; font-weight: bold; font-style: italic;">Sistem Perpustakaan</span>

        {{-- Dropdown profil pengguna --}}
        <div id="userMenu" style="position: relative; cursor: pointer;" onclick="toggleDropdown()">
            <div style="display: flex; align-items: center; gap: 8px; color: #F5F0E8; font-size: 14px;">

                {{-- Foto profil atau inisial nama --}}
                @if(Auth::user()->foto)
                    <img src="{{ asset('storage/' . Auth::user()->foto) }}"
                         style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; border: 1px solid #D4A017;">
                @else
                    <div style="width: 32px; height: 32px; border-radius: 50%; background-color: #D4A017; color: #2D3A1E; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif

                <span>{{ Auth::user()->name }} ▾</span>
            </div>

            {{-- Isi dropdown: profil & logout --}}
            <div id="userDropdown" style="display: none; position: absolute; right: 0; top: 45px; width: 160px; background: white; border-radius: 8px; box-shadow: 0 10px 15px rgba(0,0,0,0.1); border: 1px solid #E8E2D4; overflow: hidden;">
                <a href="{{ route('petugas.profil') }}"
                   style="display: block; padding: 12px 16px; color: #2D3A1E; text-decoration: none; font-size: 13px; font-weight: 600; border-bottom: 1px solid #F0EBE0;">
                    Profil Saya
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            style="width: 100%; text-align: left; background: none; border: none; padding: 12px 16px; color: #9d174d; font-size: 13px; font-weight: 600; cursor: pointer;">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    {{-- Layout utama: sidebar + konten --}}
    <div style="display: flex; min-height: calc(100vh - 56px);">

        {{-- ============================== --}}
        {{-- SIDEBAR - Menu navigasi kiri   --}}
        {{-- ============================== --}}
        <aside style="width: 176px; background-color: #2D3A1E; padding: 20px 12px; display: flex; flex-direction: column; gap: 6px; flex-shrink: 0;">

            <span style="font-size: 10px; color: #7A9E5A; text-transform: uppercase; letter-spacing: 0.08em; padding: 0 8px; margin: 0 0 4px 0;">Menu Petugas</span>

            {{-- Link: Dashboard --}}
            <a href="{{ route('petugas.dashboard') }}"
               style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">
                Dashboard
            </a>

            {{-- Link: Data Buku --}}
            <a href="{{ route('buku.index') }}"
               style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">
                Data Buku
            </a>

            {{-- Link: Data Anggota --}}
            <a href="{{ route('anggota.index') }}"
               style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">
                Data Anggota
            </a>

            {{-- Link: Peminjaman + badge notifikasi kalau ada yang perlu diverifikasi --}}
            <a href="{{ route('peminjaman.index') }}"
               style="display: flex; align-items: center; justify-content: space-between; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">
                <span>Peminjaman</span>
                @if(!empty($perluVerifikasi) && $perluVerifikasi > 0)
                    <span style="background-color: #D4A017; color: #2D3A1E; font-size: 10px; font-weight: bold; border-radius: 50%; width: 18px; height: 18px; display: flex; align-items: center; justify-content: center;">
                        {{ $perluVerifikasi > 9 ? '9+' : $perluVerifikasi }}
                    </span>
                @endif
            </a>

            {{-- Link: Kategori --}}
            <a href="{{ route('kategori.index') }}"
               style="display: flex; align-items: center; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">
                Kategori
            </a>

            {{-- Link: Denda - AKTIF, kuning emas --}}
            <a href="{{ route('denda.index') }}"
               style="display: flex; align-items: center; padding: 9px 12px; border-radius: 8px; background: #D4A017; color: #2D3A1E; font-size: 13px; text-decoration: none; font-weight: 600;">
                Denda
            </a>

            {{-- Tombol logout di bagian bawah sidebar --}}
            <div style="margin-top: auto; padding-top: 16px;">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 6px; padding: 9px 12px; border-radius: 8px; background: none; border: 1px solid #4a5c2e; color: #C8DDB0; font-size: 13px; cursor: pointer;">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width: 14px; height: 14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- ============================== --}}
        {{-- KONTEN UTAMA                   --}}
        {{-- ============================== --}}
        <main style="flex: 1; padding: 32px;">

            {{-- Judul halaman --}}
            <div style="margin-bottom: 24px;">
                <h1 style="font-size: 24px; font-weight: 700; color: #2D3A1E; margin: 0;">Denda</h1>
            </div>

            {{-- Notifikasi sukses --}}
            @if(session('success'))
                <div id="flash-success"
                     style="background-color: #dcfce7; border: 1px solid #22c55e; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; display: flex; align-items: center; justify-content: space-between;">
                    <span>✅ {{ session('success') }}</span>
                    <button onclick="document.getElementById('flash-success').style.display='none'"
                            style="background: none; border: none; color: #166534; cursor: pointer; font-size: 18px;">&times;</button>
                </div>
            @endif

            {{-- Card ketentuan denda - info denda per hari + tombol ubah --}}
            <div style="background: #FFFDF8; border-radius: 12px; border: 1px solid #D4A017; box-shadow: 0 4px 10px rgba(0,0,0,0.06); padding: 16px 20px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 16px;">

                    {{-- Ikon pin ketentuan --}}
                    <div style="width: 44px; height: 44px; border-radius: 10px; background-color: #FEF3C7; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 20px;">
                        📌
                    </div>
                    <div>
                        <p style="font-size: 13px; font-weight: 700; color: #2D3A1E; margin: 0;">Ketentuan Denda</p>
                        <p style="font-size: 13px; color: #8A7E6E; margin: 4px 0 0 0;">
                            Denda keterlambatan =
                            <span style="font-weight: 700; color: #D4A017;">Rp {{ number_format($dendaPerHari, 0, ',', '.') }} / hari</span>
                        </p>
                        <p style="font-size: 12px; color: #991b1b; font-weight: 600; margin: 2px 0 0 0;">Batas keterlambatan maksimal = 7 hari (1 minggu)</p>
                    </div>
                </div>

                {{-- Tombol ubah pengaturan denda, aksen biru tua --}}
                <a href="{{ route('denda.pengaturan') }}"
                   style="display: flex; align-items: center; gap: 6px; padding: 9px 16px; background-color: #1E3A5F; color: #DBEAFE; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; flex-shrink: 0;">
                    ⚙️ Ubah Denda
                </a>
            </div>

            {{-- Tabel denda --}}
            <div style="background: #F9F9F9; border-radius: 12px; border: 1px solid #D4A017; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.08);">
                <table style="width: 100%; border-collapse: collapse; font-size: 13px;">

                    {{-- Header tabel warna hijau gelap --}}
                    <thead>
                        <tr style="background-color: #2D3A1E; border-bottom: 2px solid #D4A017; text-align: left;">
                            <th style="padding: 14px 16px; color: #F5F0E8;">No</th>
                            <th style="padding: 14px 16px; color: #F5F0E8;">Nama Anggota</th>
                            <th style="padding: 14px 16px; color: #F5F0E8;">Judul Buku</th>
                            <th style="padding: 14px 16px; color: #F5F0E8;">Terlambat</th>
                            <th style="padding: 14px 16px; color: #F5F0E8;">Denda/Hari</th>
                            <th style="padding: 14px 16px; color: #F5F0E8;">Total Denda</th>
                            <th style="padding: 14px 16px; color: #F5F0E8;">Status</th>
                            <th style="padding: 14px 16px; color: #F5F0E8; text-align: center;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        {{-- Looping data denda --}}
                        @forelse ($dendas as $item)
                        <tr style="border-bottom: 1px solid #E8E2D4; background-color: #FFFFFF; transition: background 0.15s;"
                            onmouseover="this.style.backgroundColor='#F5F0E8'"
                            onmouseout="this.style.backgroundColor='#FFFFFF'">

                            {{-- Nomor urut --}}
                            <td style="padding: 14px 16px; color: #8A7E6E;">{{ $loop->iteration }}</td>

                            {{-- Nama anggota --}}
                            <td style="padding: 14px 16px; font-weight: 600; color: #2D3A1E;">{{ $item->nama_anggota }}</td>

                            {{-- Judul buku --}}
                            <td style="padding: 14px 16px; color: #2D3A1E;">{{ $item->judul_buku }}</td>

                            {{-- Hari terlambat, badge merah --}}
                            <td style="padding: 14px 16px;">
                                <span style="background-color: #FEE2E2; color: #991b1b; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">
                                    {{ $item->hari_terlambat }} hari
                                </span>
                            </td>

                            {{-- Denda per hari --}}
                            <td style="padding: 14px 16px; color: #8A7E6E;">Rp {{ number_format($item->denda_per_hari, 0, ',', '.') }}</td>

                            {{-- Total denda, merah tebal --}}
                            <td style="padding: 14px 16px; font-weight: 700; color: #991b1b;">Rp {{ number_format($item->total_denda, 0, ',', '.') }}</td>

                            {{-- Badge status bayar --}}
                            <td style="padding: 14px 16px;">
                                @if($item->status_bayar == 'belum_bayar')
                                    <span style="background-color: #FEE2E2; color: #991b1b; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">Belum Bayar</span>
                                @else
                                    <span style="background-color: #DCFCE7; color: #166534; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">Sudah Bayar</span>
                                @endif
                            </td>

                            {{-- Tombol aksi: konfirmasi & cetak --}}
                            <td style="padding: 14px 16px;">
                                <div style="display: flex; align-items: center; gap: 8px; justify-content: center; flex-wrap: wrap;">

                                    {{-- Tombol konfirmasi pembayaran, muncul kalau belum bayar --}}
                                    @if($item->status_bayar == 'belum_bayar')
                                    <form action="{{ route('denda.konfirmasi', $item->id) }}" method="POST"
                                          onsubmit="return confirm('Konfirmasi pembayaran denda ini?')">
                                        @csrf
                                        <button type="submit"
                                                style="padding: 5px 10px; background: #DCFCE7; color: #166534; border: 1px solid #86EFAC; border-radius: 6px; font-size: 11px; font-weight: 600; cursor: pointer;">
                                            ✓ Konfirmasi
                                        </button>
                                    </form>
                                    @else
                                        {{-- Label lunas kalau sudah bayar --}}
                                        <span style="color: #8A7E6E; font-size: 11px;">Lunas ✓</span>
                                    @endif

                                    {{-- Tombol cetak bukti denda --}}
                                    <button
                                        type="button"
                                        class="btn-cetak"
                                        style="padding: 5px 10px; background: #DBEAFE; color: #1E3A5F; border: 1px solid #93C5FD; border-radius: 6px; font-size: 11px; font-weight: 600; cursor: pointer;"
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

                        {{-- Tampilan kosong kalau tidak ada denda --}}
                        @empty
                        <tr>
                            <td colspan="8" style="padding: 40px; text-align: center; color: #8A7E6E;">
                                <div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                                    <span style="font-size: 40px;">✅</span>
                                    <span style="font-style: italic;">Tidak ada denda saat ini.</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </main>
    </div>

    {{-- ============================== --}}
    {{-- MODAL CETAK BUKTI DENDA        --}}
    {{-- ============================== --}}
    <div id="print-modal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
        <div style="background: white; border-radius: 16px; width: 500px; max-width: 95vw; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.3); border: 1px solid #D4A017;">

            {{-- Header modal --}}
            <div style="background: #2D3A1E; padding: 16px 24px; display: flex; align-items: center; justify-content: space-between;">
                <span style="color: #F5F0E8; font-size: 14px; font-weight: 700;">🖨️ Bukti Denda Perpustakaan</span>
                <button onclick="closePrintModal()"
                        style="background: none; border: none; color: #C8DDB0; font-size: 20px; cursor: pointer; line-height: 1;">&times;</button>
            </div>

            {{-- Area konten yang akan dicetak --}}
            <div id="print-area" style="padding: 32px; font-family: ui-sans-serif, system-ui; color: #2D3A1E;">
                <h2 style="text-align: center; color: #2D3A1E; margin: 0 0 4px 0; font-size: 18px; font-weight: 700;">BUKTI DENDA PERPUSTAKAAN</h2>
                <p style="text-align: center; color: #8A7E6E; font-size: 12px; margin: 0 0 20px 0;">Sistem Perpustakaan</p>
                <div style="border-top: 2px solid #D4A017; margin-bottom: 20px;"></div>

                <table style="width: 100%; font-size: 13px; border-collapse: collapse;">
                    <tr><td style="padding: 7px 0; color: #8A7E6E; width: 45%;">Nama Anggota</td><td style="padding: 7px 0; font-weight: 600; color: #2D3A1E;">: <span id="p-nama"></span></td></tr>
                    <tr><td style="padding: 7px 0; color: #8A7E6E;">Judul Buku</td><td style="padding: 7px 0; font-weight: 600; color: #2D3A1E;">: <span id="p-judul"></span></td></tr>
                    <tr><td style="padding: 7px 0; color: #8A7E6E;">Hari Terlambat</td><td style="padding: 7px 0; font-weight: 600; color: #2D3A1E;">: <span id="p-hari"></span> hari</td></tr>
                    <tr><td style="padding: 7px 0; color: #8A7E6E;">Denda/Hari</td><td style="padding: 7px 0; font-weight: 600; color: #2D3A1E;">: <span id="p-per-hari"></span></td></tr>
                    <tr>
                        <td style="padding: 7px 0; color: #8A7E6E;">Total Denda</td>
                        <td style="padding: 7px 0;">: <span id="p-total" style="font-weight: 700; color: #991b1b; font-size: 14px;"></span></td>
                    </tr>
                    <tr><td style="padding: 7px 0; color: #8A7E6E;">Status</td><td style="padding: 7px 0; font-weight: 600; color: #2D3A1E;">: <span id="p-status"></span></td></tr>
                    <tr><td style="padding: 7px 0; color: #8A7E6E;">Tanggal Cetak</td><td style="padding: 7px 0; font-weight: 600; color: #2D3A1E;">: <span id="p-tanggal"></span></td></tr>
                </table>

                <div style="border-top: 1px solid #E8E2D4; margin-top: 20px; padding-top: 14px;">
                    <p style="text-align: center; font-size: 11px; color: #8A7E6E; margin: 0;">Terima kasih telah menggunakan layanan perpustakaan kami.</p>
                </div>
            </div>

            {{-- Tombol aksi modal --}}
            <div class="no-print" style="display: flex; gap: 10px; padding: 0 24px 24px; justify-content: flex-end;">
                <button onclick="closePrintModal()"
                        style="padding: 9px 20px; border: 1px solid #E8E2D4; border-radius: 8px; background: white; cursor: pointer; font-size: 13px; color: #8A7E6E; font-weight: 600;">
                    Tutup
                </button>
                <button onclick="doPrint()"
                        style="padding: 9px 20px; background: #2D3A1E; color: #F5F0E8; border: none; border-radius: 8px; cursor: pointer; font-size: 13px; font-weight: 600;">
                    🖨️ Print
                </button>
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
        // Buka modal cetak saat tombol cetak diklik, isi data dari data-attribute tombol
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

        // Proses print: ambil isi print-area, ganti body sementara, print, lalu reload
        function doPrint() {
            const printContents = document.getElementById('print-area').innerHTML;
            const original = document.body.innerHTML;
            document.body.innerHTML = `<div style="padding:50px; font-family:ui-sans-serif,system-ui;">${printContents}</div>`;
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