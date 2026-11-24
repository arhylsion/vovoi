<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak | VOVOI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 24px;
        }
        .error-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            max-width: 480px;
            width: 100%;
            padding: 40px 32px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
        }
        .alert-red {
            background-color: #fee2e2;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 14px 18px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 24px;
            line-height: 1.5;
        }
        .btn-home {
            display: inline-block;
            background-color: #0B5ED7;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            transition: background 0.15s ease;
        }
        .btn-home:hover { background-color: #094bac; }
    </style>
</head>
<body>
    <div class="error-card">
        <div style="font-size: 48px; margin-bottom: 12px;">🚫</div>
        <h1 style="font-size: 24px; font-weight: 800; margin: 0 0 12px 0;">403 Forbidden</h1>
        <div class="alert-red">
            {{ $exception->getMessage() ?: 'Akses Ditolak: Anda tidak memiliki izin untuk mengakses halaman Seller Center.' }}
        </div>
        <p style="color: #64748b; font-size: 13px; line-height: 1.6; margin-bottom: 24px;">
            Halaman ini khusus untuk Administrator. Jika Anda adalah pelanggan, silakan kembali ke katalog belanja.
        </p>
        <a href="/katalog" class="btn-home">&larr; Kembali ke Katalog Toko</a>
    </div>
</body>
</html>
