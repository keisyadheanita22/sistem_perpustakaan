<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
// ✅ Hapus: use App\Models\Anggota; — sudah tidak diperlukan
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    // ===== Tampilkan halaman form register =====
    public function create(): View
    {
        return view('auth.register');
    }

    // ===== Proses data register dan simpan ke database =====
    public function store(Request $request): RedirectResponse
    {
        // Validasi semua input dari form register
        $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'no_telepon'  => ['required', 'string', 'max:20'],
            'alamat'      => ['required', 'string'],
            'username'    => ['required', 'string', 'max:50', 'unique:users,username'],
            'password'    => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Generate ID anggota otomatis: AG001, AG002, dst
        // Ambil id_anggota terbesar yang sudah ada, lalu tambah 1
        $lastUser  = User::whereNotNull('id_anggota')
                         ->orderByRaw('CAST(SUBSTRING(id_anggota, 3) AS UNSIGNED) DESC')
                         ->first();
        $newNumber = $lastUser ? (int) substr($lastUser->id_anggota, 2) + 1 : 1;
        $idAnggota = 'AG' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        // ✅ Simpan HANYA ke tabel users (tabel anggotas sudah tidak dipakai)
        $user = User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'role'        => 'anggota',
            'id_anggota'  => $idAnggota,
            'no_telepon'  => $request->no_telepon,
            'alamat'      => $request->alamat,   // ✅ alamat disimpan di users
            'username'    => $request->username,
        ]);

        // Trigger event Registered (untuk verifikasi email dsb)
        event(new Registered($user));

        // Login otomatis setelah register berhasil
        Auth::login($user);

        // Redirect ke dashboard sesuai role
        return redirect(RouteServiceProvider::redirectTo());
    }
}