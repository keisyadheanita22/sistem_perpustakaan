<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; }
        h2 { color: #db2777; }
        h3 { color: #9d174d; margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th { background-color: #db2777; color: white; padding: 6px 8px; text-align: left; }
        td { padding: 5px 8px; border-bottom: 1px solid #f3f4f6; }
        tr:nth-child(even) { background: #fdf2f8; }
    </style>
</head>
<body>
    <h2>Laporan Perpustakaan Digital</h2>

    <h3>Laporan Peminjaman</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Peminjaman</th>
                <th>Nama Anggota</th>
                <th>Buku</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjamans as $i => $p)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $p->id_peminjaman }}</td>
                <td>{{ $p->nama_anggota }}</td>
                <td>{{ $p->buku->judul ?? '-' }}</td>
                <td>{{ $p->tanggal_pinjam }}</td>
                <td>{{ $p->tanggal_kembali ?? '-' }}</td>
                <td>{{ ucfirst($p->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Laporan Denda</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Anggota</th>
                <th>Judul Buku</th>
                <th>Hari Terlambat</th>
                <th>Denda/Hari</th>
                <th>Total Denda</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dendas as $i => $d)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $d->nama_anggota }}</td>
                <td>{{ $d->judul_buku }}</td>
                <td>{{ $d->hari_terlambat }} hari</td>
                <td>Rp {{ number_format($d->denda_per_hari, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($d->total_denda, 0, ',', '.') }}</td>
                <td>{{ ucfirst($d->status_bayar) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>