<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Perpustakaan Digital</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,700;1,500&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
</head>
<body style="margin:0;padding:0;font-family:'DM Sans',sans-serif;background-color:#fce7f3;min-height:100vh;display:flex;flex-direction:column;overflow-x:hidden;">

    <!-- Navbar (sama seperti register) -->
    <nav style="padding:0 2rem;height:56px;display:flex;align-items:center;background-color:#db2777;position:relative;z-index:10;">
        <span style="color:white;font-weight:700;font-size:1.125rem;font-style:italic;">Perpustakaan Digital</span>
    </nav>

    <!-- Main -->
    <main style="flex:1;display:flex;align-items:center;justify-content:center;padding:2.5rem 1rem;position:relative;z-index:1;">
        <div style="width:100%;max-width:440px;">

            <!-- Ilustrasi buku -->
            <div style="display:flex;gap:4px;align-items:flex-end;margin-bottom:1.25rem;">
                <div style="width:22px;height:52px;background:#f9a8d4;border-radius:3px 5px 5px 3px;position:relative;"><div style="position:absolute;left:0;top:0;bottom:0;width:5px;background:rgba(0,0,0,0.1);border-radius:3px 0 0 3px;"></div></div>
                <div style="width:18px;height:66px;background:#db2777;border-radius:3px 5px 5px 3px;position:relative;"><div style="position:absolute;left:0;top:0;bottom:0;width:5px;background:rgba(0,0,0,0.15);border-radius:3px 0 0 3px;"></div></div>
                <div style="width:20px;height:46px;background:#fbcfe8;border-radius:3px 5px 5px 3px;position:relative;"><div style="position:absolute;left:0;top:0;bottom:0;width:5px;background:rgba(0,0,0,0.08);border-radius:3px 0 0 3px;"></div></div>
                <div style="width:16px;height:58px;background:#ec4899;border-radius:3px 5px 5px 3px;position:relative;"><div style="position:absolute;left:0;top:0;bottom:0;width:5px;background:rgba(0,0,0,0.12);border-radius:3px 0 0 3px;"></div></div>
                <div style="width:22px;height:40px;background:#fda4af;border-radius:3px 5px 5px 3px;position:relative;"><div style="position:absolute;left:0;top:0;bottom:0;width:5px;background:rgba(0,0,0,0.09);border-radius:3px 0 0 3px;"></div></div>
            </div>

            <!-- Heading -->
            <p style="font-size:0.72rem;letter-spacing:0.18em;text-transform:uppercase;color:#db2777;font-weight:500;margin:0 0 4px;">Selamat Datang</p>
            <h1 style="font-family:'Playfair Display',serif;font-size:1.9rem;color:#1a1014;line-height:1.2;margin:0 0 6px;">Masuk ke <em style="font-style:italic;color:#db2777;">Akunmu</em></h1>
            <p style="font-size:0.875rem;color:#9d7f8a;margin:0 0 1.75rem;">Masukkan username dan password untuk melanjutkan.</p>

            <!-- Card -->
            <div style="background:white;border-radius:20px;padding:2rem 2.25rem;box-shadow:0 8px 32px rgba(219,39,119,0.18),0 2px 8px rgba(0,0,0,0.08);border:1px solid #f3e8ee;">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Username / Email -->
                    <div style="margin-bottom:1rem;">
                        <label style="display:block;font-size:0.78rem;font-weight:500;color:#5a4050;margin-bottom:5px;">Username / Email</label>
                        <div style="position:relative;">
                            <svg style="position:absolute;left:11px;top:50%;transform:translateY(-50%);width:15px;height:15px;color:#d4a0b8;pointer-events:none;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <input type="text" name="login" value="{{ old('login') }}" placeholder="Username atau Email"
                                style="width:100%;border:1.5px solid #f0dce7;border-radius:10px;padding:9px 12px 9px 34px;font-size:0.875rem;font-family:'DM Sans',sans-serif;color:#1a1014;background:#fffbfd;outline:none;box-sizing:border-box;"
                                onfocus="this.style.borderColor='#db2777';this.style.boxShadow='0 0 0 3px rgba(219,39,119,0.1)';"
                                onblur="this.style.borderColor='#f0dce7';this.style.boxShadow='none';"/>
                        </div>
                        @error('login') <p style="font-size:0.72rem;color:#e11d48;margin-top:4px;">{{ $message }}</p> @enderror
                    </div>

                    <!-- Password -->
                    <div style="margin-bottom:1.5rem;">
                        <label style="display:block;font-size:0.78rem;font-weight:500;color:#5a4050;margin-bottom:5px;">Password</label>
                        <div style="position:relative;">
                            <svg style="position:absolute;left:11px;top:50%;transform:translateY(-50%);width:15px;height:15px;color:#d4a0b8;pointer-events:none;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            <input type="password" name="password" placeholder="••••••••"
                                style="width:100%;border:1.5px solid #f0dce7;border-radius:10px;padding:9px 12px 9px 34px;font-size:0.875rem;font-family:'DM Sans',sans-serif;color:#1a1014;background:#fffbfd;outline:none;box-sizing:border-box;"
                                onfocus="this.style.borderColor='#db2777';this.style.boxShadow='0 0 0 3px rgba(219,39,119,0.1)';"
                                onblur="this.style.borderColor='#f0dce7';this.style.boxShadow='none';"/>
                        </div>
                        @error('password') <p style="font-size:0.72rem;color:#e11d48;margin-top:4px;">{{ $message }}</p> @enderror
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                        style="width:100%;padding:11px;background:#db2777;color:white;font-family:'DM Sans',sans-serif;font-size:0.9rem;font-weight:500;border:none;border-radius:10px;cursor:pointer;letter-spacing:0.02em;box-shadow:0 4px 16px rgba(219,39,119,0.25);"
                        onmouseover="this.style.background='#be185d';this.style.boxShadow='0 6px 20px rgba(219,39,119,0.35)';"
                        onmouseout="this.style.background='#db2777';this.style.boxShadow='0 4px 16px rgba(219,39,119,0.25)';">
                        Masuk
                    </button>

                    <p style="text-align:center;font-size:0.82rem;color:#9d7f8a;margin-top:1.25rem;margin-bottom:0;">
                        Belum punya akun?
                        <a href="{{ route('register') }}" style="color:#db2777;font-weight:500;text-decoration:none;">Daftar sekarang</a>
                    </p>

                </form>
            </div>

        </div>
    </main>

</body>
</html>