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
            'anggota_id'      => 'required',
            'buku_id'         => 'required',
            'tanggal_pinjam'  => 'required|date',
            'tanggal_kembali' => 'required|date',
        ]);

        // Generate ID otomatis
        $last = Peminjaman::orderBy('id', 'desc')->first();
        $newNumber = $last ? (int)substr($last->id_peminjaman, 2) + 1 : 1;
        $idPeminjaman = 'PM' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        $anggota = Anggota::findOrFail($request->anggota_id);

        Peminjaman::create([
            'id_peminjaman'   => $idPeminjaman,
            'id_anggota'      => $anggota->id_anggota,
            'nama_anggota'    => $anggota->nama,
            'buku_id'         => $request->buku_id,
            'tanggal_pinjam'  => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status'          => 'dipinjam',
        ]);

        $buku = Buku::findOrFail($request->buku_id);
        $buku->decrement('stok');

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil ditambahkan!');
    }

   public function pinjam($buku_id)
{
    $buku = Buku::findOrFail($buku_id);
    $user = auth()->user();

    $last = Peminjaman::orderBy('id', 'desc')->first();
    $newNumber = $last ? (int)substr($last->id_peminjaman, 2) + 1 : 1;
    $idPeminjaman = 'PM' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

    Peminjaman::create([
        'id_peminjaman'   => $idPeminjaman,
        'id_anggota'      => $user->id_anggota,
        'nama_anggota'    => $user->name,
        'buku_id'         => $buku->id,
        'tanggal_pinjam'  => now(),
        'tanggal_kembali' =>  now()->subDays(3),
        'status'          => 'menunggu', //  bukan langsung dipinjam
    ]);
    // ❌ stok belum dikurangi

    return redirect()->route('katalog.index')->with('success', 'Permintaan peminjaman berhasil dikirim, tunggu verifikasi petugas!');
    }

    // -----------------------------------------------
// Halaman "Peminjaman Saya" untuk anggota
// -----------------------------------------------
public function peminjamanSaya()
{
    $user = auth()->user();

    // Ambil semua peminjaman milik user yang login
    $peminjamans = Peminjaman::with('buku')
        ->where('nama_anggota', $user->name)
        ->latest()
        ->get();

    return view('anggota.peminjaman.index', compact('peminjamans'));
}

// -----------------------------------------------
// Anggota kembalikan buku
// Hanya bisa kalau status = 'dipinjam'
// -----------------------------------------------
public function kembalikan($id)
{
    $peminjaman = Peminjaman::findOrFail($id);

    // Pastikan hanya status 'dipinjam' yang bisa dikembalikan
    if ($peminjaman->status !== 'dipinjam') {
        return redirect()->route('peminjaman.saya')
            ->with('error', 'Buku tidak bisa dikembalikan!');
    }

    // Update status jadi dikembalikan
    $peminjaman->update(['status' => 'dikembalikan']);

    // Kembalikan stok buku
    $peminjaman->buku->increment('stok');

    return redirect()->route('peminjaman.saya')
        ->with('success', 'Buku berhasil dikembalikan!');
}

// -----------------------------------------------
// Anggota batalkan peminjaman
// Hanya bisa kalau status masih 'menunggu'
// -----------------------------------------------
public function batalkan($id)
{
    $peminjaman = Peminjaman::findOrFail($id);

    // Hanya boleh batalkan kalau masih menunggu verifikasi
    if ($peminjaman->status !== 'menunggu') {
        return redirect()->route('peminjaman.saya')
            ->with('error', 'Peminjaman tidak bisa dibatalkan!');
    }

    $peminjaman->delete();

    return redirect()->route('peminjaman.saya')
        ->with('success', 'Peminjaman berhasil dibatalkan!');
    }

    public function edit(Peminjaman $peminjaman)
    {
        $anggota = Anggota::all();
        $bukus = Buku::all();
        return view('petugas.peminjaman.edit', compact('peminjaman', 'anggota', 'bukus'));
    }

    public function verifikasi($id)
{
    $peminjaman = Peminjaman::findOrFail($id);
    $buku = Buku::findOrFail($peminjaman->buku_id);

    $peminjaman->update(['status' => 'dipinjam']);
    $buku->decrement('stok');

    return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diverifikasi!');
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