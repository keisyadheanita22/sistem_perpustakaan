<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Menampilkan daftar kategori + fitur search
     */
    public function index()
    {
        $search = request('search');

        // Ambil data kategori, jika ada search maka difilter
        $kategoris = Kategori::when($search, function ($query) use ($search) {
            $query->where('nama_kategori', 'like', '%' . $search . '%');
        })->get();

        return view('petugas.kategori.index', compact('kategoris'));
    }

    /**
     * Menampilkan halaman form tambah kategori
     */
    public function create()
    {
        return view('petugas.kategori.create');
    }

    /**
     * Menyimpan data kategori baru ke database
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_kategori' => 'required|unique:kategoris,nama_kategori'
        ]);

        // Simpan ke database
        Kategori::create($validated);

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Menampilkan halaman edit kategori
     */
    public function edit(Kategori $kategori)
    {
        return view('petugas.kategori.edit', compact('kategori'));
    }

    /**
     * Mengupdate data kategori
     */
    public function update(Request $request, Kategori $kategori)
    {
        // Validasi (biar gak bisa duplikat juga saat edit)
        $validated = $request->validate([
            'nama_kategori' => 'required|unique:kategoris,nama_kategori,' . $kategori->id
        ]);

        // Update data
        $kategori->update($validated);

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil diupdate!');
    }

    /**
     * Menghapus kategori
     */
    public function destroy(Kategori $kategori)
    {
        $kategori->delete();

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}