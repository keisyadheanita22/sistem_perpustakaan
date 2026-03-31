<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Anggota;
use App\Models\Buku;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        $search = request('search');
        $peminjamans = Peminjaman::with('buku')
            ->when($search, function($query) use ($search) {
                $query->where('nama_anggota', 'like', '%' . $search . '%');
            })->get();
        return view('petugas.peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $anggota = Anggota::all();
        $bukus = Buku::where('stok', '>', 0)->get();
        return view('petugas.peminjaman.create', compact('anggota', 'bukus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_peminjaman' => 'required',
            'anggota_id'    => 'required',
            'buku_id'       => 'required',
            'tanggal_pinjam'  => 'required|date',
            'tanggal_kembali' => 'required|date',
        ]);

        $anggota = Anggota::findOrFail($request->anggota_id);

        Peminjaman::create([
            'id_peminjaman'   => $request->id_peminjaman,
            'id_anggota'      => $anggota->id_anggota,
            'nama_anggota'    => $anggota->nama,
            'buku_id'         => $request->buku_id,
            'tanggal_pinjam'  => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status'          => 'dipinjam',
        ]);

        // Kurangi stok buku
        $buku = Buku::findOrFail($request->buku_id);
        $buku->decrement('stok');

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil ditambahkan!');
    }

    public function edit(Peminjaman $peminjaman)
    {
        $anggota = Anggota::all();
        $bukus = Buku::all();
        return view('petugas.peminjaman.edit', compact('peminjaman', 'anggota', 'bukus'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'tanggal_kembali' => 'required|date',
            'status'          => 'required',
        ]);

        $peminjaman->update($request->all());

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diupdate!');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        $peminjaman->delete();
        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dihapus!');
    }
}