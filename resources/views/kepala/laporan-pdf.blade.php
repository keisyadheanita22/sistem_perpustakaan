<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Perpustakaan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: sans-serif; font-size: 11px; color: #2D3A1E; background: #F5F0E8; }

        /* Header laporan */
        .header { text-align: center; margin-bottom: 16px; padding-bottom: 10px; border-bottom: 2px solid #D4A017; }
        .header h1 { font-size: 16px; font-weight: 700; color: #2D3A1E; }
        .header p { font-size: 11px; color: #8A7E6E; margin-top: 2px; }

        /* Kartu section */
        .card { background: #FFFDF8; border-radius: 10px; border: 1px solid #E8E2D4; overflow: hidden; margin-bottom: 16px; }

        /* Judul section */
        .card-title { background: #2D3A1E; padding: 10px 14px; display: flex; align-items: center; gap: 6px; }
        .card-title h2 { font-size: 11px; font-weight: 700; color: #D4A017; text-transform: uppercase; letter-spacing: 0.06em; margin: 0; }

        /* Tabel */
        table { width: 100%; border-collapse: collapse; font-size: 10.5px; }
        thead tr { background: #2D3A1E; }
        thead th { padding: 9px 14px; text-align: left; color: #D4A017; font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; }
        tbody tr { border-top: 1px solid #EDE7DA; }
        tbody tr:nth-child(even) { background-color: #F5F0E8; }
        tbody td { padding: 9px 14px; color: #2D3A1E; }

        /* Badge status */
        .badge { display: inline-block; padding: 2px 8px; border-radius: 999px; font-size: 9px; font-weight: 800; text-transform: uppercase; letter-spacing: .07em; }
        .badge-kembali { background: #E8F0DC; color: #2D3A1E; }
        .badge-pinjam  { background: #DDE8F5; color: #1A2E5A; }
        .badge-pending { background: #FEF3C7; color: #92400E; }
        .badge-lunas   { background: #E8F0DC; color: #2D3A1E; }
        .badge-belum   { background: #F8D7DA; color: #8B3A3A; }

        /* Footer */
        .footer { margin-top: 16px; font-size: 10px; color: #8A7E6E; text-align: right; }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <div class="header">
        <h1>Laporan Perpustakaan</h1>
        <p>Rekap peminjaman &amp; denda &mdash; Dicetak pada {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    {{-- TABEL PEMINJAMAN --}}
    <div class="card">
        <div class="card-title">
            <span>📚</span>
            <h2>Laporan Peminjaman</h2>
        </div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID</th>
                    <th>Anggota</th>
                    <th>Buku</th>
                    <th style="text-align:center;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjamans as $i => $p)
                <tr>
                    <td style="color: #A09080;">{{ $i + 1 }}</td>
                    <td style="font-family: monospace; font-weight: 700; color: #1A2E5A;">#{{ $p->id_peminjaman }}</td>
                    <td style="font-weight: 600; text-transform: uppercase;">{{ $p->nama_anggota }}</td>
                    <td>{{ $p->buku->judul ?? '—' }}</td>
                    <td style="text-align:center;">
                        @if($p->status === 'dikembalikan')
                            <span class="badge badge-kembali">Dikembalikan</span>
                        @elseif($p->status === 'dipinjam')
                            <span class="badge badge-pinjam">Dipinjam</span>
                        @else
                            <span class="badge badge-pending">{{ $p->status }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center; padding: 20px; color: #8A7E6E;">Tidak ada data peminjaman.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- TABEL DENDA --}}
    <div class="card">
        <div class="card-title">
            <span>💰</span>
            <h2>Laporan Denda</h2>
        </div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Anggota</th>
                    <th>Total Denda</th>
                    <th style="text-align:center;">Status Bayar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dendas as $i => $d)
                <tr>
                    <td style="color: #A09080;">{{ $i + 1 }}</td>
                    <td style="font-weight: 600; text-transform: uppercase;">{{ $d->nama_anggota }}</td>
                    <td style="font-weight: 700; color: #8B3A3A;">Rp {{ number_format($d->total_denda, 0, ',', '.') }}</td>
                    <td style="text-align:center;">
                        @if($d->status_bayar === 'sudah_bayar')
                            <span class="badge badge-lunas">Sudah Bayar</span>
                        @else
                            <span class="badge badge-belum">Belum Bayar</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center; padding: 20px; color: #8A7E6E;">Tidak ada data denda.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- FOOTER --}}
    <div class="footer">Sistem Perpustakaan &mdash; {{ now()->format('d/m/Y') }}</div>

</body>
</html>