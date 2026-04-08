<table>
    <thead>
        <tr>
            <th colspan="5" style="font-weight: bold; background-color: #db2777; color: #ffffff; text-align: center; font-size: 14px;">LAPORAN PEMINJAMAN</th>
        </tr>
        <tr>
            <th style="font-weight: bold; border: 1px solid #000;">No</th>
            <th style="font-weight: bold; border: 1px solid #000;">ID Peminjaman</th>
            <th style="font-weight: bold; border: 1px solid #000;">Nama Anggota</th>
            <th style="font-weight: bold; border: 1px solid #000;">Judul Buku</th>
            <th style="font-weight: bold; border: 1px solid #000;">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($peminjamans as $i => $p)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $p->id_peminjaman }}</td>
            <td>{{ $p->nama_anggota }}</td>
            <td>{{ $p->buku->judul ?? '-' }}</td>
            <td>{{ $p->status }}</td>
        </tr>
        @endforeach
    </tbody>

    <tr><td></td></tr>
    <tr><td></td></tr>

    <thead>
        <tr>
            <th colspan="4" style="font-weight: bold; background-color: #db2777; color: #ffffff; text-align: center; font-size: 14px;">LAPORAN DENDA</th>
        </tr>
        <tr>
            <th style="font-weight: bold; border: 1px solid #000;">No</th>
            <th style="font-weight: bold; border: 1px solid #000;">Nama Anggota</th>
            <th style="font-weight: bold; border: 1px solid #000;">Total Denda</th>
            <th style="font-weight: bold; border: 1px solid #000;">Status Bayar</th>
        </tr>
    </thead>
    <tbody>
        @foreach($dendas as $i => $d)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $d->nama_anggota }}</td>
            <td>Rp {{ number_format($d->total_denda, 0, ',', '.') }}</td>
            <td>{{ $d->status_bayar }}</td>
        </tr>
        @endforeach
        @if($dendas->isEmpty())
        <tr>
            <td colspan="4" style="text-align: center; font-style: italic;">Tidak ada data denda</td>
        </tr>
        @endif
    </tbody>
</table>