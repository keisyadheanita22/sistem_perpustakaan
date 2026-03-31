<?php
 
namespace App\Http\Controllers;
 
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
 
class BukuController extends Controller
{
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
 
    public function create()
    {
        $kategoris = Kategori::all();
        return view('petugas.buku.create', compact('kategoris'));
    }
 
    public function store(Request $request)
    {
        $request->validate([
            'judul'       => 'required',
            'pengarang'   => 'required',
            'penerbit'    => 'required',
            'kategori_id' => 'required',
            'stok'        => 'required|integer',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
 
        $data = $request->except('foto');
 
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('buku', 'public');
        }
 
        Buku::create($data);
 
        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan!');
    }
 
    public function edit(Buku $buku)
    {
        $kategoris = Kategori::all();
        return view('petugas.buku.edit', compact('buku', 'kategoris'));
    }
 
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
 
        $data = $request->except('foto');
 
        if ($request->hasFile('foto')) {
            if ($buku->foto) {
                Storage::disk('public')->delete($buku->foto);
            }
            $data['foto'] = $request->file('foto')->store('buku', 'public');
        }
 
        $buku->update($data);
 
        return redirect()->route('buku.index')->with('success', 'Buku berhasil diupdate!');
    }
 
    public function destroy(Buku $buku)
    {
        if ($buku->foto) {
            Storage::disk('public')->delete($buku->foto);
        }
        $buku->delete();
        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus!');
    }
}