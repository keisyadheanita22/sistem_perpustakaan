<table>
    <thead>
        <tr>
            <th colspan="4" style="font-weight: bold; background-color: #db2777; color: #ffffff; text-align: center;">LAPORAN DENDA</th>
        </tr>
        <tr>
            <th>No</th>
            <th>Nama Anggota</th>
            <th>Total Denda</th>
            <th>Status Bayar</th>
        </tr>
    </thead>
    <tbody>
        @foreach($dendas as $i => $d)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $d->nama_anggota }}</td>
            <td>{{ $d->total_denda }}</td>
            <td>{{ $d->status_bayar }}</td>
        </tr>
        @endforeach
    </tbody>
</table>