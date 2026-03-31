<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — Perpustakaan Digital</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <nav class="px-8 h-14 flex items-center" style="background-color:#db2777;">
        <span class="text-white font-bold text-lg italic">Perpustakaan Digital</span>
    </nav>

    <main class="flex-1 flex items-center justify-center py-10">
        <div class="bg-white rounded-2xl shadow-lg p-10 w-full" style="max-width:480px">

            <h1 class="text-2xl font-semibold text-center text-gray-800 mb-1">Daftar Akun</h1>
            <p class="text-center text-gray-400 text-sm mb-6">Lengkapi data berikut untuk membuat akun baru</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400"
                        placeholder="Masukkan Nama Lengkap"/>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400"
                        placeholder="Masukkan Email"/>
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">No Telepon</label>
                    <input type="text" name="no_telepon" value="{{ old('no_telepon') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400"
                        placeholder="Contoh: 08123456789"/>
                    @error('no_telepon') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <textarea name="alamat" rows="2"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400"
                        placeholder="Masukkan Alamat Lengkap">{{ old('alamat') }}</textarea>
                    @error('alamat') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <input type="text" name="username" value="{{ old('username') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400"
                        placeholder="Masukkan Username"/>
                    @error('username') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400"
                        placeholder="Masukkan Password"/>
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400"
                        placeholder="Ulangi Password"/>
                </div>

                <button type="submit"
                    class="w-full text-white font-semibold py-2 rounded-lg transition" style="background-color:#db2777;">
                    Daftar
                </button>

                <p class="text-center text-sm text-gray-500 mt-4">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-medium hover:underline" style="color:#db2777;">Masuk sekarang</a>
                </p>

            </form>
        </div>
    </main>

</body>
</html>