<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Anggota</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <nav class="px-8 h-14 flex items-center justify-between" style="background-color:#db2777;">
        <span class="text-white font-bold text-lg italic">Sistem Perpustakaan</span>

        <a href="{{ route('petugas.profil') }}" class="flex items-center gap-2 text-white text-sm hover:opacity-80">
            @if(Auth::user()->foto)
                <img src="{{ asset('storage/' . Auth::user()->foto) }}"
                     class="w-8 h-8 rounded-full object-cover">
            @else
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold text-white"
                    style="background-color:#9d174d;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            @endif
            <span>{{ Auth::user()->name }}</span>
        </a>
    </nav>

    <div class="flex flex-1">
        <aside class="w-44 flex flex-col py-4 gap-2" style="background-color:#db2777; min-height: calc(100vh - 56px);">
            <a href="{{ route('petugas.dashboard') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Dashboard</a>
            <a href="{{ route('buku.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Data Buku</a>
            <a href="{{ route('anggota.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center font-bold" style="background-color:#831843;">Data Anggota</a>
            <a href="{{ route('peminjaman.index') }}"
                class="mx-3 px-4 py-2 rounded text-white text-sm text-center flex items-center justify-center gap-2"
                style="background-color:#9d174d;">
                    Peminjaman
                    @if(!empty($perluVerifikasi) && $perluVerifikasi > 0)
                        <span style="background-color:white; color:#db2777;"
                            class="text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center leading-none">
                            {{ $perluVerifikasi > 9 ? '9+' : $perluVerifikasi }}
                        </span>
                    @endif
                </a>
            <a href="{{ route('kategori.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Kategori</a>
            <a href="{{ route('denda.index') }}" class="mx-3 px-4 py-2 rounded text-white text-sm text-center" style="background-color:#9d174d;">Denda</a>
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

        <main class="flex-1 p-8">
            <div class="flex items-center gap-3 mb-6">
                <a href="{{ route('anggota.index') }}" class="text-pink-600 hover:text-pink-800 text-sm flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Kembali
                </a>
                <h1 class="text-2xl font-bold text-gray-800">Edit Anggota</h1>
            </div>

            @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="bg-white rounded-xl shadow p-6 max-w-lg">
                <form action="{{ route('anggota.update', $anggota->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- ID Anggota (readonly) --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-600 mb-1">ID Anggota</label>
                        <input type="text" value="{{ $anggota->id_anggota ?? '-' }}"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50 text-gray-400 cursor-not-allowed"
                            readonly>
                    </div>

                    {{-- Nama --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Nama</label>
                        <input type="text" name="name" value="{{ old('name', $anggota->name) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-300"
                            required>
                    </div>

                    {{-- Email --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', $anggota->email) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-300"
                            required>
                    </div>

                    {{-- No Telepon --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-600 mb-1">No Telepon</label>
                        <input type="text" name="no_telepon" value="{{ old('no_telepon', $anggota->no_telepon) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-300">
                    </div>

                    {{-- Username --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Username</label>
                        <input type="text" name="username" value="{{ old('username', $anggota->username) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-300">
                    </div>

                    {{-- Password --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-600 mb-1">
                            Password Baru
                            <span class="text-gray-400 font-normal">(kosongkan jika tidak diubah)</span>
                        </label>
                        <div class="flex gap-2">
                            <input type="password" name="password" id="passwordInput"
                                placeholder="Masukkan password baru..."
                                class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-300">
                            <button type="button" onclick="resetPassword()"
                                class="px-3 py-2 rounded-lg text-white text-xs font-medium"
                                style="background-color:#db2777;">
                                Reset Default
                            </button>
                        </div>
                        <p id="pwdHint" class="text-xs text-gray-400 mt-1 hidden">
                            Password direset ke: <strong>12345678</strong> — minta anggota ganti setelah login.
                        </p>
                    </div>

                    {{-- Tombol --}}
                    <div class="flex gap-3">
                        <a href="{{ route('anggota.index') }}"
                            class="px-5 py-2 rounded-lg border border-gray-300 text-sm text-gray-600 hover:bg-gray-50">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-5 py-2 rounded-lg text-white text-sm font-medium hover:opacity-90"
                            style="background-color:#db2777;">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        function resetPassword() {
            const input = document.getElementById('passwordInput');
            const hint = document.getElementById('pwdHint');
            input.value = '12345678';
            input.type = 'text';
            hint.classList.remove('hidden');
            setTimeout(() => {
                input.type = 'password';
            }, 3000);
        }
    </script>

</body>
</html>