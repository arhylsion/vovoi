<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Seller Center - Portal Pengelola Toko</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;5
00;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system,
                BlinkMacSystemFont, sans-serif;
            margin: 0;
            background-color: #f8fafc;
            color: #0f172a;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 24px;
            -webkit-font-smoothing: antialiased;
        }

        .login-box {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            width: 100%;
            max-width: 430px;
            padding: 40px 36px;
            box-shadow: 0 12px 32px rgba(15, 23, 42, 0.05);
        }

        .seller-tag {
            display: inline-block;
            background-color: #0f172a;
            color: #ffffff;
            font-size: 11px;
            font-weight: 700;
            padding: 5px 12px;
            border-radius: 6px;
            letter-spacing: 0.6px;
            margin-bottom: 14px;
        }

        .input-group {
            margin-bottom: 18px;
        }

        .input-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
        }

        .input-field {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-family: inherit;
            font-size: 14px;
            color: #0f172a;
            background-color: #ffffff;
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .input-field:focus {
            border-color: #0B5ED7;
            box-shadow: 0 0 0 3px rgba(11, 94, 215, 0.1);
        }

        .btn-submit {
            width: 100%;
            background-color: #0B5ED7;
            color: #ffffff;
            border: none;
            padding: 13px 20px;
            border-radius: 8px;
            font-family: inherit;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            margin-top: 6px;
            transition: background-color 0.15s ease;
        }

        .btn-submit:hover {
            background-color: #094bac;
        }
    </style>
</head>

<body>
    <div class="login-box">

        <!-- Header Kartu Login -->
        <div style="text-align: center; margin-bottom: 28px;">
            <span class="seller-tag">SELLER CENTER</span>
            <h1 style="margin: 0 0 6px 0; font-size: 22px; font-weight:
800; color: #0f172a;">
                Masuk ke Portal Toko
            </h1>
            <p style="margin: 0; font-size: 13px; color: #64748b; lineheight: 1.5;">
                Gunakan akun resmi administrator untuk mengelola pesanan
                dan katalog produk.
            </p>
        </div>
        <!-- Notifikasi Hijau Saat Berhasil Logout -->
        @if (session('status'))
            <div
                style="background-color: #ecfdf5; color: #065f46; padding:
12px 16px; border-radius: 8px; border: 1px solid #a7f3d0; margin-bottom:
20px; font-size: 13px; font-weight: 600;">
                {{ session('status') }}
            </div>
        @endif
        <!-- Peringatan Merah Saat Email atau Password Salah -->
        @if ($errors->any())
            <div
                style="background-color: #fef2f2; color: #991b1b; padding:
12px 16px; border-radius: 8px; border: 1px solid #fecaca; margin-bottom:
20px; font-size: 13px; font-weight: 600; line-height: 1.4;">
                {{ $errors->first() }}
            </div>
        @endif
        <!-- Formulir Login -->
        <form action="/login" method="POST">
            @csrf
            <div class="input-group">
                <label class="input-label">Alamat Email Admin</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Contoh: admin@toko.com"
                    required autofocus class="inputfield">
            </div>
            <div class="input-group">
                <label class="input-label">Kata Sandi (Password)</label>
                <div style="position: relative; display: flex; align-items:
center;">
                    <input type="password" name="password" id="passwordInput" placeholder="Masukkan kata sandi..."
                        required class="input-field" style="padding-right: 75px;">
                    <button type="button" onclick="togglePassword()" id="toggleBtn"
                        style="position: absolute; right: 10px; background: #f1f5f9;
border: 1px solid #cbd5e1; border-radius: 6px; padding: 5px 10px; fontsize: 11px; font-weight: 700; color: #475569; cursor: pointer; font-family:
inherit;">
                        Lihat
                    </button>
                </div>
            </div>
            <!-- Baris Remember Me -->
            <div
                style="display: flex; align-items: center; justifycontent: space-between; margin-bottom: 22px; font-size: 13px;">
                <label
                    style="display: flex; align-items: center; gap: 8px;
color: #475569; cursor: pointer; font-weight: 500;">
                    <input type="checkbox" name="remember"
                        style="width:
16px; height: 16px; accent-color: #0B5ED7; cursor: pointer;">
                    Ingat sesi login saya
                </label>
            </div>
            <button type="submit" class="btn-submit">
                Masuk ke Seller Center &rarr;
            </button>
        </form>
        <!-- Tautan Kembali ke Beranda Pembeli -->
        <div style="text-align: center; margin-top: 26px; padding-top:
20px; border-top: 1px solid #f1f5f9;">
            <a href="/" style="color: #64748b; text-decoration: none; fontsize: 13px; font-weight: 600;">
                &larr; Kembali ke Etalase Toko Depan
            </a>
        </div>
    </div>
    <script>
        function togglePassword() {
            var pwd = document.getElementById('passwordInput');
            var btn = document.getElementById('toggleBtn');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                btn.innerText = 'Tutup';
            } else {
                pwd.type = 'password';
                btn.innerText = 'Lihat';
            }
        }
    </script>
</body>

</html>
