<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Perpustakaan</title>
</head>

<body style="font-family:sans-serif;font-size:11px;color:#2D3A1E;background:#F5F0E8;">

<!-- =========================
     HEADER LAPORAN
========================= -->
<div style="text-align:center;margin-bottom:16px;padding-bottom:10px;border-bottom:2px solid #D4A017;">

    <h1 style="font-size:16px;font-weight:700;color:#2D3A1E;">
        Laporan Perpustakaan
    </h1>

    <p style="font-size:11px;color:#8A7E6E;margin-top:2px;">
        Rekap peminjaman & denda — Dicetak pada {{ now()->format('d/m/Y H:i') }}
    </p>

</div>



<!-- =========================
     TABEL PEMINJAMAN
========================= -->
<div style="background:#FFFDF8;border-radius:10px;border:1px solid #E8E2D4;margin-bottom:16px;overflow:hidden;">

    <!-- Judul Section -->
    <div style="background:#2D3A1E;padding:10px 14px;">
        <h2 style="font-size:11px;font-weight:700;color:#D4A017;text-transform:uppercase;">
            Laporan Peminjaman
        </h2>
    </div>

    <!-- Tabel Peminjaman -->
    <table style="width:100%;border-collapse:collapse;font-size:10.5px;table-layout:fixed;">

        <!-- Lebar Kolom Peminjaman -->
        <colgroup>
            <col style="width:5%">
            <col style="width:10%">
            <col style="width:25%">
            <col style="width:35%">
            <col style="width:25%">
        </colgroup>

        <!-- Header Tabel Peminjaman -->
        <thead>
            <tr style="background:#2D3A1E;color:#D4A017;">
                <th style="padding:9px 14px;text-align:center;">No</th>
                <th style="padding:9px 14px;text-align:center;">ID</th>
                <th style="padding:9px 14px;text-align:left;">Anggota</th>
                <th style="padding:9px 14px;text-align:left;">Buku</th>
                <th style="padding:9px 14px;text-align:center;">Status</th>
            </tr>
        </thead>

        <!-- Data Peminjaman -->
        <tbody>

            @forelse($peminjamans as $i => $p)
            <tr style="border-top:1px solid #EDE7DA;">

                <!-- Nomor Urut -->
                <td style="padding:9px 14px;color:#A09080;text-align:center;">
                    {{ $i+1 }}
                </td>

                <!-- ID Peminjaman -->
                <td style="padding:9px 14px;font-family:monospace;font-weight:700;color:#1A2E5A;text-align:center;">
                    #{{ $p->id_peminjaman }}
                </td>

                <!-- Nama Anggota -->
                <td style="padding:9px 14px;font-weight:600;text-transform:uppercase;">
                    {{ $p->nama_anggota }}
                </td>

                <!-- Judul Buku -->
                <td style="padding:9px 14px;">
                    {{ $p->buku->judul ?? '-' }}
                </td>

                <!-- Status Peminjaman -->
                <td style="padding:9px 14px;text-align:center;">

                    @if($p->status == 'dikembalikan')
                        <span style="background:#E8F0DC;color:#2D3A1E;padding:2px 8px;border-radius:999px;font-size:9px;font-weight:700;">
                            DIKEMBALIKAN
                        </span>

                    @elseif($p->status == 'dipinjam')
                        <span style="background:#DDE8F5;color:#1A2E5A;padding:2px 8px;border-radius:999px;font-size:9px;font-weight:700;">
                            DIPINJAM
                        </span>

                    @else
                        <span style="background:#FEF3C7;color:#92400E;padding:2px 8px;border-radius:999px;font-size:9px;font-weight:700;">
                            {{ $p->status }}
                        </span>
                    @endif

                </td>
            </tr>

            @empty
            <tr>
                <td colspan="5" style="text-align:center;padding:20px;color:#8A7E6E;">
                    Tidak ada data peminjaman
                </td>
            </tr>
            @endforelse

        </tbody>
    </table>

</div>



<!-- =========================
     TABEL DENDA
========================= -->
<div style="background:#FFFDF8;border-radius:10px;border:1px solid #E8E2D4;margin-bottom:16px;overflow:hidden;">

    <!-- Judul Section -->
    <div style="background:#2D3A1E;padding:10px 14px;">
        <h2 style="font-size:11px;font-weight:700;color:#D4A017;text-transform:uppercase;">
            Laporan Denda
        </h2>
    </div>

    <!-- Tabel Denda -->
    <table style="width:100%;border-collapse:collapse;font-size:10.5px;table-layout:fixed;">

        <!-- Lebar Kolom Denda -->
        <colgroup>
            <col style="width:5%">
            <col style="width:25%">
            <col style="width:20%">
            <col style="width:20%">
            <col style="width:30%">
        </colgroup>

        <!-- Header Tabel Denda -->
        <thead>
            <tr style="background:#2D3A1E;color:#D4A017;">
                <th style="padding:9px 14px;text-align:center;">No</th>
                <th style="padding:9px 14px;text-align:left;">Anggota</th>
                <th style="padding:9px 14px;text-align:center;">Jenis</th>
                <th style="padding:9px 14px;text-align:center;">Total Denda</th>
                <th style="padding:9px 14px;text-align:center;">Status Bayar</th>
            </tr>
        </thead>

        <!-- Data Denda -->
        <tbody>

            @forelse($dendas as $i => $d)
            <tr style="border-top:1px solid #EDE7DA;">

                <!-- Nomor Urut -->
                <td style="padding:9px 14px;color:#A09080;text-align:center;">
                    {{ $i+1 }}
                </td>

                <!-- Nama Anggota -->
                <td style="padding:9px 14px;font-weight:600;text-transform:uppercase;">
                    {{ $d->nama_anggota }}
                </td>

                <!-- Jenis Denda -->
                <td style="padding:9px 14px;text-align:center;">
                    @php $jenis = strtolower(trim($d->jenis_denda)); @endphp

                    @if($jenis == 'rusak')
                        <span style="background:#FEF9C3;color:#854D0E;padding:2px 8px;border-radius:999px;font-size:9px;font-weight:700;">
                            RUSAK
                        </span>

                    @elseif($jenis == 'hilang')
                        <span style="background:#FEE2E2;color:#7F1D1D;padding:2px 8px;border-radius:999px;font-size:9px;font-weight:700;">
                            HILANG
                        </span>

                    @else
                        <span style="background:#EDE9FE;color:#5B21B6;padding:2px 8px;border-radius:999px;font-size:9px;font-weight:700;">
                            TERLAMBAT
                        </span>
                    @endif
                </td>

                <!-- Total Denda -->
                <td style="padding:9px 14px;font-weight:700;color:#8B3A3A;text-align:center;">
                    Rp {{ number_format($d->total_denda,0,',','.') }}
                </td>

                <!-- Status Pembayaran Denda -->
                <td style="padding:9px 14px;text-align:center;">

                    @if($d->status_bayar == 'sudah_bayar')
                        <span style="background:#E8F0DC;color:#2D3A1E;padding:2px 8px;border-radius:999px;font-size:9px;font-weight:700;">
                            SUDAH BAYAR
                        </span>

                    @else
                        <span style="background:#F8D7DA;color:#8B3A3A;padding:2px 8px;border-radius:999px;font-size:9px;font-weight:700;">
                            BELUM BAYAR
                        </span>
                    @endif

                </td>

            </tr>

            @empty
            <tr>
                <td colspan="5" style="text-align:center;padding:20px;color:#8A7E6E;">
                    Tidak ada data denda
                </td>
            </tr>
            @endforelse

        </tbody>
    </table>

</div>
<!-- =========================
     FOOTER
========================= -->
<div style="text-align:right;font-size:10px;color:#8A7E6E;">
    Sistem Perpustakaan — {{ now()->format('d/m/Y') }}
</div>


</body>
</html>