<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KatalogController extends Controller
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

        return view('anggota.katalog.index', compact('bukus', 'kategoris'));
    }
}