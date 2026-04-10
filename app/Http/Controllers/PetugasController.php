<?php

namespace App\Http\Controllers\Kepala;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    /**
     * Menampilkan daftar semua petugas
     */
    public function index()
    {
        // Ambil semua user dengan role 'petugas', urut terbaru
        $petugas = User::where('role', 'petugas')->latest()->get();

        // Kirim data ke view
        return view('kepala.petugas.index', compact('petugas'));
    }

    /**
     * Menampilkan form tambah petugas
     */
    public function create()
    {
        // Tampilkan halaman form tambah petugas
        return view('kepala.petugas.create');
    }

    /**
     * Menyimpan akun petugas baru ke database
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            // Pesan error custom
            'name.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.unique'       => 'Email sudah digunakan.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // Simpan data ke database
        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']), // Enkripsi password
            'role'     => 'petugas', // Set role otomatis
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('kepala.petugas.index')
            ->with('success', 'Akun petugas berhasil dibuat!');
    }

    /**
     * Menghapus akun petugas dari database
     */
    public function destroy($id)
    {
        // Cari user berdasarkan ID, jika tidak ada -> 404
        $petugas = User::findOrFail($id);

        // Cegah user menghapus akunnya sendiri
        if ($petugas->id === auth()->id()) {
            return redirect()->route('kepala.petugas.index')
                ->with('error', 'Tidak bisa menghapus akun sendiri!');
        }

        // Pastikan yang dihapus adalah role petugas
        if ($petugas->role !== 'petugas') {
            return redirect()->route('kepala.petugas.index')
                ->with('error', 'Hanya akun petugas yang bisa dihapus!');
        }

        // Hapus data
        $petugas->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('kepala.petugas.index')
            ->with('success', 'Petugas berhasil dihapus!');
    }
}