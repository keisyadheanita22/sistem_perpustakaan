<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\DendaController;
use App\Http\Controllers\KepalaController;
use App\Http\Controllers\Anggota\KatalogController;
use App\Http\Controllers\Anggota\ProfilAnggotaController;
use App\Http\Controllers\Petugas\ProfilPetugasController;
use App\Http\Controllers\Kepala\ProfilKepalaController;
use Illuminate\Support\Facades\Route;

// =============================================================
// LANDING PAGE
// =============================================================
Route::get('/', function () {
    return view('welcome');
});

// =============================================================
// ROUTE KHUSUS ANGGOTA
// =============================================================
Route::middleware(['auth', 'role:anggota'])->group(function () {

    // Dashboard Anggota
    Route::get('/dashboard/anggota', function () {
        return view('dashboard.anggota');
    })->name('anggota.dashboard');

    // Katalog Buku
    Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');

    // Profil Anggota
    Route::get('/profil', [ProfilAnggotaController::class, 'show'])->name('anggota.profil');
    Route::put('/profil/update', [ProfilAnggotaController::class, 'update'])->name('anggota.profil.update');
    Route::put('/profil/password', [ProfilAnggotaController::class, 'gantiPassword'])->name('anggota.profil.password');

    // Peminjaman Anggota
    Route::get('/peminjaman/saya', [PeminjamanController::class, 'peminjamanSaya'])->name('peminjaman.saya');
    Route::post('/peminjaman/pinjam/{buku}', [PeminjamanController::class, 'pinjam'])->name('peminjaman.pinjam');
    Route::post('/peminjaman/{id}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
    Route::post('/peminjaman/{id}/batalkan', [PeminjamanController::class, 'batalkan'])->name('peminjaman.batalkan');

    // Denda Anggota
    Route::get('/denda/saya', [DendaController::class, 'dendaSaya'])->name('denda.saya');
});

// =============================================================
// ROUTE KHUSUS PETUGAS
// =============================================================
Route::middleware(['auth', 'role:petugas'])->group(function () {

    // Dashboard Petugas
    Route::get('/dashboard/petugas', function () {
        return view('dashboard.petugas');
    })->name('petugas.dashboard');

    // Profil Petugas
    Route::get('/petugas/profil', [ProfilPetugasController::class, 'show'])->name('petugas.profil');
    Route::put('/petugas/profil/update', [ProfilPetugasController::class, 'update'])->name('petugas.profil.update');
    Route::put('/petugas/profil/password', [ProfilPetugasController::class, 'gantiPassword'])->name('petugas.profil.password');

    // Kelola Buku
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
    Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
    Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
    Route::get('/buku/{buku}', [BukuController::class, 'show'])->name('buku.show');
    Route::get('/buku/{buku}/edit', [BukuController::class, 'edit'])->name('buku.edit');
    Route::put('/buku/{buku}', [BukuController::class, 'update'])->name('buku.update');
    Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])->name('buku.destroy');

    // Kelola Kategori
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{kategori}', [KategoriController::class, 'show'])->name('kategori.show');
    Route::get('/kategori/{kategori}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    // Kelola Peminjaman
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
    Route::get('/peminjaman/{id}/edit', [PeminjamanController::class, 'edit'])->name('peminjaman.edit');
    Route::put('/peminjaman/{id}', [PeminjamanController::class, 'update'])->name('peminjaman.update');
    Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
    Route::post('/peminjaman/{id}/verifikasi', [PeminjamanController::class, 'verifikasi'])->name('peminjaman.verifikasi');
    Route::post('/peminjaman/{id}/verifikasi-kembali', [PeminjamanController::class, 'verifikasiKembali'])->name('peminjaman.verifikasiKembali');
    Route::post('/peminjaman/{id}/denda-rusak', [PeminjamanController::class, 'dendaRusak'])->name('peminjaman.dendaRusak');
    Route::post('/peminjaman/{id}/denda-hilang', [PeminjamanController::class, 'dendaHilang'])->name('peminjaman.dendaHilang');

    // Kelola Anggota
    Route::get('/anggota', [AnggotaController::class, 'index'])->name('anggota.index');
    Route::get('/anggota/{id}/edit', [AnggotaController::class, 'edit'])->name('anggota.edit');
    Route::put('/anggota/{id}', [AnggotaController::class, 'update'])->name('anggota.update');
    Route::delete('/anggota/{id}', [AnggotaController::class, 'destroy'])->name('anggota.destroy');

    // Denda Petugas
    Route::get('/denda', [DendaController::class, 'index'])->name('denda.index');
    Route::get('/denda/pengaturan', [DendaController::class, 'pengaturan'])->name('denda.pengaturan');
    Route::post('/denda/pengaturan', [DendaController::class, 'updatePengaturan'])->name('denda.updatePengaturan');
    Route::post('/denda/{id}/konfirmasi', [DendaController::class, 'konfirmasi'])->name('denda.konfirmasi');
    Route::post('/denda/tambah-khusus', [DendaController::class, 'tambahDendaKhusus'])->name('denda.tambahKhusus');
});

// =============================================================
// ROUTE KEPALA PERPUSTAKAAN
// =============================================================
Route::middleware(['auth', 'role:kepala'])->prefix('kepala')->name('kepala.')->group(function () {
    Route::get('/dashboard', [KepalaController::class, 'dashboard'])->name('dashboard');
    Route::get('/katalog', [KepalaController::class, 'katalog'])->name('katalog');

    // Profil Kepala
    Route::get('/profil', [ProfilKepalaController::class, 'show'])->name('profil');
    Route::put('/profil/update', [ProfilKepalaController::class, 'update'])->name('profil.update');
    Route::put('/profil/password', [ProfilKepalaController::class, 'gantiPassword'])->name('profil.password');
    Route::post('/profil/foto', [ProfilKepalaController::class, 'updateFoto'])->name('profil.foto');

    // Laporan Kepala
        Route::get('/laporan', [KepalaController::class, 'laporan'])->name('laporan');
        Route::get('/laporan/pdf', [KepalaController::class, 'exportPdf'])->name('laporan.pdf');
        Route::get('/laporan/excel', [KepalaController::class, 'exportExcel'])->name('laporan.excel');

    // Kelola Petugas
    Route::get('/petugas', [KepalaController::class, 'indexPetugas'])->name('petugas.index');
    Route::get('/petugas/create', [KepalaController::class, 'createPetugas'])->name('petugas.create');
    Route::post('/petugas', [KepalaController::class, 'storePetugas'])->name('petugas.store');
    Route::get('/petugas/{id}/edit', [KepalaController::class, 'editPetugas'])->name('petugas.edit');
    Route::put('/petugas/{id}', [KepalaController::class, 'updatePetugas'])->name('petugas.update');
    Route::delete('/petugas/{id}', [KepalaController::class, 'destroyPetugas'])->name('petugas.destroy');

    // Kelola Anggota
    Route::get('/anggota', [AnggotaController::class, 'indexKepala'])->name('anggota.index');
    Route::get('/anggota/{id}/edit', [AnggotaController::class, 'editKepala'])->name('anggota.edit');
    Route::put('/anggota/{id}', [AnggotaController::class, 'updateKepala'])->name('anggota.update');
});

// =============================================================
// DEBUG & PROFILE UMUM
// =============================================================
Route::get('/cek-role', function () { return auth()->user()->role; })->middleware('auth');
Route::get('/profile', [ProfileController::class, 'edit'])->middleware('auth')->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->middleware('auth')->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->middleware('auth')->name('profile.destroy');

require __DIR__.'/auth.php';