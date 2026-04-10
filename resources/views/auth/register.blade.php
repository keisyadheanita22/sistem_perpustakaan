<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — Perpustakaan Digital</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,700;1,500&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
</head>
<body style="margin:0;padding:0;font-family:'DM Sans',sans-serif;background-color:#fce7f3;min-height:100vh;display:flex;flex-direction:column;overflow-x:hidden;">

    <!-- Navbar (original) -->
    <nav style="padding:0 2rem;height:56px;display:flex;align-items:center;background-color:#db2777;position:relative;z-index:10;">
        <span style="color:white;font-weight:700;font-size:1.125rem;font-style:italic;">Perpustakaan Digital</span>
    </nav>

    <!-- Main -->
    <main style="flex:1;display:flex;align-items:flex-start;justify-content:center;padding:2.5rem 1rem 4rem;position:relative;z-index:1;">
        <div style="width:100%;max-width:540px;">

            <!-- Ilustrasi buku -->
            <div style="display:flex;gap:4px;align-items:flex-end;margin-bottom:1.25rem;">
                <div style="width:22px;height:52px;background:#f9a8d4;border-radius:3px 5px 5px 3px;position:relative;"><div style="position:absolute;left:0;top:0;bottom:0;width:5px;background:rgba(0,0,0,0.1);border-radius:3px 0 0 3px;"></div></div>
                <div style="width:18px;height:66px;background:#db2777;border-radius:3px 5px 5px 3px;position:relative;"><div style="position:absolute;left:0;top:0;bottom:0;width:5px;background:rgba(0,0,0,0.15);border-radius:3px 0 0 3px;"></div></div>
                <div style="width:20px;height:46px;background:#fbcfe8;border-radius:3px 5px 5px 3px;position:relative;"><div style="position:absolute;left:0;top:0;bottom:0;width:5px;background:rgba(0,0,0,0.08);border-radius:3px 0 0 3px;"></div></div>
                <div style="width:16px;height:58px;background:#ec4899;border-radius:3px 5px 5px 3px;position:relative;"><div style="position:absolute;left:0;top:0;bottom:0;width:5px;background:rgba(0,0,0,0.12);border-radius:3px 0 0 3px;"></div></div>
                <div style="width:22px;height:40px;background:#fda4af;border-radius:3px 5px 5px 3px;position:relative;"><div style="position:absolute;left:0;top:0;bottom:0;width:5px;background:rgba(0,0,0,0.09);border-radius:3px 0 0 3px;"></div></div>
            </div>

            <!-- Heading -->
            <p style="font-size:0.72rem;letter-spacing:0.18em;text-transform:uppercase;color:#db2777;font-weight:500;margin:0 0 4px;">Bergabung Sekarang</p>
            <h1 style="font-family:'Playfair Display',serif;font-size:1.9rem;color:#1a1014;line-height:1.2;margin:0 0 6px;">Buat Akun <em style="font-style:italic;color:#db2777;">Barumu</em></h1>
            <p style="font-size:0.875rem;color:#9d7f8a;margin:0 0 1.75rem;">Lengkapi data berikut untuk mulai meminjam buku.</p>

            <!-- Card -->
            <div style="background:white;border-radius:20px;padding:2rem 2.25rem;box-shadow:0 8px 32px rgba(219,39,119,0.18),0 2px 8px rgba(0,0,0,0.08);border:1px solid #f3e8ee;">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Row: Nama + No Telp -->
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0 1rem;">

                        <div style="margin-bottom:1rem;">
                            <label style="display:block;font-size:0.78rem;font-weight:500;color:#5a4050;margin-bottom:5px;">Nama Lengkap</label>
                            <div style="position:relative;">
                                <svg style="position:absolute;left:11px;top:50%;transform:translateY(-50%);width:15px;height:15px;color:#d4a0b8;pointer-events:none;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama lengkap"
                                    style="width:100%;border:1.5px solid #f0dce7;border-radius:10px;padding:9px 12px 9px 34px;font-size:0.875rem;font-family:'DM Sans',sans-serif;color:#1a1014;background:#fffbfd;outline:none;box-sizing:border-box;"
                                    onfocus="this.style.borderColor='#db2777';this.style.boxShadow='0 0 0 3px rgba(219,39,119,0.1)';"
                                    onblur="this.style.borderColor='#f0dce7';this.style.boxShadow='none';"/>
                            </div>
                            @error('name') <p style="font-size:0.72rem;color:#e11d48;margin-top:4px;">{{ $message }}</p> @enderror
                        </div>

                        <div style="margin-bottom:1rem;">
                            <label style="display:block;font-size:0.78rem;font-weight:500;color:#5a4050;margin-bottom:5px;">No Telepon</label>
                            <div style="position:relative;">
                                <svg style="position:absolute;left:11px;top:50%;transform:translateY(-50%);width:15px;height:15px;color:#d4a0b8;pointer-events:none;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                <input type="text" name="no_telepon" value="{{ old('no_telepon') }}" placeholder="08xxxxxxxxxx"
                                    style="width:100%;border:1.5px solid #f0dce7;border-radius:10px;padding:9px 12px 9px 34px;font-size:0.875rem;font-family:'DM Sans',sans-serif;color:#1a1014;background:#fffbfd;outline:none;box-sizing:border-box;"
                                    onfocus="this.style.borderColor='#db2777';this.style.boxShadow='0 0 0 3px rgba(219,39,119,0.1)';"
                                    onblur="this.style.borderColor='#f0dce7';this.style.boxShadow='none';"/>
                            </div>
                            @error('no_telepon') <p style="font-size:0.72rem;color:#e11d48;margin-top:4px;">{{ $message }}</p> @enderror
                        </div>

                    </div>

                    <!-- Email -->
                    <div style="margin-bottom:1rem;">
                        <label style="display:block;font-size:0.78rem;font-weight:500;color:#5a4050;margin-bottom:5px;">Email</label>
                        <div style="position:relative;">
                            <svg style="position:absolute;left:11px;top:50%;transform:translateY(-50%);width:15px;height:15px;color:#d4a0b8;pointer-events:none;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com"
                                style="width:100%;border:1.5px solid #f0dce7;border-radius:10px;padding:9px 12px 9px 34px;font-size:0.875rem;font-family:'DM Sans',sans-serif;color:#1a1014;background:#fffbfd;outline:none;box-sizing:border-box;"
                                onfocus="this.style.borderColor='#db2777';this.style.boxShadow='0 0 0 3px rgba(219,39,119,0.1)';"
                                onblur="this.style.borderColor='#f0dce7';this.style.boxShadow='none';"/>
                        </div>
                        @error('email') <p style="font-size:0.72rem;color:#e11d48;margin-top:4px;">{{ $message }}</p> @enderror
                    </div>

                    <!-- Alamat -->
                    <div style="margin-bottom:1rem;">
                        <label style="display:block;font-size:0.78rem;font-weight:500;color:#5a4050;margin-bottom:5px;">Alamat</label>
                        <div style="position:relative;">
                            <svg style="position:absolute;left:11px;top:10px;width:15px;height:15px;color:#d4a0b8;pointer-events:none;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <textarea name="alamat" rows="2" placeholder="Jl. Contoh No. 1, Kota"
                                style="width:100%;border:1.5px solid #f0dce7;border-radius:10px;padding:9px 12px 9px 34px;font-size:0.875rem;font-family:'DM Sans',sans-serif;color:#1a1014;background:#fffbfd;outline:none;box-sizing:border-box;resize:none;line-height:1.5;"
                                onfocus="this.style.borderColor='#db2777';this.style.boxShadow='0 0 0 3px rgba(219,39,119,0.1)';"
                                onblur="this.style.borderColor='#f0dce7';this.style.boxShadow='none';">{{ old('alamat') }}</textarea>
                        </div>
                        @error('alamat') <p style="font-size:0.72rem;color:#e11d48;margin-top:4px;">{{ $message }}</p> @enderror
                    </div>

                    <!-- Divider -->
                    <div style="display:flex;align-items:center;gap:10px;margin:0.25rem 0 1rem;">
                        <div style="flex:1;height:1px;background:#f0dce7;"></div>
                        <span style="font-size:0.68rem;color:#c9aab8;letter-spacing:0.1em;text-transform:uppercase;">Info Akun</span>
                        <div style="flex:1;height:1px;background:#f0dce7;"></div>
                    </div>

                    <!-- Username -->
                    <div style="margin-bottom:1rem;">
                        <label style="display:block;font-size:0.78rem;font-weight:500;color:#5a4050;margin-bottom:5px;">Username</label>
                        <div style="position:relative;">
                            <svg style="position:absolute;left:11px;top:50%;transform:translateY(-50%);width:15px;height:15px;color:#d4a0b8;pointer-events:none;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <input type="text" name="username" value="{{ old('username') }}" placeholder="username_kamu"
                                style="width:100%;border:1.5px solid #f0dce7;border-radius:10px;padding:9px 12px 9px 34px;font-size:0.875rem;font-family:'DM Sans',sans-serif;color:#1a1014;background:#fffbfd;outline:none;box-sizing:border-box;"
                                onfocus="this.style.borderColor='#db2777';this.style.boxShadow='0 0 0 3px rgba(219,39,119,0.1)';"
                                onblur="this.style.borderColor='#f0dce7';this.style.boxShadow='none';"/>
                        </div>
                        @error('username') <p style="font-size:0.72rem;color:#e11d48;margin-top:4px;">{{ $message }}</p> @enderror
                    </div>

                    <!-- Row: Password + Konfirmasi -->
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0 1rem;">

                        <div style="margin-bottom:1.25rem;">
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

                        <div style="margin-bottom:1.25rem;">
                            <label style="display:block;font-size:0.78rem;font-weight:500;color:#5a4050;margin-bottom:5px;">Konfirmasi Password</label>
                            <div style="position:relative;">
                                <svg style="position:absolute;left:11px;top:50%;transform:translateY(-50%);width:15px;height:15px;color:#d4a0b8;pointer-events:none;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                <input type="password" name="password_confirmation" placeholder="••••••••"
                                    style="width:100%;border:1.5px solid #f0dce7;border-radius:10px;padding:9px 12px 9px 34px;font-size:0.875rem;font-family:'DM Sans',sans-serif;color:#1a1014;background:#fffbfd;outline:none;box-sizing:border-box;"
                                    onfocus="this.style.borderColor='#db2777';this.style.boxShadow='0 0 0 3px rgba(219,39,119,0.1)';"
                                    onblur="this.style.borderColor='#f0dce7';this.style.boxShadow='none';"/>
                            </div>
                        </div>

                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        style="width:100%;padding:11px;background:#db2777;color:white;font-family:'DM Sans',sans-serif;font-size:0.9rem;font-weight:500;border:none;border-radius:10px;cursor:pointer;letter-spacing:0.02em;box-shadow:0 4px 16px rgba(219,39,119,0.25);"
                        onmouseover="this.style.background='#be185d';this.style.boxShadow='0 6px 20px rgba(219,39,119,0.35)';"
                        onmouseout="this.style.background='#db2777';this.style.boxShadow='0 4px 16px rgba(219,39,119,0.25)';">
                        Buat Akun
                    </button>

                    <p style="text-align:center;font-size:0.82rem;color:#9d7f8a;margin-top:1.25rem;margin-bottom:0;">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" style="color:#db2777;font-weight:500;text-decoration:none;">Masuk sekarang</a>
                    </p>

                </form>
            </div>

        </div>
    </main>

</body>
</html>