<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Petugas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

{{-- ===================== NAVBAR ===================== --}}
<nav class="px-8 h-14 flex items-center justify-between" style="background-color:#db2777;">
    <span class="text-white font-bold text-lg italic">Sistem Perpustakaan</span>

    {{-- Avatar: tampilkan foto jika ada, jika tidak tampilkan inisial nama --}}
    <a href="{{ route('kepala.profil') }}" class="flex items-center gap-2 text-white text-sm hover:opacity-80">
        @if(Auth::user()->foto)
            <img src="{{ asset('storage/' . Auth::user()->foto) }}"
                 style="width:32px; height:32px; border-radius:50%; object-fit:cover;">
        @else
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

    {{-- ===================== SIDEBAR ===================== --}}
    {{-- Menu aktif ditandai warna lebih gelap (#831843) dan font-bold --}}
    <aside class="w-44 flex flex-col py-4 gap-2"
        style="background-color:#db2777; min-height: calc(100vh - 56px);">

        <a href="{{ route('kepala.dashboard') }}"
            class="mx-3 px-4 py-2 rounded text-white text-sm text-center {{ request()->routeIs('kepala.dashboard') ? 'font-bold' : '' }}"
            style="background-color: {{ request()->routeIs('kepala.dashboard') ? '#831843' : '#9d174d' }};">
            Dashboard
        </a>

        {{-- Menu ini aktif karena kita sedang di halaman Edit Petugas --}}
        <a href="{{ route('kepala.petugas.index') }}"
            class="mx-3 px-4 py-2 rounded text-white text-sm text-center {{ request()->routeIs('kepala.petugas.*') ? 'font-bold' : '' }}"
            style="background-color: {{ request()->routeIs('kepala.petugas.*') ? '#831843' : '#9d174d' }};">
            Data Petugas
        </a>

        <a href="{{ route('kepala.katalog') }}"
            class="mx-3 px-4 py-2 rounded text-white text-sm text-center {{ request()->routeIs('kepala.katalog') ? 'font-bold' : '' }}"
            style="background-color: {{ request()->routeIs('kepala.katalog') ? '#831843' : '#9d174d' }};">
            Katalog Buku
        </a>

        <a href="{{ route('kepala.anggota.index') }}"
            class="mx-3 px-4 py-2 rounded text-white text-sm text-center {{ request()->routeIs('kepala.anggota.*') ? 'font-bold' : '' }}"
            style="background-color: {{ request()->routeIs('kepala.anggota.*') ? '#831843' : '#9d174d' }};">
            Daftar Anggota
        </a>

        <a href="{{ route('kepala.laporan') }}"
            class="mx-3 px-4 py-2 rounded text-white text-sm text-center {{ request()->routeIs('kepala.laporan') ? 'font-bold' : '' }}"
            style="background-color: {{ request()->routeIs('kepala.laporan') ? '#831843' : '#9d174d' }};">
            Laporan
        </a>

        {{-- Tombol logout di paling bawah sidebar --}}
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

    {{-- ===================== KONTEN UTAMA ===================== --}}
    {{-- items-center justify-center supaya card selalu berada di tengah area konten --}}
    <main class="flex-1 flex flex-col items-center justify-center p-8">

        {{-- Lebar card dibatasi max-w-lg, w-full agar tetap responsif --}}
        <div class="w-full max-w-lg">

            {{-- Judul halaman --}}
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Petugas</h1>

            {{-- Card form --}}
            <div class="bg-white rounded-xl shadow p-6">

                {{-- Daftar error validasi dari server, muncul jika ada input yang tidak valid --}}
                @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- FORM EDIT PETUGAS: kirim data ke PetugasController@update via PUT --}}
                <form method="POST" action="{{ route('kepala.petugas.update', $petugas->id) }}">
                    @csrf
                    @method('PUT')

                    {{-- Input nama lengkap, diisi otomatis dengan data petugas saat ini --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        {{-- old() prioritaskan nilai lama jika validasi gagal, fallback ke data petugas --}}
                        <input type="text" name="name" value="{{ old('name', $petugas->name) }}"
                            placeholder="Masukkan nama petugas"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:border-pink-400 focus:ring-1 focus:ring-pink-200"
                            required>
                    </div>

                    {{-- Input email, diisi otomatis dengan data petugas saat ini --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', $petugas->email) }}"
                            placeholder="Masukkan email petugas"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:border-pink-400 focus:ring-1 focus:ring-pink-200"
                            required>
                    </div>

                    {{-- Input password baru: opsional, kosongkan jika tidak ingin mengubah --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Password Baru
                            <span class="text-gray-400 font-normal">(kosongkan jika tidak diubah)</span>
                        </label>
                        <div class="flex gap-2">
                            <input type="password" name="password" id="passwordInput"
                                placeholder="Masukkan password baru..."
                                class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:border-pink-400 focus:ring-1 focus:ring-pink-200">
                            {{-- Tombol reset: isi otomatis password ke nilai default "12345678" --}}
                            <button type="button" onclick="resetPassword()"
                                class="px-3 py-2 rounded-lg text-white text-xs font-medium"
                                style="background-color:#db2777;">
                                Reset Default
                            </button>
                        </div>
                        {{-- Hint muncul 3 detik setelah klik Reset Default, lalu input kembali jadi password --}}
                        <p id="pwdHint" class="text-xs text-gray-400 mt-1 hidden">
                            Password direset ke: <strong>12345678</strong> — minta petugas ganti setelah login.
                        </p>
                    </div>

                    {{-- Tombol simpan dan batal --}}
                    <div class="flex gap-3 mt-6">
                        <button type="submit" class="text-white px-5 py-2 rounded text-sm font-medium" style="background-color:#db2777;">
                            Simpan Perubahan
                        </button>
                        {{-- Batal: kembali ke halaman daftar petugas tanpa menyimpan --}}
                        <a href="{{ route('kepala.petugas.index') }}" class="px-5 py-2 rounded text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200">
                            Batal
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </main>
</div>

{{-- JAVASCRIPT: isi input password dengan nilai default dan tampilkan hint sementara --}}
<script>
    function resetPassword() {
        const input = document.getElementById('passwordInput');
        const hint  = document.getElementById('pwdHint');

        // Tampilkan password default sebentar, lalu sembunyikan lagi setelah 3 detik
        input.value = '12345678';
        input.type  = 'text';
        hint.classList.remove('hidden');

        setTimeout(() => {
            input.type = 'password';
        }, 3000);
    }
</script>

</body>
</html>