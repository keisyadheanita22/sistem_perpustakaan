<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    public function index(Request $request)
{
    $anggota = \App\Models\User::where('role', 'anggota')
        ->when($request->search, function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        })->get();

    return view('petugas.anggota.index', compact('anggota'));
}
    public function create()
    {
        return view('petugas.anggota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_anggota' => 'required|unique:anggotas',
            'nama'       => 'required',
            'email'      => 'required|email|unique:anggotas',
            'no_telepon' => 'required',
            'alamat'     => 'required',
            'username'   => 'required|unique:anggotas',
            'password'   => 'required|min:6',
        ]);

        Anggota::create([
            'id_anggota' => $request->id_anggota,
            'nama'       => $request->nama,
            'email'      => $request->email,
            'no_telepon' => $request->no_telepon,
            'alamat'     => $request->alamat,
            'username'   => $request->username,
            'password'   => Hash::make($request->password),
        ]);

        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil ditambahkan!');
    }

    public function edit(Anggota $anggota)
    {
        return view('petugas.anggota.edit', compact('anggota'));
    }

    public function update(Request $request, Anggota $anggota)
    {
        $request->validate([
            'id_anggota' => 'required|unique:anggotas,id_anggota,' . $anggota->id,
            'nama'       => 'required',
            'email'      => 'required|email|unique:anggotas,email,' . $anggota->id,
            'no_telepon' => 'required',
            'alamat'     => 'required',
            'username'   => 'required|unique:anggotas,username,' . $anggota->id,
        ]);

        $data = [
            'id_anggota' => $request->id_anggota,
            'nama'       => $request->nama,
            'email'      => $request->email,
            'no_telepon' => $request->no_telepon,
            'alamat'     => $request->alamat,
            'username'   => $request->username,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $anggota->update($data);

        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil diupdate!');
    }

    public function destroy(Anggota $anggota)
    {
        $anggota->delete();
        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil dihapus!');
    }
}