<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\Denda;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class KepalaController extends Controller
{
    // =====================
    // DASHBOARD
    // =====================
    public function dashboard()
    {
        $totalBuku       = Buku::count();
        $totalAnggota    = User::where('role', 'anggota')->count();
        $totalPetugas    = User::where('role', 'petugas')->count();
        $peminjamanAktif = Peminjaman::where('status', 'dipinjam')->count();

        // Ambil 5 buku terbaru
        $buku = Buku::latest()->take(5)->get();

        return view('dashboard.kepala', compact(
            'totalBuku',
            'totalAnggota',
            'totalPetugas',
            'peminjamanAktif',
            'buku'
        ));
    }

    // =====================
    // KATALOG
    // =====================
    public function katalog(Request $request)
    {
        // Filter berdasarkan judul/pengarang dan kategori jika ada
        $bukus = Buku::with('kategori')
            ->when($request->search, function ($query) use ($request) {
                $query->where('judul', 'like', '%' . $request->search . '%')
                      ->orWhere('pengarang', 'like', '%' . $request->search . '%');
            })
            ->when($request->kategori_id, function ($query) use ($request) {
                $query->where('kategori_id', $request->kategori_id);
            })
            ->get();

        $kategoris = Kategori::all();

        return view('kepala.katalog.index', compact('bukus', 'kategoris'));
    }

    // =====================
    // LAPORAN
    // =====================
    public function laporan(Request $request)
    {
        // Ambil data peminjaman beserta relasi buku & kategori, filter bulan/tahun jika ada
        $peminjamans = Peminjaman::with(['buku.kategori'])
            ->when($request->bulan, function ($query) use ($request) {
                $query->whereMonth('tanggal_pinjam', $request->bulan)
                      ->whereYear('tanggal_pinjam', $request->tahun ?? now()->year);
            })
            ->latest()
            ->get();

        // Ambil data denda beserta relasi peminjaman, filter bulan/tahun jika ada
        $dendas = Denda::with('peminjaman')
            ->when($request->bulan, function ($query) use ($request) {
                $query->whereMonth('created_at', $request->bulan)
                      ->whereYear('created_at', $request->tahun ?? now()->year);
            })
            ->get();

        // Rekap jumlah peminjaman per bulan untuk chart/grid bulanan
        $rekapBulanan = Peminjaman::selectRaw('MONTH(tanggal_pinjam) as bulan, COUNT(*) as total')
            ->whereYear('tanggal_pinjam', $request->tahun ?? now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        return view('kepala.laporan', compact('peminjamans', 'dendas', 'rekapBulanan'));
    }

    // =====================
    // EXPORT PDF
    // =====================
    public function exportPdf(Request $request)
    {
        // Ambil data peminjaman beserta relasi buku & kategori, filter bulan/tahun jika ada
        $peminjamans = Peminjaman::with(['buku.kategori'])
            ->when($request->bulan, function ($query) use ($request) {
                $query->whereMonth('tanggal_pinjam', $request->bulan)
                      ->whereYear('tanggal_pinjam', $request->tahun ?? now()->year);
            })
            ->latest()
            ->get();

        // Ambil data denda, filter bulan/tahun jika ada
        $dendas = Denda::when($request->bulan, function ($query) use ($request) {
                $query->whereMonth('created_at', $request->bulan)
                      ->whereYear('created_at', $request->tahun ?? now()->year);
            })
            ->get();

        // Generate PDF dari view laporan-pdf ukuran A4 landscape lalu download
        $pdf = Pdf::loadView('kepala.laporan-pdf', compact('peminjamans', 'dendas'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-perpustakaan.pdf');
    }

    // =====================
    // EXPORT EXCEL
    // =====================
    public function exportExcel(Request $request)
    {
        // Download laporan dalam format Excel menggunakan LaporanExport
        return Excel::download(
            new LaporanExport($request->bulan, $request->tahun),
            'laporan-perpustakaan.xlsx'
        );
    }

    // =====================
    // DATA PETUGAS
    // =====================

    // Tampilkan daftar semua petugas dengan fitur pencarian
    public function indexPetugas(Request $request)
    {
        $petugas = User::where('role', 'petugas')
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('email', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->get();

        return view('kepala.petugas.index', compact('petugas'));
    }

    // Tampilkan form tambah petugas
    public function createPetugas()
    {
        return view('kepala.petugas.create');
    }

    // Simpan data petugas baru ke database
    public function storePetugas(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|min:8|confirmed',
        ]);

        // Simpan username agar petugas bisa login pakai username
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role'     => 'petugas',
        ]);

        return redirect()->route('kepala.petugas.index')
                         ->with('success', 'Petugas berhasil ditambahkan!');
    }

    // Tampilkan form edit petugas berdasarkan ID
    public function editPetugas($id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);
        return view('kepala.petugas.edit', compact('petugas'));
    }

    // Simpan perubahan data petugas
    public function updatePetugas(Request $request, $id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id,
            'username' => 'nullable|string|max:50|unique:users,username,' . $id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $petugas->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'username' => $request->username,
            // Update password hanya kalau diisi
            ...($request->filled('password')
                ? ['password' => bcrypt($request->password)]
                : []),
        ]);

        return redirect()->route('kepala.petugas.index')
                         ->with('success', 'Data petugas berhasil diperbarui!');
    }

    // Hapus data petugas berdasarkan ID
    public function destroyPetugas($id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);
        $petugas->delete();

        return redirect()->route('kepala.petugas.index')
                         ->with('success', 'Petugas berhasil dihapus!');
    }

    // =====================
    // PROFIL KEPALA
    // =====================

    // Tampilkan halaman profil kepala
    public function profil()
    {
        return view('kepala.profil', ['user' => auth()->user()]);
    }

    // Update nama dan email profil kepala
    public function updateProfil(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    // Ganti password kepala dengan validasi password lama
    public function gantiPassword(Request $request)
    {
        $request->validate([
            'password_lama'         => 'required',
            'password'              => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

        // Cek apakah password lama cocok
        if (!Hash::check($request->password_lama, auth()->user()->password)) {
            return back()->withErrors(['password_lama' => 'Password lama tidak cocok!']);
        }

        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diubah!');
    }

    // Update foto profil kepala
    public function updateFoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = auth()->user();

        // Hapus foto lama dari storage jika ada
        if ($user->foto && Storage::disk('public')->exists($user->foto)) {
            Storage::disk('public')->delete($user->foto);
        }

        // Simpan foto baru ke folder foto-profil
        $path = $request->file('foto')->store('foto-profil', 'public');

        $user->update(['foto' => $path]);

        return back()->with('success', 'Foto berhasil diperbarui!');
    }
}