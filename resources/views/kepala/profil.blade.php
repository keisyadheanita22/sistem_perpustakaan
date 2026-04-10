<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Kepala Perpustakaan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- NAVBAR: Menampilkan nama sistem dan foto/inisial kepala di pojok kanan atas --}}
    <nav class="px-8 h-14 flex items-center justify-between" style="background-color:#db2777;">
        <span class="text-white font-bold text-lg italic">Sistem Perpustakaan</span>

        {{-- Link ke halaman profil, menampilkan foto bulat atau inisial jika belum ada foto --}}
        <a href="{{ route('kepala.profil') }}" class="flex items-center gap-2 text-white text-sm hover:opacity-80">
            @if(Auth::user()->foto)
                {{-- Jika foto sudah diupload, tampilkan sebagai lingkaran --}}
                <img src="{{ asset('storage/' . Auth::user()->foto) }}"
                     style="width:32px; height:32px; border-radius:50%; object-fit:cover;">
            @else
                {{-- Jika belum ada foto, tampilkan inisial huruf pertama nama --}}
                <div style="width:32px; height:32px; border-radius:50%; background-color:#9d174d;
                            display:flex; align-items:center; justify-content:center;
                            font-size:14px; font-weight:700; color:white;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            @endif
            <span>{{ Auth::user()->name }}</span>
        </a>
    </nav>

    <div class="flex flex-1">

        {{-- SIDEBAR: Menu navigasi utama untuk kepala perpustakaan --}}
        <aside class="w-44 flex flex-col py-4 gap-2" style="background-color:#db2777; min-height: calc(100vh - 56px);">

            {{-- Menu navigasi antar halaman --}}
            <a href="{{ route('kepala.dashboard') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Dashboard</a>
            <a href="{{ route('kepala.petugas.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Data Petugas</a>
            <a href="{{ route('kepala.katalog') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Katalog Buku</a>
            <a href="{{ route('kepala.anggota.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Daftar Anggota</a>
            <a href="{{ route('kepala.laporan') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Laporan</a>

            {{-- Tombol logout di bagian paling bawah sidebar --}}
            <div class="mt-auto mx-3 pb-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 rounded text-white text-sm" style="background-color:#9d174d;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- MAIN CONTENT: Area utama halaman profil --}}
        <main class="flex-1 p-8">

            {{-- Tombol kembali ke dashboard --}}
            <a href="{{ route('kepala.dashboard') }}" class="text-pink-600 text-sm mb-6 inline-block hover:underline">← Kembali</a>

            {{-- NOTIFIKASI: Muncul setelah aksi berhasil (update profil / ganti password / update foto) --}}
            @if(session('success'))
                <div class="mb-4 px-4 py-3 rounded bg-green-100 text-green-700 text-sm border border-green-300">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex gap-6 items-start">

                {{-- KARTU KIRI: Menampilkan foto profil dan form untuk upload/ganti foto --}}
                <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center gap-3 w-56">

                    {{-- Foto profil bulat atau inisial nama jika belum ada foto --}}
                    @if($user->foto)
                        {{-- Tampilkan foto yang sudah diupload dalam bentuk lingkaran --}}
                        <img src="{{ asset('storage/' . $user->foto) }}"
                             style="width:96px; height:96px; border-radius:50%; object-fit:cover; border:4px solid #db2777;">
                    @else
                        {{-- Tampilkan lingkaran pink dengan inisial huruf pertama nama --}}
                        <div style="width:96px; height:96px; border-radius:50%; background-color:#db2777;
                                    display:flex; align-items:center; justify-content:center;
                                    font-size:2rem; font-weight:700; color:white;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif

                    {{-- Nama dan email kepala --}}
                    <p class="font-semibold text-gray-800 text-sm">{{ $user->name }}</p>
                    <p class="text-gray-400 text-xs">{{ $user->email }}</p>

                    {{-- Form upload foto: mengirim file ke controller updateFoto --}}
                    <form method="POST" action="{{ route('kepala.profil.foto') }}" enctype="multipart/form-data" class="w-full mt-2">
                        @csrf
                        {{-- Input file hanya menerima gambar (jpg, png, dll) --}}
                        <input type="file" name="foto" accept="image/*"
                               class="w-full text-xs text-gray-500 mb-2
                                      file:mr-2 file:py-1 file:px-3
                                      file:rounded file:border-0
                                      file:text-xs file:font-medium
                                      file:bg-pink-50 file:text-pink-700
                                      hover:file:bg-pink-100">
                        {{-- Pesan error jika file tidak valid (bukan gambar / ukuran terlalu besar) --}}
                        @error('foto')
                            <p class="text-red-500 text-xs mb-1">{{ $message }}</p>
                        @enderror
                        <button type="submit"
                                class="w-full py-2 rounded text-white text-sm font-medium hover:opacity-90"
                                style="background-color:#db2777;">
                            Update Foto
                        </button>
                    </form>
                </div>

                {{-- KARTU KANAN: Berisi form edit profil dan form ganti password --}}
                <div class="flex-1 flex flex-col gap-6">

                    {{-- FORM EDIT PROFIL: Mengubah nama dan email kepala --}}
                    <div class="bg-white rounded-xl shadow p-6">
                        <h2 class="text-base font-semibold text-gray-700 mb-4">Edit Profil</h2>

                        {{-- Form dikirim ke route kepala.profil.update dengan method PUT --}}
                        <form method="POST" action="{{ route('kepala.profil.update') }}">
                            @csrf
                            @method('PUT')

                            {{-- Input nama kepala --}}
                            <div class="mb-3">
                                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-300"
                                       placeholder="Nama">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Input email kepala --}}
                            <div class="mb-4">
                                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-300"
                                       placeholder="Email">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit"
                                    class="w-full py-2 rounded-lg text-white text-sm font-medium hover:opacity-90"
                                    style="background-color:#db2777;">
                                Simpan Perubahan
                            </button>
                        </form>
                    </div>

                    {{-- FORM GANTI PASSWORD: Mengubah password login kepala --}}
                    <div class="bg-white rounded-xl shadow p-6">
                        <h2 class="text-base font-semibold text-gray-700 mb-4">Ganti Password</h2>

                        {{-- Form dikirim ke route kepala.profil.password dengan method PUT --}}
                        <form method="POST" action="{{ route('kepala.profil.password') }}">
                            @csrf
                            @method('PUT')

                            {{-- Input password lama untuk verifikasi sebelum ganti --}}
                            <div class="mb-3">
                                <input type="password" name="password_lama"
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-300"
                                       placeholder="Password lama">
                                @error('password_lama')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Input password baru --}}
                            <div class="mb-3">
                                <input type="password" name="password"
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-300"
                                       placeholder="Password baru">
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Input konfirmasi password baru, harus sama dengan password baru --}}
                            <div class="mb-4">
                                <input type="password" name="password_confirmation"
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-300"
                                       placeholder="Konfirmasi password">
                            </div>

                            <button type="submit"
                                    class="w-full py-2 rounded-lg text-white text-sm font-medium hover:opacity-90"
                                    style="background-color:#9d174d;">
                                Ganti Password
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </main>
    </div>

</body>
</html>