<table>
    <thead>
        {{-- ========================
             HEADER LAPORAN PEMINJAMAN
        ======================== --}}
        <tr>
            <th colspan="6" style="font-weight: bold; background-color: #2D3A1E; color: #D4A017; text-align: center; font-size: 14px; border: 1px solid #000;">LAPORAN PEMINJAMAN</th>
        </tr>
        <tr>
            <th style="font-weight: bold; border: 1px solid #000; background-color: #f3f4f6;">No</th>
            <th style="font-weight: bold; border: 1px solid #000; background-color: #f3f4f6;">ID Peminjaman</th>
            <th style="font-weight: bold; border: 1px solid #000; background-color: #f3f4f6;">Nama Anggota</th>
            <th style="font-weight: bold; border: 1px solid #000; background-color: #f3f4f6;">Judul Buku</th>
            <th style="font-weight: bold; border: 1px solid #000; background-color: #f3f4f6;">Kategori</th>
            <th style="font-weight: bold; border: 1px solid #000; background-color: #f3f4f6;">Status</th>
        </tr>
    </thead>
    <tbody>
        {{-- Data baris peminjaman --}}
        @foreach($peminjamans as $i => $p)
        <tr>
            {{-- Nomor urut --}}
            <td style="border: 1px solid #000; text-align: center;">{{ $i + 1 }}</td>

            {{-- ID peminjaman --}}
            <td style="border: 1px solid #000;">{{ $p->id_peminjaman }}</td>

            {{-- Nama anggota --}}
            <td style="border: 1px solid #000;">{{ $p->nama_anggota }}</td>

            {{-- Judul buku, fallback '-' jika tidak ada --}}
            <td style="border: 1px solid #000;">{{ $p->buku->judul ?? '-' }}</td>

            {{-- Nama kategori buku, fallback '-' jika tidak ada --}}
            <td style="border: 1px solid #000;">{{ $p->buku->kategori->nama_kategori ?? '-' }}</td>

            {{-- Status peminjaman dengan huruf kapital di awal --}}
            <td style="border: 1px solid #000;">{{ ucfirst($p->status) }}</td>
        </tr>
        @endforeach
    </tbody>

    {{-- Baris kosong sebagai jarak antar tabel --}}
    <tr><td colspan="6"></td></tr>
    <tr><td colspan="6"></td></tr>

    <thead>
        {{-- ========================
             HEADER LAPORAN DENDA
        ======================== --}}
        <tr>
            {{-- colspan 5 karena sudah ada kolom Jenis --}}
            <th colspan="5" style="font-weight: bold; background-color: #2D3A1E; color: #D4A017; text-align: center; font-size: 14px; border: 1px solid #000;">LAPORAN DENDA</th>
        </tr>
        <tr>
            <th style="font-weight: bold; border: 1px solid #000; background-color: #f3f4f6;">No</th>
            <th style="font-weight: bold; border: 1px solid #000; background-color: #f3f4f6;">Nama Anggota</th>
            {{-- Kolom Jenis Denda (baru) --}}
            <th style="font-weight: bold; border: 1px solid #000; background-color: #f3f4f6;">Jenis Denda</th>
            <th style="font-weight: bold; border: 1px solid #000; background-color: #f3f4f6;">Total Denda</th>
            <th style="font-weight: bold; border: 1px solid #000; background-color: #f3f4f6;">Status Bayar</th>
        </tr>
    </thead>
    <tbody>
        {{-- Data baris denda --}}
        @foreach($dendas as $i => $d)
        <tr>
            {{-- Nomor urut --}}
            <td style="border: 1px solid #000; text-align: center;">{{ $i + 1 }}</td>

            {{-- Nama anggota --}}
            <td style="border: 1px solid #000;">{{ $d->nama_anggota }}</td>

            {{-- Jenis denda: Rusak / Hilang / Terlambat --}}
            <td style="border: 1px solid #000;">
                @if($d->jenis_denda == 'rusak')
                    Rusak
                @elseif($d->jenis_denda == 'hilang')
                    Hilang
                @else
                    {{-- Default jika bukan rusak/hilang --}}
                    Terlambat
                @endif
            </td>

            {{-- Total denda dalam format Rupiah --}}
            <td style="border: 1px solid #000;">Rp {{ number_format($d->total_denda, 0, ',', '.') }}</td>

            {{-- Status bayar dengan huruf kapital di awal --}}
            <td style="border: 1px solid #000;">{{ ucfirst($d->status_bayar) }}</td>
        </tr>
        @endforeach

        {{-- Tampil jika tidak ada data denda --}}
        @if($dendas->isEmpty())
        <tr>
            {{-- colspan 5 karena sudah ada kolom Jenis --}}
            <td colspan="5" style="text-align: center; font-style: italic; border: 1px solid #000;">Tidak ada data denda</td>
        </tr>
        @endif
    </tbody>
</table>