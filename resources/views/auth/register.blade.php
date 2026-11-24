<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Customer - VOVOI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            margin: 0;
            background-color: #f8fafc;
            color: #0f172a;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 32px 24px;
            -webkit-font-smoothing: antialiased;
        }

        .register-box {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            width: 100%;
            max-width: 480px;
            padding: 36px 32px;
            box-shadow: 0 12px 32px rgba(15, 23, 42, 0.05);
        }

        .customer-tag {
            display: inline-block;
            background-color: #0B5ED7;
            color: #ffffff;
            font-size: 11px;
            font-weight: 700;
            padding: 5px 12px;
            border-radius: 6px;
            letter-spacing: 0.6px;
            margin-bottom: 12px;
        }

        .input-group {
            margin-bottom: 16px;
        }

        .input-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
        }

        .input-field {
            width: 100%;
            padding: 11px 14px;
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
            margin-top: 10px;
            transition: background-color 0.15s ease;
        }

        .btn-submit:hover {
            background-color: #094bac;
        }
    </style>
</head>

<body>
    <div class="register-box">
        <!-- Header Kartu Register -->
        <div style="text-align: center; margin-bottom: 24px;">
            <span class="customer-tag">AKUN BARU</span>
            <h1 style="margin: 0 0 6px 0; font-size: 22px; font-weight: 800; color: #0f172a;">
                Daftar Akun VOVOI
            </h1>
            <p style="margin: 0; font-size: 13px; color: #64748b; line-height: 1.5;">
                Nikmati kemudahan belanja online, tracking resi, dan voucher diskon.
            </p>
        </div>

        @if ($errors->any())
            <div style="background-color: #fef2f2; color: #991b1b; padding: 12px 16px; border-radius: 8px; border: 1px solid #fecaca; margin-bottom: 18px; font-size: 13px; font-weight: 600; line-height: 1.4;">
                <ul style="margin: 0; padding-left: 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulir Pendaftaran Customer -->
        <form action="/register" method="POST">
            @csrf
            <div class="input-group">
                <label class="input-label">Nama Lengkap <span style="color: #dc2626;">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso" required autofocus class="input-field">
            </div>

            <div class="input-group">
                <label class="input-label">Alamat Email <span style="color: #dc2626;">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Contoh: budi@gmail.com" required class="input-field">
            </div>

            <div class="input-group">
                <label class="input-label">Nomor WhatsApp / HP</label>
                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Contoh: 081234567890" class="input-field">
            </div>

            <div class="input-group">
                <label class="input-label">Alamat Pengiriman</label>
                <textarea name="address" rows="2" placeholder="Alamat jalan, kelurahan, kecamatan, kota..." class="input-field" style="resize: vertical;">{{ old('address') }}</textarea>
            </div>

            <div class="input-group">
                <label class="input-label">Kata Sandi (Password) <span style="color: #dc2626;">*</span></label>
                <input type="password" name="password" placeholder="Minimal 8 karakter" required class="input-field">
            </div>

            <div class="input-group">
                <label class="input-label">Konfirmasi Kata Sandi <span style="color: #dc2626;">*</span></label>
                <input type="password" name="password_confirmation" placeholder="Ketik ulang kata sandi" required class="input-field">
            </div>

            <button type="submit" class="btn-submit">
                Daftar &amp; Masuk Otomatis &rarr;
            </button>
        </form>

        <!-- Tautan ke Halaman Login -->
        <div style="text-align: center; margin-top: 22px; padding-top: 18px; border-top: 1px solid #f1f5f9; font-size: 13px; color: #64748b;">
            Sudah memiliki akun?
            <a href="/login" style="color: #0B5ED7; text-decoration: none; font-weight: 700;">
                Masuk di sini
            </a>
        </div>

        <div style="text-align: center; margin-top: 12px;">
            <a href="/" style="color: #94a3b8; text-decoration: none; font-size: 12px; font-weight: 600;">
                &larr; Kembali ke Etalase Toko
            </a>
        </div>
    </div>
</body>

</html>
