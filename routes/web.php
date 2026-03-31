<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\DendaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard per role
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/anggota', function () {
        return view('dashboard.anggota');
    })->name('anggota.dashboard');

    Route::get('/dashboard/petugas', function () {
        return view('dashboard.petugas');
    })->name('petugas.dashboard');

    Route::get('/dashboard/kepala', function () {
        return view('dashboard.kepala');
    })->name('kepala.dashboard');

    // Route Buku
    Route::resource('buku', BukuController::class);

    // Route Anggota
    Route::resource('anggota', AnggotaController::class);

    // Route Kategori
    Route::resource('kategori', KategoriController::class);

    // Route Peminjaman
    Route::resource('peminjaman', PeminjamanController::class);

    // Route Denda
    Route::get('/denda/pengaturan', [DendaController::class, 'pengaturan'])->name('denda.pengaturan');
    Route::post('/denda/pengaturan', [DendaController::class, 'updatePengaturan'])->name('denda.updatePengaturan');
    Route::get('/denda', [DendaController::class, 'index'])->name('denda.index');
    Route::post('/denda/{id}/konfirmasi', [DendaController::class, 'konfirmasi'])->name('denda.konfirmasi');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';