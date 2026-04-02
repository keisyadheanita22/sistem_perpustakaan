@extends('layouts.kepala')

@section('title', 'Katalog Buku')

@section('content')

{{-- Judul --}}
<h1 class="text-2xl font-bold text-gray-800 mb-6">Katalog Buku</h1>

{{-- Filter & Search --}}
<div class="flex justify-end items-center mb-6">
    <form method="GET" action="{{ route('kepala.katalog') }}" class="flex items-center gap-2">
        {{-- Filter Kategori --}}
        <select name="kategori_id" onchange="this.form.submit()"
            class="border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none bg-white">
            <option value="">Semua Kategori</option>
            @foreach ($kategoris as $kategori)
                <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                    {{ $kategori->nama_kategori }}
                </option>
            @endforeach
        </select>

        {{-- Search --}}
        <div class="flex items-center border border-gray-300 rounded-lg px-3 py-2 text-sm gap-2 bg-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
            </svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Buku..." class="outline-none text-sm w-48">
        </div>
    </form>
</div>

{{-- Daftar Buku --}}
@if($bukus->isEmpty())
    <div class="flex flex-col items-center justify-center py-16 text-gray-400">
        <span class="text-5xl mb-3">📚</span>
        <span>Tidak ada data buku.</span>
    </div>
@else
    <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;">
        @foreach ($bukus as $buku)
        <div class="bg-white rounded-xl overflow-hidden shadow hover:shadow-md transition flex flex-col">

            {{-- Cover Buku --}}
            @if($buku->foto)
                <img src="{{ asset('storage/' . $buku->foto) }}" alt="{{ $buku->judul }}"
                    class="w-full object-cover" style="height:220px;">
            @else
                <div class="w-full flex flex-col items-center justify-center" style="height:220px; background: linear-gradient(135deg, #fce7f3, #fbcfe8);">
                    <span style="font-size:36px;">📚</span>
                    <span class="text-xs font-medium mt-1 px-2 text-center" style="color:#9d174d;">{{ Str::limit($buku->judul, 20) }}</span>
                </div>
            @endif

            {{-- Info Buku --}}
            <div class="p-4 flex flex-col flex-1">
                <p class="font-semibold text-gray-800 text-base truncate">{{ $buku->judul }}</p>
                <p class="text-sm text-gray-500 truncate">{{ $buku->pengarang }}</p>
                <p class="text-sm text-gray-500 truncate">{{ $buku->penerbit }}</p>

                {{-- Kategori --}}
                @if($buku->kategori)
                <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium mt-2" style="background:#fce7f3; color:#9d174d;">
                    {{ $buku->kategori->nama_kategori }}
                </span>
                @endif

                <p class="text-sm text-gray-400 mt-2">Stok: {{ $buku->stok }}</p>
            </div>

        </div>
        @endforeach
    </div>
@endif

@endsection