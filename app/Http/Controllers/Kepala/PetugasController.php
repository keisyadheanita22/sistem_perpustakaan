
<?php

namespace App\Http\Controllers\Kepala;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    // Menampilkan daftar semua petugas
    public function index()
    {
        $petugas = User::where('role', 'petugas')->latest()->get();
        return view('kepala.petugas.index', compact('petugas'));
    }

    // Menampilkan form tambah petugas
    public function create()
    {
        return view('kepala.petugas.create');
    }

    // Menyimpan akun petugas baru ke database
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            // Pesan error custom dalam bahasa Indonesia
            'name.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.unique'       => 'Email sudah digunakan.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // Simpan petugas baru dengan role otomatis 'petugas'
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password), // Enkripsi password
            'role'     => 'petugas',
        ]);

        return redirect()->route('kepala.petugas.index')
            ->with('success', 'Akun petugas berhasil dibuat!');
    }

    // Menghapus akun petugas dari database
    public function destroy($id)
    {
        $petugas = User::findOrFail($id); // Cari petugas, 404 jika tidak ada

        // Cegah kepala menghapus akunnya sendiri
        if ($petugas->id === auth()->id()) {
            return redirect()->route('kepala.petugas.index')
                ->with('error', 'Tidak bisa menghapus akun sendiri!');
        }

        $petugas->delete();

        return redirect()->route('kepala.petugas.index')
            ->with('success', 'Petugas berhasil dihapus!');
    }
}