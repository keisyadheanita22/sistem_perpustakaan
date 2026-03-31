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
        $pengaturan = Pengaturan::where('kunci', 'denda_per_hari')->first();
        $dendaPerHari = $pengaturan ? (int)$pengaturan->nilai : 2000;

        $peminjamans = Peminjaman::with('buku')
            ->where('status', 'dipinjam')
            ->where('tanggal_kembali', '<', Carbon::today())
            ->get();

        foreach ($peminjamans as $p) {
            $sudahAda = Denda::where('peminjaman_id', $p->id)->exists();
            if (!$sudahAda) {
                $hari = Carbon::today()->diffInDays(Carbon::parse($p->tanggal_kembali));
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

        return view('petugas.denda.index', compact('dendas', 'dendaPerHari'));
    }

    public function konfirmasi($id)
    {
        $denda = Denda::findOrFail($id);
        $denda->update(['status_bayar' => 'sudah_bayar']);

        if ($denda->peminjaman) {
            $denda->peminjaman->update(['status' => 'dikembalikan']);
            if ($denda->peminjaman->buku) {
                $denda->peminjaman->buku->increment('stok');
            }
        }

        return redirect()->route('denda.index')->with('success', 'Denda berhasil dikonfirmasi!');
    }

    public function pengaturan()
    {
        $pengaturan = Pengaturan::where('kunci', 'denda_per_hari')->first();
        return view('petugas.denda.pengaturan', compact('pengaturan'));
    }

    public function updatePengaturan(Request $request)
    {
        $request->validate([
            'nilai' => 'required|integer|min:0',
        ]);

        Pengaturan::where('kunci', 'denda_per_hari')->update(['nilai' => $request->nilai]);

        return redirect()->route('denda.index')->with('success', 'Denda per hari berhasil diupdate!');
    }
}