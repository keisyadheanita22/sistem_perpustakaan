
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — Sistem Perpustakaan</title>

    <!-- Load CSS & JS Laravel -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
</head>

<body style="margin:0;font-family:'DM Sans',sans-serif;min-height:100vh;display:flex;flex-direction:column;">

    <!-- ================= NAVBAR ================= -->
    <nav style="padding:0 2rem;height:56px;display:flex;align-items:center;background:#3A5A40;">
        <span style="color:white;font-weight:600;">Sistem Perpustakaan</span>
    </nav>

    <!-- ================= MAIN ================= -->
    <main style="flex:1;display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden;">

        <!-- ===== BACKGROUND FOTO ===== -->
        <!-- Ambil dari public/images/perpus.jpg -->
        <div style="position:absolute;inset:0;
                   background:url('{{ asset("images/perpus.jpg") }}') center/cover no-repeat;"></div>

        <!-- ===== OVERLAY (biar teks kebaca) ===== -->
        <div style="position:absolute;inset:0;background:rgba(60, 90, 70, 0.75);"></div>

        <!-- ===== DEKORASI ===== -->
        <div style="position:absolute;width:400px;height:400px;background:#F4C542;border-radius:50%;
                    top:-120px;left:-120px;opacity:0.4;"></div>

        <div style="position:absolute;width:320px;height:320px;background:#F4C542;border-radius:50%;
                    bottom:-100px;right:-100px;opacity:0.4;"></div>

        <!-- ================= CARD ================= -->
        <div style="position:relative;background:white;border-radius:30px;
                    width:100%;max-width:900px;padding:2.5rem;
                    box-shadow:0 20px 40px rgba(0,0,0,0.25);">

            <!-- ===== TITLE ===== -->
            <h2 style="text-align:center;margin-bottom:1.5rem;color:#3A5A40;">
                📚 Daftar Perpustakaan Digital
            </h2>

            <!-- ================= FORM ================= -->
            <form method="POST" action="{{ route('register') }}" style="max-width:600px;margin:auto;">
                @csrf

                <!-- ===== ROW: NAMA & TELP ===== -->
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">

                    <!-- Nama -->
                    <div>
                        <label style="font-size:0.8rem;color:#344E41;">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            style="width:100%;padding:10px;border-radius:8px;
                                   border:1.5px solid #DAD7CD;background:#F8F9FA;outline:none;"
                            onfocus="this.style.borderColor='#3A5A40'; this.style.background='#fff';"
                            onblur="this.style.borderColor='#DAD7CD'; this.style.background='#F8F9FA';">

                        <!-- Error -->
                        @error('name')
                            <p style="color:red;font-size:0.7rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- No Telepon -->
                    <div>
                        <label style="font-size:0.8rem;color:#344E41;">No Telepon</label>
                        <input type="text" name="no_telepon" value="{{ old('no_telepon') }}"
                            style="width:100%;padding:10px;border-radius:8px;
                                   border:1.5px solid #DAD7CD;background:#F8F9FA;outline:none;"
                            onfocus="this.style.borderColor='#3A5A40'; this.style.background='#fff';"
                            onblur="this.style.borderColor='#DAD7CD'; this.style.background='#F8F9FA';">

                        @error('no_telepon')
                            <p style="color:red;font-size:0.7rem;">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <!-- ===== EMAIL ===== -->
                <div style="margin-top:1rem;">
                    <label style="font-size:0.8rem;color:#344E41;">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        style="width:100%;padding:10px;border-radius:8px;
                               border:1.5px solid #DAD7CD;background:#F8F9FA;outline:none;"
                        onfocus="this.style.borderColor='#3A5A40'; this.style.background='#fff';"
                        onblur="this.style.borderColor='#DAD7CD'; this.style.background='#F8F9FA';">

                    @error('email')
                        <p style="color:red;font-size:0.7rem;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- ===== ALAMAT ===== -->
                <div style="margin-top:1rem;">
                    <label style="font-size:0.8rem;color:#344E41;">Alamat</label>
                    <textarea name="alamat" rows="2"
                        style="width:100%;padding:10px;border-radius:8px;
                               border:1.5px solid #DAD7CD;background:#F8F9FA;outline:none;">{{ old('alamat') }}</textarea>

                    @error('alamat')
                        <p style="color:red;font-size:0.7rem;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- ===== USERNAME ===== -->
                <div style="margin-top:1rem;">
                    <label style="font-size:0.8rem;color:#344E41;">Username</label>
                    <input type="text" name="username" value="{{ old('username') }}"
                        style="width:100%;padding:10px;border-radius:8px;
                               border:1.5px solid #DAD7CD;background:#F8F9FA;outline:none;"
                        onfocus="this.style.borderColor='#3A5A40'; this.style.background='#fff';"
                        onblur="this.style.borderColor='#DAD7CD'; this.style.background='#F8F9FA';">

                    @error('username')
                        <p style="color:red;font-size:0.7rem;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- ===== PASSWORD ===== -->
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-top:1rem;">

                    <!-- Password -->
                    <div>
                        <label style="font-size:0.8rem;color:#344E41;">Password</label>
                        <input type="password" name="password"
                            style="width:100%;padding:10px;border-radius:8px;
                                   border:1.5px solid #DAD7CD;background:#F8F9FA;outline:none;">

                        @error('password')
                            <p style="color:red;font-size:0.7rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konfirmasi -->
                    <div>
                        <label style="font-size:0.8rem;color:#344E41;">Konfirmasi</label>
                        <input type="password" name="password_confirmation"
                            style="width:100%;padding:10px;border-radius:8px;
                                   border:1.5px solid #DAD7CD;background:#F8F9FA;outline:none;">
                    </div>

                </div>

                <!-- ===== BUTTON ===== -->
                <button type="submit"
                    style="margin-top:1.5rem;width:100%;padding:12px;background:#F4C542;
                           border:none;border-radius:10px;font-weight:600;cursor:pointer;">
                    Daftar Sekarang
                </button>

                <!-- ===== LINK LOGIN ===== -->
                <p style="text-align:center;font-size:0.8rem;margin-top:10px;color:#344E41;">
                    Sudah punya akun?
                    <a href="{{ route('login') }}"
                        style="color:#588157;font-weight:600;text-decoration:none;"
                        onmouseover="this.style.color='#3A5A40'"
                        onmouseout="this.style.color='#588157'">
                        Masuk
                    </a>
                </p>

            </form>
        </div>

    </main>

</body>
</html>
