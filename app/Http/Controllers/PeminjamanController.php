<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\User;   
use App\Models\Buku;
use App\Models\Denda;
use App\Models\Pengaturan; 
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    // ===== PETUGAS: Tampilkan semua data peminjaman =====
    public function index()
    {
        $search = request('search');

        $peminjamans = Peminjaman::with('buku')
            ->when($search, function ($query) use ($search) {
                $query->where('nama_anggota', 'like', '%' . $search . '%');
                
    //yg di ubah agar ngurut dari awal ga dari bawah
            })->latest()->get();

        // Hitung peminjaman yang perlu diverifikasi petugas
        $perluVerifikasi = Peminjaman::whereIn('status', ['menunggu', 'mengembalikan'])->count();

        return view('petugas.peminjaman.index', compact('peminjamans', 'perluVerifikasi'));
    }

    // ===== PETUGAS: Halaman form tambah peminjaman =====
    public function create()
    {
        $anggota = User::where('role', 'anggota')->get();

        // Hanya tampilkan buku yang stoknya masih ada
        $bukus = Buku::where('stok', '>', 0)->get();

        return view('petugas.peminjaman.create', compact('anggota', 'bukus'));
    }

    // ===== PETUGAS: Simpan peminjaman baru (input manual oleh petugas) =====
    public function store(Request $request)
    {
        $request->validate([
            'anggota_id'      => 'required',
            'buku_id'         => 'required',
            'tanggal_pinjam'  => 'required|date',
            'tanggal_kembali' => 'required|date',
        ]);

        $anggota = User::findOrFail($request->anggota_id);

        // Generate ID peminjaman otomatis: PM001, PM002, dst
        $last         = Peminjaman::orderBy('id', 'desc')->first();
        $newNumber    = $last ? (int) substr($last->id_peminjaman, 2) + 1 : 1;
        $idPeminjaman = 'PM' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        Peminjaman::create([
            'id_peminjaman'   => $idPeminjaman,
            'id_anggota'      => $anggota->id_anggota,
            'nama_anggota'    => $anggota->name,   
            'buku_id'         => $request->buku_id,
            'tanggal_pinjam'  => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status'          => 'dipinjam', 
        ]);

        // Kurangi stok buku karena langsung dipinjam
        $buku = Buku::findOrFail($request->buku_id);
        $buku->decrement('stok');

        return redirect()->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil ditambahkan!');
    }

    // ===== ANGGOTA: Pinjam buku dari halaman katalog =====
    public function pinjam($buku_id)
    {
        $buku = Buku::findOrFail($buku_id);
        $user = auth()->user();

        // Hitung peminjaman aktif milik anggota ini
        $pinjamAktif = Peminjaman::where('id_anggota', $user->id_anggota)
            ->whereIn('status', ['menunggu', 'dipinjam', 'mengembalikan'])
            ->count();

        // Kalau sudah 3 atau lebih, tolak peminjaman baru
        if ($pinjamAktif >= 3) {
            return redirect()->route('katalog.index')
                ->with('error', 'Batas peminjaman maksimal 3 buku! Kembalikan buku terlebih dahulu.');
        }

        // Generate ID peminjaman otomatis: PM001, PM002, dst
        $last         = Peminjaman::orderBy('id', 'desc')->first();
        $newNumber    = $last ? (int) substr($last->id_peminjaman, 2) + 1 : 1;
        $idPeminjaman = 'PM' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        Peminjaman::create([
            'id_peminjaman'   => $idPeminjaman,
            'id_anggota'      => $user->id_anggota,
            'nama_anggota'    => $user->name,
            'buku_id'         => $buku->id,
            'tanggal_pinjam'  => now(),
            'tanggal_kembali' => now()->addDays(7),
            'status'          => 'menunggu',
        ]);

        return redirect()->route('katalog.index')
            ->with('success', 'Permintaan peminjaman berhasil dikirim, tunggu verifikasi petugas!');
    }

    // ===== ANGGOTA: Halaman "Peminjaman Saya" =====
    public function peminjamanSaya()
    {
        $user = auth()->user();

        $peminjamans = Peminjaman::with('buku')
            ->where('nama_anggota', $user->name)
            ->latest()
            ->get();

        return view('anggota.peminjaman.index', compact('peminjamans'));
    }

    // ===== ANGGOTA: Klik tombol "Kembalikan" =====
    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'dipinjam') {
            return redirect()->route('peminjaman.saya')
                ->with('error', 'Buku tidak bisa dikembalikan!');
        }

        $peminjaman->update(['status' => 'mengembalikan']);

        return redirect()->route('peminjaman.saya')
            ->with('success', 'Permintaan pengembalian dikirim, tunggu verifikasi petugas!');
    }

    // ===== ANGGOTA: Batalkan peminjaman =====
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

    // ===== PETUGAS: Verifikasi peminjaman baru dari anggota =====
    public function verifikasi($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $buku       = Buku::findOrFail($peminjaman->buku_id);

        $peminjaman->update(['status' => 'dipinjam']);
        $buku->decrement('stok');

        return redirect()->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil diverifikasi!');
    }

    // ===== PETUGAS: Verifikasi pengembalian buku dari anggota =====
    public function verifikasiKembali($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'mengembalikan') {
            return redirect()->route('peminjaman.index')
                ->with('error', 'Status tidak valid untuk diverifikasi!');
        }

        $peminjaman->update(['status' => 'dikembalikan']);
        $peminjaman->buku->increment('stok');

        return redirect()->route('peminjaman.index')
            ->with('success', 'Pengembalian buku berhasil diverifikasi!');
    }

    // ===== PETUGAS: Halaman form edit peminjaman =====
    public function edit($id) 
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $anggota    = User::where('role', 'anggota')->get();
        $bukus      = Buku::all();

        return view('petugas.peminjaman.edit', compact('peminjaman', 'anggota', 'bukus'));
    }

    // ===== PETUGAS: Simpan perubahan data peminjaman =====
    public function update(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $request->validate([
            'tanggal_kembali' => 'required|date',
            'status'          => 'required',
        ]);

        $peminjaman->update($request->all());

        return redirect()->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil diupdate!');
    }

    // ===== PETUGAS: Tandai buku rusak =====
    public function dendaRusak($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $dendaRusak = Pengaturan::where('kunci', 'denda_buku_rusak')->first()->nilai;

        Denda::create([
            'peminjaman_id'  => $peminjaman->id,
            'nama_anggota'   => $peminjaman->nama_anggota,
            'judul_buku'     => $peminjaman->buku->judul,
            'jenis_denda'    => 'rusak',
            'hari_terlambat' => 0,
            'denda_per_hari' => 0,
            'total_denda'    => $dendaRusak,
            'status_bayar'   => 'belum_bayar',
        ]);

        $peminjaman->update(['status' => 'ada_denda']);
        $peminjaman->buku->increment('stok');

        return redirect()->route('peminjaman.index')
            ->with('success', 'Buku ditandai rusak, denda berhasil dibuat.');
    }

    // ===== PETUGAS: Tandai buku hilang =====
    public function dendaHilang($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $dendaHilang = Pengaturan::where('kunci', 'denda_buku_hilang')->first()->nilai;

        Denda::create([
            'peminjaman_id'  => $peminjaman->id,
            'nama_anggota'   => $peminjaman->nama_anggota,
            'judul_buku'     => $peminjaman->buku->judul,
            'jenis_denda'    => 'hilang',
            'hari_terlambat' => 0,
            'denda_per_hari' => 0,
            'total_denda'    => $dendaHilang,
            'status_bayar'   => 'belum_bayar',
        ]);

        $peminjaman->update(['status' => 'ada_denda']);

        return redirect()->route('peminjaman.index')
            ->with('success', 'Buku ditandai hilang, denda berhasil dibuat.');
    }
}