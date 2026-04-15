<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Denda</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>

        function toggleDropdown() {
            const menu = document.getElementById('dropdownMenu');
            const chevron = document.getElementById('chevronIcon');
            if (menu.style.display === 'none' || menu.style.display === '') {
                menu.style.display = 'block';
                chevron.style.transform = 'rotate(180deg)';
            } else {
                menu.style.display = 'none';
                chevron.style.transform = 'rotate(0deg)';
            }
        }

        window.onclick = function(e) {
            const wrapper = document.getElementById('profileWrapper');
            const menu = document.getElementById('dropdownMenu');
            const chevron = document.getElementById('chevronIcon');
            if (wrapper && !wrapper.contains(e.target)) {
                menu.style.display = 'none';
                chevron.style.transform = 'rotate(0deg)';
            }
        }
    </script>
    
    <style>
        @media print {
            body > *:not(#print-overlay) { display: none !important; }
            #print-overlay { display: block !important; position: static !important; background: none !important; }
            #print-overlay > div { box-shadow: none !important; width: 100% !important; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body style="margin: 0; font-family: ui-sans-serif, system-ui; background-color: #F5F0E8;">

    {{-- NAVBAR --}}
    <nav style="background-color: #2D3A1E; height: 56px; padding: 0 32px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; border-bottom: 2px solid #D4A017;">
        <span style="color: #F5F0E8; font-size: 17px; font-weight: bold; font-style: italic; letter-spacing: 0.02em;">Sistem Perpustakaan</span>

        <div id="profileWrapper" style="position: relative;">
            <button onclick="toggleDropdown()" style="display: flex; align-items: center; gap: 8px; color: #F5F0E8; font-size: 14px; cursor: pointer; background: none; border: none; padding: 6px 10px; border-radius: 8px;">
                @if(Auth::user()->foto)
                    <img src="{{ asset('storage/' . Auth::user()->foto) }}" style="width: 34px; height: 34px; border-radius: 50%; object-fit: cover; border: 2px solid #D4A017;" alt="Profile">
                @else
                    <div style="width: 34px; height: 34px; border-radius: 50%; background-color: #D4A017; color: #2D3A1E; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700; border: 2px solid #D4A017;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
                <span>{{ Auth::user()->name }}</span>
                <svg id="chevronIcon" style="width: 14px; height: 14px; transition: transform 0.2s; opacity: 0.8;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div id="dropdownMenu" style="display: none; position: absolute; top: calc(100% + 8px); right: 0; background: #FFFDF8; border: 1px solid #DDD6C8; border-radius: 12px; min-width: 180px; box-shadow: 0 8px 24px rgba(45,58,30,0.15); overflow: hidden; z-index: 100;">
                <div style="padding: 12px 16px; border-bottom: 1px solid #E8E2D4; background: #F5F0E8;">
                    <p style="margin: 0; font-size: 13px; font-weight: 600; color: #2D3A1E;">{{ Auth::user()->name }}</p>
                    <p style="margin: 1px 0 0 0; font-size: 11px; color: #8A7E6E;">Petugas Perpustakaan</p>
                </div>

                <a href="{{ route('petugas.profil') }}" style="display: flex; align-items: center; gap: 10px; padding: 10px 16px; font-size: 13px; color: #3A3020; text-decoration: none;">
                    <svg style="width: 15px; height: 15px; opacity: 0.7;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Profil Saya
                </a>

                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" style="display: flex; align-items: center; gap: 10px; padding: 10px 16px; font-size: 13px; color: #8B3A3A; cursor: pointer; background: none; border: none; width: 100%; text-align: left;">
                        <svg style="width: 15px; height: 15px; opacity: 0.7;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    {{-- Layout utama --}}
    <div style="display: flex; min-height: calc(100vh - 56px);">

        {{-- SIDEBAR --}}
        <aside style="width: 176px; background-color: #2D3A1E; padding: 20px 12px; display: flex; flex-direction: column; gap: 6px; flex-shrink: 0;">
            <span style="font-size: 10px; color: #7A9E5A; text-transform: uppercase; letter-spacing: 0.08em; padding: 0 8px; margin: 0 0 4px 0;">Menu Petugas</span>

            <a href="{{ route('petugas.dashboard') }}" style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">Dashboard</a>
            <a href="{{ route('buku.index') }}" style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">Data Buku</a>
            <a href="{{ route('anggota.index') }}" style="display: flex; align-items: center; gap: 8px; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">Data Anggota</a>

            <a href="{{ route('peminjaman.index') }}" style="display: flex; align-items: center; justify-content: space-between; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">
                <span>Peminjaman</span>
                @if(!empty($perluVerifikasi) && $perluVerifikasi > 0)
                    <span style="background-color: #D4A017; color: #2D3A1E; font-size: 10px; font-weight: bold; border-radius: 50%; width: 18px; height: 18px; display: flex; align-items: center; justify-content: center;">
                        {{ $perluVerifikasi > 9 ? '9+' : $perluVerifikasi }}
                    </span>
                @endif
            </a>

            <a href="{{ route('kategori.index') }}" style="display: flex; align-items: center; padding: 9px 12px; border-radius: 8px; color: #C8DDB0; font-size: 13px; text-decoration: none;">Kategori</a>
            <a href="{{ route('denda.index') }}" style="display: flex; align-items: center; padding: 9px 12px; border-radius: 8px; background: #D4A017; color: #2D3A1E; font-size: 13px; text-decoration: none; font-weight: 600;">Denda</a>
        </aside>

        {{-- KONTEN UTAMA --}}
        <main style="flex: 1; padding: 32px;">

            <h1 style="font-size: 24px; font-weight: 700; color: #2D3A1E; margin: 0 0 24px 0;">Denda</h1>

            {{-- Flash sukses --}}
            @if(session('success'))
                <div id="flash-success" style="background-color: #dcfce7; border: 1px solid #22c55e; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; display: flex; align-items: center; justify-content: space-between;">
                    <span>✅ {{ session('success') }}</span>
                    <button onclick="document.getElementById('flash-success').style.display='none'" style="background: none; border: none; color: #166534; cursor: pointer; font-size: 18px;">&times;</button>
                </div>
            @endif

            {{-- Card ketentuan denda --}}
            <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; background: #FFFDF8; border: 1px solid #E8E2D4; border-radius: 12px; padding: 16px 20px; margin-bottom: 20px;">
                <div>
                    <p style="font-size: 13px; font-weight: 700; color: #2D3A1E; margin: 0;">Ketentuan Denda</p>
                    <p style="font-size: 13px; color: #8A7E6E; margin: 4px 0 0 0;">
                        Keterlambatan: <span style="font-weight: 700; color: #D4A017;">Rp {{ number_format($dendaPerHari, 0, ',', '.') }} / hari</span>
                        &nbsp;·&nbsp;
                        Buku Rusak: <span style="font-weight: 700; color: #92400E;">Rp {{ number_format($dendaRusak, 0, ',', '.') }}</span>
                        &nbsp;·&nbsp;
                        Buku Hilang: <span style="font-weight: 700; color: #991b1b;">Rp {{ number_format($dendaHilang, 0, ',', '.') }}</span>
                    </p>
                    <p style="font-size: 12px; color: #991b1b; font-weight: 600; margin: 2px 0 0 0;">Batas keterlambatan maksimal = 7 hari (1 minggu)</p>
                </div>
                <a href="{{ route('denda.pengaturan') }}" style="display: flex; align-items: center; gap: 6px; padding: 9px 16px; background-color: #1E3A5F; color: #DBEAFE; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; flex-shrink: 0;">
                    ⚙️ Ubah Denda
                </a>
            </div>

            {{-- Card total keseluruhan denda (di luar tabel!) --}}
            <div style="background: #FFFDF8; border: 1px solid #E8E2D4; border-radius: 12px; padding: 16px 20px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <p style="font-size: 12px; color: #8A7E6E; margin: 0; text-transform: uppercase; letter-spacing: 0.06em; font-weight: 600;">Total Keseluruhan Denda</p>
                    <p style="font-size: 22px; font-weight: 700; color: #991b1b; margin: 4px 0 0 0;">
                        Rp {{ number_format($dendas->sum('total_denda'), 0, ',', '.') }}
                    </p>
                </div>
                <div style="width: 48px; height: 48px; border-radius: 12px; background: #FEE2E2; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    💰
                </div>
            </div>

            {{-- Tabel denda --}}
            <div style="background: #F9F9F9; border-radius: 12px; border: 1px solid #D4A017; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.08);">
                <table style="width: 100%; border-collapse: collapse; font-size: 13px;">

                    <thead>
                        <tr style="background-color: #2D3A1E; border-bottom: 2px solid #D4A017; text-align: left;">
                            <th style="padding: 14px 16px; color: #F5F0E8;">No</th>
                            <th style="padding: 14px 16px; color: #F5F0E8;">Nama Anggota</th>
                            <th style="padding: 14px 16px; color: #F5F0E8;">Judul Buku</th>
                            <th style="padding: 14px 16px; color: #F5F0E8;">Jenis</th>
                            <th style="padding: 14px 16px; color: #F5F0E8;">Terlambat</th>
                            <th style="padding: 14px 16px; color: #F5F0E8;">Denda/Hari</th>
                            <th style="padding: 14px 16px; color: #F5F0E8;">Total Denda</th>
                            <th style="padding: 14px 16px; color: #F5F0E8;">Status</th>
                            <th style="padding: 14px 16px; color: #F5F0E8; text-align: center;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($dendas as $item)
                        <tr style="border-bottom: 1px solid #E8E2D4; background-color: #FFFFFF; transition: background 0.15s;"
                            onmouseover="this.style.backgroundColor='#F5F0E8'"
                            onmouseout="this.style.backgroundColor='#FFFFFF'">

                            <td style="padding: 14px 16px; color: #8A7E6E;">{{ $loop->iteration }}</td>
                            <td style="padding: 14px 16px; font-weight: 600; color: #2D3A1E;">{{ $item->nama_anggota }}</td>
                            <td style="padding: 14px 16px; color: #2D3A1E;">{{ $item->judul_buku }}</td>

                            <td style="padding: 14px 16px;">
                                @if($item->jenis_denda === 'rusak')
                                    <span style="background: #FEF3C7; color: #92400E; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">🔧 Rusak</span>
                                @elseif($item->jenis_denda === 'hilang')
                                    <span style="background: #FEE2E2; color: #991b1b; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">❌ Hilang</span>
                                @else
                                    <span style="background: #E0F2FE; color: #075985; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">⏰ Terlambat</span>
                                @endif
                            </td>

                            <td style="padding: 14px 16px;">
                                <span style="background-color: #FEE2E2; color: #991b1b; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">
                                    {{ $item->hari_terlambat }} hari
                                </span>
                            </td>

                            <td style="padding: 14px 16px; color: #8A7E6E;">Rp {{ number_format($item->denda_per_hari, 0, ',', '.') }}</td>
                            <td style="padding: 14px 16px; font-weight: 700; color: #991b1b;">Rp {{ number_format($item->total_denda, 0, ',', '.') }}</td>

                            <td style="padding: 14px 16px;">
                                @if($item->status_bayar == 'belum_bayar')
                                    <span style="background-color: #FEE2E2; color: #991b1b; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">Belum Bayar</span>
                                @else
                                    <span style="background-color: #DCFCE7; color: #166534; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">Sudah Bayar</span>
                                @endif
                            </td>

                            <td style="padding: 14px 16px;">
                                <div style="display: flex; align-items: center; gap: 8px; justify-content: center; flex-wrap: wrap;">
                                    @if($item->status_bayar == 'belum_bayar')
                                        <form action="{{ route('denda.konfirmasi', $item->id) }}" method="POST"
                                              onsubmit="return confirm('Konfirmasi pembayaran denda ini?')">
                                            @csrf
                                            <button type="submit" style="padding: 5px 10px; background: #DCFCE7; color: #166534; border: 1px solid #86EFAC; border-radius: 6px; font-size: 11px; font-weight: 600; cursor: pointer;">
                                                ✓ Konfirmasi
                                            </button>
                                        </form>
                                    @else
                                        <span style="color: #8A7E6E; font-size: 11px;">Lunas ✓</span>
                                    @endif

                                    <button
                                        type="button"
                                        class="btn-detail"
                                        style="padding: 5px 10px; background: #DBEAFE; color: #1E3A5F; border: 1px solid #93C5FD; border-radius: 6px; font-size: 11px; font-weight: 600; cursor: pointer;"
                                        data-nama="{{ $item->nama_anggota }}"
                                        data-judul="{{ $item->judul_buku }}"
                                        data-jenis="{{ $item->jenis_denda }}"
                                        data-hari="{{ $item->hari_terlambat }}"
                                        data-per-hari="{{ $item->denda_per_hari }}"
                                        data-total="{{ $item->total_denda }}"
                                        data-status="{{ $item->status_bayar }}">
                                        🔍 Detail
                                    </button>
                                </div>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="9" style="padding: 40px; text-align: center; color: #8A7E6E;">
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

    {{-- MODAL DETAIL & CETAK DENDA --}}
    <div id="print-modal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
        <div style="background: white; border-radius: 16px; width: 500px; max-width: 95vw; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.3); border: 1px solid #D4A017;">

            <div style="background: #2D3A1E; padding: 16px 24px; display: flex; align-items: center; justify-content: space-between;">
                <span style="color: #F5F0E8; font-size: 14px; font-weight: 700;">🔍 Detail Denda</span>
                <button onclick="closePrintModal()" style="background: none; border: none; color: #C8DDB0; font-size: 20px; cursor: pointer; line-height: 1;">&times;</button>
            </div>

            <div id="print-area" style="padding: 32px; font-family: ui-sans-serif, system-ui; color: #2D3A1E;">
                <h2 style="text-align: center; color: #2D3A1E; margin: 0 0 4px 0; font-size: 18px; font-weight: 700;">BUKTI DENDA PERPUSTAKAAN</h2>
                <p style="text-align: center; color: #8A7E6E; font-size: 12px; margin: 0 0 20px 0;">Sistem Perpustakaan</p>
                <div style="border-top: 2px solid #D4A017; margin-bottom: 20px;"></div>

                <table style="width: 100%; font-size: 13px; border-collapse: collapse;">
                    <tr><td style="padding: 7px 0; color: #8A7E6E; width: 45%;">Nama Anggota</td><td style="padding: 7px 0; font-weight: 600; color: #2D3A1E;">: <span id="p-nama"></span></td></tr>
                    <tr><td style="padding: 7px 0; color: #8A7E6E;">Judul Buku</td><td style="padding: 7px 0; font-weight: 600; color: #2D3A1E;">: <span id="p-judul"></span></td></tr>
                    <tr><td style="padding: 7px 0; color: #8A7E6E;">Jenis Denda</td><td style="padding: 7px 0; font-weight: 600; color: #2D3A1E;">: <span id="p-jenis"></span></td></tr>
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

            <div class="no-print" style="display: flex; gap: 10px; padding: 0 24px 24px; justify-content: flex-end;">
                <button onclick="closePrintModal()" style="padding: 9px 20px; border: 1px solid #E8E2D4; border-radius: 8px; background: white; cursor: pointer; font-size: 13px; color: #8A7E6E; font-weight: 600;">Tutup</button>
                <button onclick="doPrint()" style="padding: 9px 20px; background: #2D3A1E; color: #F5F0E8; border: none; border-radius: 8px; cursor: pointer; font-size: 13px; font-weight: 600;">🖨️ Print</button>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.btn-detail').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const nama    = this.dataset.nama;
                const judul   = this.dataset.judul;
                const jenis   = this.dataset.jenis;
                const hari    = this.dataset.hari;
                const perHari = this.dataset.perHari;
                const total   = this.dataset.total;
                const status  = this.dataset.status;

                const jenisLabel  = jenis === 'rusak' ? '🔧 Rusak'
                                  : jenis === 'hilang' ? '❌ Hilang'
                                  : '⏰ Terlambat';
                const statusLabel = status === 'belum_bayar' ? 'Belum Bayar' : 'Sudah Bayar';
                const tanggal     = new Date().toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });

                document.getElementById('p-nama').textContent     = nama;
                document.getElementById('p-judul').textContent    = judul;
                document.getElementById('p-jenis').textContent    = jenisLabel;
                document.getElementById('p-hari').textContent     = hari;
                document.getElementById('p-per-hari').textContent = 'Rp ' + parseInt(perHari).toLocaleString('id-ID');
                document.getElementById('p-total').textContent    = 'Rp ' + parseInt(total).toLocaleString('id-ID');
                document.getElementById('p-status').textContent   = statusLabel;
                document.getElementById('p-tanggal').textContent  = tanggal;

                document.getElementById('print-modal').style.display = 'flex';
            });
        });

        function closePrintModal() {
            document.getElementById('print-modal').style.display = 'none';
        }

        function doPrint() {
            const printContents = document.getElementById('print-area').innerHTML;
            const original = document.body.innerHTML;
            document.body.innerHTML = `<div style="padding:50px; font-family:ui-sans-serif,system-ui;">${printContents}</div>`;
            window.print();
            document.body.innerHTML = original;
            location.reload();
        }

        document.getElementById('print-modal').addEventListener('click', function(e) {
            if (e.target === this) closePrintModal();
        });
    </script>

</body>
</html>