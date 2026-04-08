<table>
    <thead>
        <tr>
            <th colspan="5" style="font-weight: bold; background-color: #db2777; color: #ffffff; text-align: center;">LAPORAN PEMINJAMAN</th>
        </tr>
        <tr>
            <th>No</th>
            <th>ID Peminjaman</th>
            <th>Nama Anggota</th>
            <th>Buku</th>
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
            <td>{{ $p->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>