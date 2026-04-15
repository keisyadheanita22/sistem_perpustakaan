<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use App\Models\Peminjaman;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DendaController extends Controller
{
    public function index(Request $request)
    {
        $pengaturan   = Pengaturan::where('kunci', 'denda_per_hari')->first();
        $dendaPerHari = $pengaturan ? (int)$pengaturan->nilai : 2000;
        $dendaRusak   = (int)(Pengaturan::where('kunci', 'denda_buku_rusak')->value('nilai') ?? 25000);
        $dendaHilang  = (int)(Pengaturan::where('kunci', 'denda_buku_hilang')->value('nilai') ?? 75000);

        $peminjamans = Peminjaman::with('buku')
            ->where('status', 'dipinjam')
            ->where('tanggal_kembali', '<', Carbon::today())
            ->get();

        foreach ($peminjamans as $p) {
            $sudahAda = Denda::where('peminjaman_id', $p->id)->exists();
            if (!$sudahAda) {
                $hari = Carbon::parse($p->tanggal_kembali)->diffInDays(Carbon::today());
                Denda::create([
                    'peminjaman_id'  => $p->id,
                    'nama_anggota'   => $p->nama_anggota,
                    'judul_buku'     => $p->buku->judul ?? '-',
                    'hari_terlambat' => $hari,
                    'denda_per_hari' => $dendaPerHari,
                    'total_denda'    => $hari * $dendaPerHari,
                    'status_bayar'   => 'belum_bayar',
                ]);
            }
        }

        $dendas = Denda::when($request->search, function ($query) use ($request) {
            $query->where('nama_anggota', 'like', '%' . $request->search . '%')
                  ->orWhere('judul_buku', 'like', '%' . $request->search . '%');
        })->latest()->get();

      return view('petugas.denda.index', compact('dendas', 'dendaPerHari', 'dendaRusak', 'dendaHilang'));
    }

    public function konfirmasi($id)
    {
        $denda = Denda::findOrFail($id);
        $denda->update(['status_bayar' => 'sudah_bayar']);

        if ($denda->peminjaman) {
           $denda->peminjaman->update(['status' => 'selesai']);
            if ($denda->peminjaman->buku) {
                $denda->peminjaman->buku->increment('stok');
            }
        }

        return redirect()->route('denda.index')->with('success', 'Denda berhasil dikonfirmasi!');
    }

   public function pengaturan()
{
    $dendaPerHari  = Pengaturan::where('kunci', 'denda_per_hari')->first();
    $dendaRusak    = Pengaturan::where('kunci', 'denda_buku_rusak')->first();
    $dendaHilang   = Pengaturan::where('kunci', 'denda_buku_hilang')->first();

    return view('petugas.denda.pengaturan', compact('dendaPerHari', 'dendaRusak', 'dendaHilang'));
}

public function updatePengaturan(Request $request)
{
    $request->validate([
        'denda_per_hari'    => 'required|integer|min:0',
        'denda_buku_rusak'  => 'required|integer|min:0',
        'denda_buku_hilang' => 'required|integer|min:0',
    ]);

    Pengaturan::updateOrCreate(
        ['kunci' => 'denda_per_hari'],
        ['nilai' => $request->denda_per_hari]
    );
    Pengaturan::updateOrCreate(
        ['kunci' => 'denda_buku_rusak'],
        ['nilai' => $request->denda_buku_rusak]
    );
    Pengaturan::updateOrCreate(
        ['kunci' => 'denda_buku_hilang'],
        ['nilai' => $request->denda_buku_hilang]
    );

    return redirect()->route('denda.index')->with('success', 'Pengaturan denda berhasil diupdate!');
}

// Tambah denda rusak/hilang manual oleh petugas
public function tambahDendaKhusus(Request $request)
{
    $request->validate([
        'peminjaman_id' => 'required|exists:peminjamans,id',
        'jenis_denda'   => 'required|in:rusak,hilang',
    ]);

    $p = Peminjaman::with('buku')->findOrFail($request->peminjaman_id);

    $kunci = $request->jenis_denda === 'rusak' ? 'denda_buku_rusak' : 'denda_buku_hilang';
    $nominal = (int)(Pengaturan::where('kunci', $kunci)->value('nilai') ?? 0);

    // Cek apakah sudah ada denda jenis ini untuk peminjaman ini
    $sudahAda = Denda::where('peminjaman_id', $p->id)
                     ->where('jenis_denda', $request->jenis_denda)
                     ->exists();

    if (!$sudahAda) {
        Denda::create([
            'peminjaman_id'  => $p->id,
            'nama_anggota'   => $p->nama_anggota,
            'judul_buku'     => $p->buku->judul ?? '-',
            'jenis_denda'    => $request->jenis_denda,
            'hari_terlambat' => 0,
            'denda_per_hari' => 0,
            'total_denda'    => $nominal,
            'status_bayar'   => 'belum_bayar',
        ]);
    }

    return redirect()->route('denda.index')->with('success', 'Denda ' . $request->jenis_denda . ' berhasil ditambahkan!');
}

    // -----------------------------------------------
    // Halaman denda khusus anggota yang login
    // -----------------------------------------------
    public function dendaSaya()
    {
        $user = auth()->user();

        // Ambil denda milik anggota yang sedang login
        $dendas = Denda::where('nama_anggota', $user->name)->latest()->get();

        return view('anggota.denda.index', compact('dendas'));
    }
}