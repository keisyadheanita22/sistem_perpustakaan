<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\DendaController;
use App\Http\Controllers\Anggota\KatalogController;
use App\Http\Controllers\Anggota\ProfilAnggotaController;
use App\Http\Controllers\Petugas\ProfilPetugasController;
use App\Http\Controllers\KepalaController;
use Illuminate\Support\Facades\Route;

// =====================
// Halaman utama / landing page
// =====================
Route::get('/', function () {
    return view('welcome');
});

// =====================
// Semua route yang butuh login
// =====================
Route::middleware(['auth'])->group(function () {

    // =====================
    // Dashboard per role
    // =====================
    Route::get('/dashboard/anggota', function () {
        return view('dashboard.anggota');
    })->name('anggota.dashboard');

    Route::get('/dashboard/petugas', function () {
        return view('dashboard.petugas');
    })->name('petugas.dashboard');

    Route::get('/dashboard/kepala', [KepalaController::class, 'dashboard'])
        ->name('kepala.dashboard')
        ->middleware('role:kepala');

    // =====================
    // Route Buku - petugas (CRUD lengkap)
    // =====================
    Route::resource('buku', BukuController::class);

    // =====================
    // Route Katalog - anggota (lihat & pinjam buku)
    // =====================
    Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');

    // =====================
    // Route Profil - anggota
    // =====================

    // Tampilkan halaman profil anggota
    Route::get('/profil', [ProfilAnggotaController::class, 'show'])->name('anggota.profil');

    // Update data profil anggota (nama, email, no telepon, username)
    Route::put('/profil/update', [ProfilAnggotaController::class, 'update'])->name('anggota.profil.update');

    // Ganti password anggota
    Route::put('/profil/password', [ProfilAnggotaController::class, 'gantiPassword'])->name('anggota.profil.password');

    // =====================
    // Route Profil - petugas
    // =====================

    // Tampilkan halaman profil petugas
    Route::get('/petugas/profil', [ProfilPetugasController::class, 'show'])->name('petugas.profil');

    // Update data profil petugas (nama, email)
    Route::put('/petugas/profil/update', [ProfilPetugasController::class, 'update'])->name('petugas.profil.update');

    // Ganti password petugas
    Route::put('/petugas/profil/password', [ProfilPetugasController::class, 'gantiPassword'])->name('petugas.profil.password');

    // =====================
    // Route Peminjaman - anggota (harus sebelum resource!)
    // =====================

    // Lihat daftar peminjaman milik anggota sendiri
    Route::get('/peminjaman/saya', [PeminjamanController::class, 'peminjamanSaya'])->name('peminjaman.saya');

    // Anggota pinjam buku dari katalog
    Route::post('/peminjaman/pinjam/{buku}', [PeminjamanController::class, 'pinjam'])
        ->name('peminjaman.pinjam')
        ->middleware('role:anggota');

    // Anggota klik kembalikan -> status jadi 'mengembalikan'
    Route::post('/peminjaman/{id}/kembalikan', [PeminjamanController::class, 'kembalikan'])
        ->name('peminjaman.kembalikan')
        ->middleware('role:anggota');

    // Anggota batalkan peminjaman yang masih 'menunggu'
    Route::post('/peminjaman/{id}/batalkan', [PeminjamanController::class, 'batalkan'])
        ->name('peminjaman.batalkan')
        ->middleware('role:anggota');

    // =====================
    // Route Peminjaman - petugas
    // =====================

    // Petugas verifikasi peminjaman baru (menunggu -> dipinjam)
    Route::post('/peminjaman/{id}/verifikasi', [PeminjamanController::class, 'verifikasi'])
        ->name('peminjaman.verifikasi')
        ->middleware('role:petugas');

    // Petugas verifikasi pengembalian buku (mengembalikan -> dikembalikan)
    Route::post('/peminjaman/{id}/verifikasi-kembali', [PeminjamanController::class, 'verifikasiKembali'])
        ->name('peminjaman.verifikasiKembali')
        ->middleware('role:petugas');

    // =====================
    // Route Anggota - hanya petugas (lihat daftar & hapus)
    // =====================

    // Lihat daftar anggota yang sudah registrasi
    Route::get('/anggota', [AnggotaController::class, 'index'])
        ->middleware('role:petugas')
        ->name('anggota.index');

    // Hapus anggota
    Route::delete('/anggota/{id}', [AnggotaController::class, 'destroy'])
        ->middleware('role:petugas')
        ->name('anggota.destroy');

    // =====================
    // Route Kategori - petugas (CRUD lengkap)
    // =====================
    Route::resource('kategori', KategoriController::class);

    // =====================
    // Route Peminjaman CRUD - petugas
    // =====================
    Route::resource('peminjaman', PeminjamanController::class);

    // =====================
    // Route Denda
    // =====================

    // Anggota lihat denda miliknya sendiri
    Route::get('/denda/saya', [DendaController::class, 'dendaSaya'])->name('denda.saya');

    // Petugas lihat & ubah pengaturan denda per hari
    Route::get('/denda/pengaturan', [DendaController::class, 'pengaturan'])->name('denda.pengaturan');
    Route::post('/denda/pengaturan', [DendaController::class, 'updatePengaturan'])->name('denda.updatePengaturan');

    // Petugas lihat semua denda
    Route::get('/denda', [DendaController::class, 'index'])->name('denda.index');

    // Petugas konfirmasi pembayaran denda
    Route::post('/denda/{id}/konfirmasi', [DendaController::class, 'konfirmasi'])->name('denda.konfirmasi');
});

// =====================
// Route Kepala Perpustakaan
// =====================

// Dashboard kepala
Route::get('/dashboard/kepala', [KepalaController::class, 'dashboard'])
    ->name('kepala.dashboard')
    ->middleware(['auth', 'role:kepala']);

// Katalog buku untuk kepala
Route::get('/kepala/katalog', [KepalaController::class, 'katalog'])
    ->name('kepala.katalog')
    ->middleware(['auth', 'role:kepala']);

// Laporan perpustakaan
Route::get('/kepala/laporan', [KepalaController::class, 'laporan'])
    ->name('kepala.laporan')
    ->middleware(['auth', 'role:kepala']);

// Export laporan ke PDF
Route::get('/kepala/laporan/pdf', [KepalaController::class, 'exportPdf'])
    ->name('kepala.laporan.pdf')
    ->middleware(['auth', 'role:kepala']);

// Export laporan ke Excel
Route::get('/kepala/laporan/excel', [KepalaController::class, 'exportExcel'])
    ->name('kepala.laporan.excel')
    ->middleware(['auth', 'role:kepala']);

// Cek role user yang sedang login (untuk debugging)
Route::get('/cek-role', function () {
    return auth()->user()->role;
})->middleware('auth');

// =====================
// Route Profile (bawaan Laravel)
// =====================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';