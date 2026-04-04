<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- NAVBAR: Menampilkan nama sistem dan inisial user yang bisa diklik ke halaman profil --}}
    <nav class="px-8 h-14 flex items-center justify-between" style="background-color:#db2777;">
        <span class="text-white font-bold text-lg italic">Sistem Perpustakaan</span>

        {{-- Inisial huruf pertama nama user dalam lingkaran, ini halaman profil jadi tidak perlu link --}}
        <div class="flex items-center gap-2 text-white text-sm">
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold text-white"
                style="background-color:#9d174d;">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <span>{{ Auth::user()->name }}</span>
        </div>
    </nav>

    <div class="flex flex-1">

        {{-- SIDEBAR: Menu navigasi utama untuk anggota --}}
        <aside class="w-44 flex flex-col py-4 gap-2" style="background-color:#db2777; min-height: calc(100vh - 56px);">

            {{-- Menu Dashboard --}}
            <a href="{{ route('anggota.dashboard') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Dashboard</a>

            {{-- Menu Katalog Buku --}}
            <a href="{{ route('katalog.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Katalog Buku</a>

            {{-- Menu Peminjaman Saya --}}
            <a href="{{ route('peminjaman.saya') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Peminjaman Saya</a>

            {{-- Menu Denda Saya --}}
            <a href="{{ route('denda.saya') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Denda Saya</a>

            {{-- Tombol Logout di bagian bawah sidebar --}}
            <div class="mt-auto mx-3 pb-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 rounded text-white text-sm" style="background-color:#9d174d;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- KONTEN UTAMA --}}
        <main class="flex-1 p-8">

            {{-- JUDUL HALAMAN --}}
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Profil Saya</h1>
                <p class="text-gray-500 text-sm mt-1">Kelola informasi akun kamu</p>
            </div>

            {{-- NOTIFIKASI SUKSES: Muncul setelah berhasil update profil atau ganti password --}}
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm">
                {{ session('success') }}
            </div>
            @endif

            {{-- NOTIFIKASI ERROR: Menampilkan daftar error validasi --}}
            @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                <ul class="list-disc pl-4">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="grid grid-cols-2 gap-6">

                {{-- FORM EDIT PROFIL: Anggota bisa ubah nama, email, no telepon, username --}}
                <div class="bg-white rounded-xl shadow p-6">
                    <h2 class="text-base font-semibold text-gray-700 mb-4">✏️ Edit Profil</h2>
                    <form method="POST" action="{{ route('anggota.profil.update') }}">
                        @csrf
                        @method('PUT')

                        {{-- Input nama lengkap --}}
                        <div class="mb-4">
                            <label class="block text-sm text-gray-600 mb-1">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ Auth::user()->name }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:border-pink-400">
                        </div>

                        {{-- Input email --}}
                        <div class="mb-4">
                            <label class="block text-sm text-gray-600 mb-1">Email</label>
                            <input type="email" name="email" value="{{ Auth::user()->email }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:border-pink-400">
                        </div>

                        {{-- Input no telepon --}}
                        <div class="mb-4">
                            <label class="block text-sm text-gray-600 mb-1">No Telepon</label>
                            <input type="text" name="no_telepon" value="{{ Auth::user()->no_telepon }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:border-pink-400">
                        </div>

                        {{-- Input username --}}
                        <div class="mb-4">
                            <label class="block text-sm text-gray-600 mb-1">Username</label>
                            <input type="text" name="username" value="{{ Auth::user()->username }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:border-pink-400">
                        </div>

                        {{-- Tombol simpan perubahan profil --}}
                        <button type="submit" class="w-full py-2 rounded-lg text-white text-sm font-medium" style="background-color:#db2777;">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>

                {{-- FORM GANTI PASSWORD: Anggota bisa ganti password dengan verifikasi password lama --}}
                <div class="bg-white rounded-xl shadow p-6">
                    <h2 class="text-base font-semibold text-gray-700 mb-4">🔒 Ganti Password</h2>
                    <form method="POST" action="{{ route('anggota.profil.password') }}">
                        @csrf
                        @method('PUT')

                        {{-- Input password lama untuk verifikasi --}}
                        <div class="mb-4">
                            <label class="block text-sm text-gray-600 mb-1">Password Lama</label>
                            <input type="password" name="password_lama"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:border-pink-400"
                                placeholder="Masukkan password lama">
                        </div>

                        {{-- Input password baru --}}
                        <div class="mb-4">
                            <label class="block text-sm text-gray-600 mb-1">Password Baru</label>
                            <input type="password" name="password"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:border-pink-400"
                                placeholder="Masukkan password baru">
                        </div>

                        {{-- Input konfirmasi password baru, harus sama dengan password baru --}}
                        <div class="mb-6">
                            <label class="block text-sm text-gray-600 mb-1">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:border-pink-400"
                                placeholder="Ulangi password baru">
                        </div>

                        {{-- Tombol ganti password --}}
                        <button type="submit" class="w-full py-2 rounded-lg text-white text-sm font-medium" style="background-color:#9d174d;">
                            Ganti Password
                        </button>
                    </form>
                </div>

            </div>
        </main>
    </div>

</body>
</html>