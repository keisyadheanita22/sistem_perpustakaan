<table>
    <thead>
        {{-- Header Utama Peminjaman --}}
        <tr>
            <th colspan="6" style="font-weight: bold; background-color: #2D3A1E; color: #D4A017; text-align: center; font-size: 14px; border: 1px solid #000;">LAPORAN PEMINJAMAN</th>
        </tr>
        <tr>
            <th style="font-weight: bold; border: 1px solid #000; background-color: #f3f4f6;">No</th>
            <th style="font-weight: bold; border: 1px solid #000; background-color: #f3f4f6;">ID Peminjaman</th>
            <th style="font-weight: bold; border: 1px solid #000; background-color: #f3f4f6;">Nama Anggota</th>
            <th style="font-weight: bold; border: 1px solid #000; background-color: #f3f4f6;">Judul Buku</th>
            <th style="font-weight: bold; border: 1px solid #000; background-color: #f3f4f6;">Kategori</th> {{-- Kolom Baru --}}
            <th style="font-weight: bold; border: 1px solid #000; background-color: #f3f4f6;">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($peminjamans as $i => $p)
        <tr>
            <td style="border: 1px solid #000; text-align: center;">{{ $i + 1 }}</td>
            <td style="border: 1px solid #000;">{{ $p->id_peminjaman }}</td>
            <td style="border: 1px solid #000;">{{ $p->nama_anggota }}</td>
            <td style="border: 1px solid #000;">{{ $p->buku->judul ?? '-' }}</td>
            {{-- Menampilkan Kategori --}}
            <td style="border: 1px solid #000;">{{ $p->buku->kategori->nama_kategori ?? '-' }}</td>
            <td style="border: 1px solid #000;">{{ ucfirst($p->status) }}</td>
        </tr>
        @endforeach
    </tbody>

    {{-- Jarak antar tabel --}}
    <tr><td colspan="6"></td></tr>
    <tr><td colspan="6"></td></tr>

    <thead>
        {{-- Header Utama Denda --}}
        <tr>
            <th colspan="4" style="font-weight: bold; background-color: #2D3A1E; color: #D4A017; text-align: center; font-size: 14px; border: 1px solid #000;">LAPORAN DENDA</th>
        </tr>
        <tr>
            <th style="font-weight: bold; border: 1px solid #000; background-color: #f3f4f6;">No</th>
            <th style="font-weight: bold; border: 1px solid #000; background-color: #f3f4f6;">Nama Anggota</th>
            <th style="font-weight: bold; border: 1px solid #000; background-color: #f3f4f6;">Total Denda</th>
            <th style="font-weight: bold; border: 1px solid #000; background-color: #f3f4f6;">Status Bayar</th>
        </tr>
    </thead>
    <tbody>
        @foreach($dendas as $i => $d)
        <tr>
            <td style="border: 1px solid #000; text-align: center;">{{ $i + 1 }}</td>
            <td style="border: 1px solid #000;">{{ $d->nama_anggota }}</td>
            <td style="border: 1px solid #000;">Rp {{ number_format($d->total_denda, 0, ',', '.') }}</td>
            <td style="border: 1px solid #000;">{{ ucfirst($d->status_bayar) }}</td>
        </tr>
        @endforeach
        @if($dendas->isEmpty())
        <tr>
            <td colspan="4" style="text-align: center; font-style: italic; border: 1px solid #000;">Tidak ada data denda</td>
        </tr>
        @endif
    </tbody>
</table>