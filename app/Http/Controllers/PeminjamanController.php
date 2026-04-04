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

        // Generate ID otomatis (PM001, PM002, dst)
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
            'status'          => 'dipinjam', // Petugas input langsung = dipinjam
        ]);

        // Kurangi stok buku
        $buku = Buku::findOrFail($request->buku_id);
        $buku->decrement('stok');

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil ditambahkan!');
    }

    // Anggota meminjam buku dari katalog
    public function pinjam($buku_id)
    {
        $buku = Buku::findOrFail($buku_id);
        $user = auth()->user();

        // Generate ID otomatis
        $last = Peminjaman::orderBy('id', 'desc')->first();
        $newNumber = $last ? (int)substr($last->id_peminjaman, 2) + 1 : 1;
        $idPeminjaman = 'PM' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        Peminjaman::create([
            'id_peminjaman'   => $idPeminjaman,
            'id_anggota'      => $user->id_anggota,
            'nama_anggota'    => $user->name,
            'buku_id'         => $buku->id,
            'tanggal_pinjam'  => now(),
            'tanggal_kembali' => now()->addDays(7), // Batas kembali 7 hari
            'status'          => 'menunggu', // Tunggu verifikasi petugas dulu
        ]);
        // Stok belum dikurangi, dikurangi saat petugas verifikasi

        return redirect()->route('katalog.index')->with('success', 'Permintaan peminjaman berhasil dikirim, tunggu verifikasi petugas!');
    }

    // Halaman "Peminjaman Saya" untuk anggota
    public function peminjamanSaya()
    {
        $user = auth()->user();

        // Ambil semua peminjaman milik anggota yang sedang login
        $peminjamans = Peminjaman::with('buku')
            ->where('nama_anggota', $user->name)
            ->latest()
            ->get();

        return view('anggota.peminjaman.index', compact('peminjamans'));
    }

    // Anggota klik tombol "Kembalikan"
    // Status berubah jadi 'mengembalikan', tunggu verifikasi petugas
    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        // Hanya bisa dikembalikan jika status masih 'dipinjam'
        if ($peminjaman->status !== 'dipinjam') {
            return redirect()->route('peminjaman.saya')
                ->with('error', 'Buku tidak bisa dikembalikan!');
        }

        // Ubah status jadi 'mengembalikan', stok belum naik
        // Stok naik setelah petugas verifikasi
        $peminjaman->update(['status' => 'mengembalikan']);

        return redirect()->route('peminjaman.saya')
            ->with('success', 'Permintaan pengembalian dikirim, tunggu verifikasi petugas!');
    }

    // Anggota batalkan peminjaman
    // Hanya bisa jika status masih 'menunggu' (belum diverifikasi petugas)
    public function batalkan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'menunggu') {
            return redirect()->route('peminjaman.saya')
                ->with('error', 'Peminjaman tidak bisa dibatalkan!');
        }

        $peminjaman->delete();

        return redirect()->route('peminjaman.saya')
            ->with('success', 'Peminjaman berhasil dibatalkan!');
    }

    // Petugas verifikasi peminjaman baru dari anggota
    // Status: menunggu -> dipinjam, stok buku dikurangi
    public function verifikasi($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $buku = Buku::findOrFail($peminjaman->buku_id);

        $peminjaman->update(['status' => 'dipinjam']);
        $buku->decrement('stok'); // Stok dikurangi saat diverifikasi

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diverifikasi!');
    }

    // Petugas verifikasi pengembalian buku dari anggota
    // Status: mengembalikan -> dikembalikan, stok buku bertambah
    public function verifikasiKembali($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        // Pastikan statusnya memang 'mengembalikan'
        if ($peminjaman->status !== 'mengembalikan') {
            return redirect()->route('peminjaman.index')
                ->with('error', 'Status tidak valid untuk diverifikasi!');
        }

        $peminjaman->update(['status' => 'dikembalikan']);
        $peminjaman->buku->increment('stok'); // Stok naik setelah dikonfirmasi kembali

        return redirect()->route('peminjaman.index')
            ->with('success', 'Pengembalian buku berhasil diverifikasi!');
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