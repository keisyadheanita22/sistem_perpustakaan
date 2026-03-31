<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Perpustakaan Digital</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- Navbar --}}
    <nav class="bg-pink-500 px-8 h-14 flex items-center">
        <span class="text-white font-bold text-lg">Perpustakaan Digital</span>
    </nav>

    {{-- Main --}}
    <main class="flex-1 flex items-center justify-center">
        <div class="bg-white rounded-2xl shadow-lg p-10 w-full" style="max-width:420px">

            <h1 class="text-2xl font-semibold text-center text-gray-800 mb-1">Login</h1>
            <p class="text-center text-gray-400 text-sm mb-6">Selamat Datang Silahkan Masukan Username dan Password<br>anda untuk melakukan login</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Username --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </span>
                        <input type="text" name="email" value="{{ old('email') }}"
                            class="w-full border border-gray-300 rounded-lg pl-9 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400"
                            placeholder="Masukkan Username Anda"/>
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </span>
                        <input type="password" name="password"
                            class="w-full border border-gray-300 rounded-lg pl-9 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400"
                            placeholder="Masukkan Password Anda"/>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Lupa Password --}}
                <div class="text-right mb-5">
                    <a href="{{ route('password.request') }}" class="text-pink-500 text-sm hover:underline">Lupa password?</a>
                </div>

                {{-- Tombol Masuk --}}
                <button type="submit"
                    class="w-full bg-pink-500 hover:bg-pink-600 text-white font-semibold py-2 rounded-lg transition">
                    Masuk
                </button>

                {{-- Daftar --}}
                <p class="text-center text-sm text-gray-500 mt-4">
                    Belum mempunyai akun?
                    <a href="{{ route('register') }}" class="text-pink-500 font-medium hover:underline">Daftar sekarang</a>
                </p>

            </form>
        </div>
    </main>

</body>
</html>