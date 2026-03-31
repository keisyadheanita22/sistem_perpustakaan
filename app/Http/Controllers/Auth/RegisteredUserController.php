<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Anggota;
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
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'no_telepon'  => ['required', 'string', 'max:20'],
            'alamat'      => ['required', 'string'],
            'username'    => ['required', 'string', 'max:50', 'unique:anggotas,username'],
            'password'    => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'anggota',
        ]);

        // Hitung ID anggota otomatis
        $lastAnggota = Anggota::orderBy('id', 'desc')->first();
        $newNumber = $lastAnggota ? (int)substr($lastAnggota->id_anggota, 2) + 1 : 1;
        $idAnggota = 'AG' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        // Simpan ke tabel anggotas
        Anggota::create([
            'id_anggota' => $idAnggota,
            'nama'       => $request->name,
            'email'      => $request->email,
            'no_telepon' => $request->no_telepon,
            'alamat'     => $request->alamat,
            'username'   => $request->username,
            'password'   => Hash::make($request->password),
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}