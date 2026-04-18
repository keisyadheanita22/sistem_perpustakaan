<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    // ===== Tampilkan semua data buku dengan fitur search dan filter kategori =====
    public function index(Request $request)
    {
        $bukus = Buku::with('kategori')
            ->when($request->search, function ($query) use ($request) {
                $query->where('judul', 'like', '%' . $request->search . '%')
                      ->orWhere('pengarang', 'like', '%' . $request->search . '%');
            })
            ->when($request->kategori_id, function ($query) use ($request) {
                $query->where('kategori_id', $request->kategori_id);
            })
            ->get();

        $kategoris = Kategori::all();

        return view('petugas.buku.index', compact('bukus', 'kategoris'));
    }

    // ===== Tampilkan form tambah buku baru =====
    public function create()
    {
        $kategoris = Kategori::all();
        return view('petugas.buku.create', compact('kategoris'));
    }

    // ===== Simpan data buku baru ke database =====
    public function store(Request $request)
    {
        $request->validate([
            'judul'       => 'required|unique:bukus,judul', 
            'pengarang'   => 'required',
            'penerbit'    => 'required',
            'kategori_id' => 'required',
            'stok'        => 'required|integer',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Ambil semua data kecuali foto
        $data = $request->except('foto');

        // Kalau ada foto yang diupload, simpan ke storage
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('buku', 'public');
        }

        Buku::create($data);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    // ===== Tampilkan form edit buku =====
    public function edit(Buku $buku)
    {
        $kategoris = Kategori::all();
        return view('petugas.buku.edit', compact('buku', 'kategoris'));
    }

    // ===== Simpan perubahan data buku =====
    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'judul'       => 'required',
            'pengarang'   => 'required',
            'penerbit'    => 'required',
            'kategori_id' => 'required',
            'stok'        => 'required|integer',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Ambil semua data kecuali foto
        $data = $request->except('foto');

        // Kalau ada foto baru, hapus foto lama lalu simpan yang baru
        if ($request->hasFile('foto')) {
            if ($buku->foto) {
                Storage::disk('public')->delete($buku->foto);
            }
            $data['foto'] = $request->file('foto')->store('buku', 'public');
        }

        $buku->update($data);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diupdate!');
    }

    // ===== Hapus data buku dari database =====
    public function destroy(Buku $buku)
    {
        // Hapus foto dari storage kalau ada
        if ($buku->foto) {
            Storage::disk('public')->delete($buku->foto);
        }

        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus!');
    }
}