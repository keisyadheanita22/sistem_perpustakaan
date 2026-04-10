<?php

namespace App\Providers;

use App\Models\Peminjaman;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Kirim variabel $perluVerifikasi ke semua view (pakai * supaya kena semua halaman)
        // Supaya badge notifikasi di sidebar muncul di dashboard maupun halaman lainnya
        View::composer('*', function ($view) {

            // Pastikan user sudah login sebelum query ke database
            if (auth()->check()) {

                // Hitung peminjaman yang statusnya 'menunggu' atau 'mengembalikan'
                // Karena dua status ini yang perlu diverifikasi oleh petugas
                $perluVerifikasi = Peminjaman::whereIn('status', ['menunggu', 'mengembalikan'])->count();

                // Kirim hasilnya ke view dengan nama variabel $perluVerifikasi
                $view->with('perluVerifikasi', $perluVerifikasi);
            }
        });
    }
}   