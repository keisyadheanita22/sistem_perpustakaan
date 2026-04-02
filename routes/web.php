<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\DendaController;
use App\Http\Controllers\Anggota\KatalogController;
use App\Http\Controllers\KepalaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/anggota', function () {
        return view('dashboard.anggota');
    })->name('anggota.dashboard');

    Route::get('/dashboard/petugas', function () {
        return view('dashboard.petugas');
    })->name('petugas.dashboard');

   Route::get('/dashboard/kepala', [KepalaController::class, 'dashboard'])
    ->name('kepala.dashboard')
    ->middleware('role:kepala');

    // Route Buku - petugas
    Route::resource('buku', BukuController::class);
    // Route Katalog & Peminjaman anggota - harus sebelum resource peminjaman!
    Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');
    Route::get('/peminjaman/saya', [PeminjamanController::class, 'peminjamanSaya'])->name('peminjaman.saya');
    Route::post('/peminjaman/pinjam/{buku}', [PeminjamanController::class, 'pinjam'])
        ->name('peminjaman.pinjam')
    ->middleware('role:anggota');

    // Route Kembalikan & Batalkan - khusus anggota
    Route::post('/peminjaman/{id}/kembalikan', [PeminjamanController::class, 'kembalikan'])
        ->name('peminjaman.kembalikan')
        ->middleware('role:anggota');

    Route::post('/peminjaman/{id}/batalkan', [PeminjamanController::class, 'batalkan'])
    ->name('peminjaman.batalkan')
    ->middleware('role:anggota');   

    Route::post('/peminjaman/{id}/verifikasi', [PeminjamanController::class, 'verifikasi']) // ✅ tambah ini
    ->name('peminjaman.verifikasi')
    ->middleware('role:petugas');
    // Route Anggota - hanya petugas
    Route::get('/anggota', [AnggotaController::class, 'index'])->middleware('role:petugas')->name('anggota.index');

    // Route Kategori
    Route::resource('kategori', KategoriController::class);

    // Route Peminjaman
    Route::resource('peminjaman', PeminjamanController::class);

    // Route Denda
    Route::get('/denda/saya', [DendaController::class, 'dendaSaya'])->name('denda.saya');
    Route::get('/denda/pengaturan', [DendaController::class, 'pengaturan'])->name('denda.pengaturan');
    Route::post('/denda/pengaturan', [DendaController::class, 'updatePengaturan'])->name('denda.updatePengaturan');
    Route::get('/denda', [DendaController::class, 'index'])->name('denda.index');
    Route::post('/denda/{id}/konfirmasi', [DendaController::class, 'konfirmasi'])->name('denda.konfirmasi');
    });

    Route::get('/kepala/katalog', [KepalaController::class, 'katalog'])
    ->name('kepala.katalog')
    ->middleware('role:kepala');
    Route::get('/cek-role', function () {
    return auth()->user()->role;
    });

    Route::get('/kepala/laporan', [KepalaController::class, 'laporan'])
    ->name('kepala.laporan')
    ->middleware('role:kepala');

    Route::get('/kepala/laporan/pdf', [KepalaController::class, 'exportPdf'])->name('kepala.laporan.pdf')->middleware('role:kepala');
Route::get('/kepala/laporan/excel', [KepalaController::class, 'exportExcel'])->name('kepala.laporan.excel')->middleware('role:kepala');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';