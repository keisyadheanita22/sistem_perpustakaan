<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Sistem Perpustakaan</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
</head>

<body style="margin:0;font-family:'DM Sans',sans-serif;min-height:100vh;display:flex;flex-direction:column;">

    <!-- ================= NAVBAR ================= -->
    <nav style="padding:0 2rem;height:56px;display:flex;align-items:center;background:#3A5A40;">
        <span style="color:white;font-weight:600;">Sistem Perpustakaan</span>
    </nav>

    <!-- ================= MAIN ================= -->
    <main style="flex:1;display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden;">

        <!-- BACKGROUND FOTO -->
        <div style="position:absolute;inset:0;
                   background:url('{{ asset("images/perpus.jpg") }}') center/cover no-repeat;"></div>

        <!-- OVERLAY HIJAU -->
        <div style="position:absolute;inset:0;background:rgba(60, 90, 70, 0.75);"></div>

        <!-- LINGKARAN DEKORASI -->
        <div style="position:absolute;width:400px;height:400px;background:#F4C542;border-radius:50%;
                    top:-120px;left:-120px;opacity:0.5;"></div>

        <div style="position:absolute;width:320px;height:320px;background:#F4C542;border-radius:50%;
                    bottom:-100px;right:-100px;opacity:0.5;"></div>

        <!-- ================= CARD BESAR ================= -->
        <div style="position:relative;
                    width:90%;max-width:800px;
                    border-radius:30px;
                    padding:3rem;
                  
                    box-shadow:0 20px 40px rgba(0,0,0,0.25);">

            <!-- OVERLAY CARD -->
            <div style="position:absolute;inset:0;
                        background:white;
                        border-radius:30px;"></div>

            <!-- ISI -->
            <div style="position:relative;">

                <!-- LOGIN BOX -->
                <div style="margin:auto;background:#5C7A66;border-radius:30px;padding:2rem;width:400px;">

                    <!-- BRAND -->
                    <div style="text-align:center;margin-bottom:1rem;">
                        <div style="font-size:26px;">📚</div>
                        <p style="font-size:0.7rem;letter-spacing:0.15em;color:#DAD7CD;">
                            PERPUSTAKAAN DIGITAL
                        </p>
                    </div>

                    <!-- TITLE -->
                    <h2 style="color:white;text-align:center;margin-bottom:1.2rem;">
                        Login
                    </h2>

                    <!-- FORM -->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- USERNAME -->
                        <div style="margin-bottom:1rem;">
                            <label style="color:#EDE0C8;font-size:0.75rem;">Username</label>
                            <input type="text" name="login" value="{{ old('login') }}"
                                style="width:100%;padding:8px;border-radius:6px;border:none;background:#EDE0C8;outline:none;"
                                onfocus="this.style.boxShadow='0 0 0 2px #F4C542';"
                                onblur="this.style.boxShadow='none';">
                            @error('login')
                                <p style="color:red;font-size:0.7rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- PASSWORD -->
                        <div style="margin-bottom:1rem;">
                            <label style="color:#EDE0C8;font-size:0.75rem;">Password</label>
                            <input type="password" name="password"
                                style="width:100%;padding:8px;border-radius:6px;border:none;background:#EDE0C8;outline:none;"
                                onfocus="this.style.boxShadow='0 0 0 2px #F4C542';"
                                onblur="this.style.boxShadow='none';">
                            @error('password')
                                <p style="color:red;font-size:0.7rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- BUTTON -->
                        <button type="submit"
                            style="width:100%;padding:10px;background:#F4C542;border:none;border-radius:8px;
                                   font-weight:500;cursor:pointer;">
                            Masuk ke Perpustakaan
                        </button>

                        <!-- LINK -->
                        <p style="text-align:center;font-size:0.75rem;margin-top:10px;color:#EDE0C8;">
                            Belum punya akun?
                            <a href="{{ route('register') }}" style="color:#F4C542;">Daftar</a>
                        </p>

                    </form>
                </div>

            </div>

        </div>

    </main>

</body>
</html>