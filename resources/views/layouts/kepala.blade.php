<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">

    <div class="flex min-h-screen">
        <aside class="w-64 bg-white shadow-md border-r border-gray-200">
            <div class="p-6">
                <h2 class="text-xl font-bold text-pink-600 uppercase tracking-wider">SIPUS</h2>
            </div>
            
            <nav class="mt-2">
                <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-pink-50 hover:text-pink-600 transition-colors">
                    <i class="fas fa-home w-5 mr-3"></i> Dashboard
                </a>
                
                <a href="{{ route('petugas.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-pink-50 hover:text-pink-600 transition-colors">
                    <i class="fas fa-user-shield w-5 mr-3"></i> Data Petugas
                </a>
                
                <a href="{{ route('anggota.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-pink-50 hover:text-pink-600 transition-colors">
                    <i class="fas fa-users w-5 mr-3"></i> Daftar Anggota
                </a>
                
                <a href="{{ route('buku.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-pink-50 hover:text-pink-600 transition-colors">
                    <i class="fas fa-book w-5 mr-3"></i> Katalog Buku
                </a>
                
                <a href="{{ route('laporan.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-pink-50 hover:text-pink-600 transition-colors">
                    <i class="fas fa-file-alt w-5 mr-3"></i> Laporan
                </a>

                <div class="mt-10 px-6">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center text-red-500 hover:text-red-700">
                            <i class="fas fa-sign-out-alt w-5 mr-3"></i> Logout
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <main class="flex-1 p-10">
            @yield('content')
        </main>
    </div>

</body>
</html>