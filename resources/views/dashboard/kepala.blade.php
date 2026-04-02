@extends('layouts.kepala')

@section('title', 'Dashboard Kepala')

@section('content')

{{-- Judul --}}
<h1 class="text-xl font-semibold text-gray-800 mb-6">Dashboard</h1>

{{-- Kartu Statistik --}}
<div class="grid grid-cols-4 gap-4">
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-pink-500">
        <p class="text-sm text-gray-500">Total Buku</p>
        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalBuku }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-pink-400">
        <p class="text-sm text-gray-500">Total Anggota</p>
        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalAnggota }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-pink-300">
        <p class="text-sm text-gray-500">Total Petugas</p>
        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalPetugas }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-pink-200">
        <p class="text-sm text-gray-500">Peminjaman Aktif</p>
        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $peminjamanAktif }}</p>
    </div>
</div>

@endsection