<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Reset Password - ReUseMart</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f7f9f4;
            margin: 0;
            padding: 30px 15px;
        }
        .container {
            background-color: #ffffff;
            max-width: 520px;
            margin: auto;
            padding: 35px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
            border: 1px solid #e2e8f0;
        }
        .logo-wrap {
            text-align: center;
            margin-bottom: 25px;
        }
        .logo-badge {
            display: inline-block;
            background: #6f8f46;
            color: #ffffff;
            font-weight: 700;
            font-size: 18px;
            padding: 8px 18px;
            border-radius: 20px;
            letter-spacing: 0.5px;
        }
        h3 {
            color: #1e293b;
            margin-top: 0;
            font-size: 20px;
        }
        p {
            font-size: 14px;
            color: #475569;
            line-height: 1.6;
        }
        .btn-reset {
            display: inline-block;
            background-color: #6f8f46;
            color: #ffffff !important;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            margin-top: 24px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo-wrap">
            <span class="logo-badge">ReUseMart</span>
        </div>

        <h3>Halo,</h3>
        <p>Kami menerima permintaan untuk mereset kata sandi akun ReUseMart Anda. Klik tombol di bawah ini untuk melanjutkan:</p>

        <div style="text-align: center;">
            <a href="{{ $url }}" class="btn-reset" target="_blank">Reset Kata Sandi Saya</a>
        </div>

        <p style="font-size: 12px; color: #64748b;">
            Jika tombol di atas tidak berfungsi, salin dan tempel tautan berikut ke browser Anda:<br>
            <a href="{{ $url }}" style="color: #6f8f46; word-break: break-all;">{{ $url }}</a>
        </p>

        <hr style="border: none; border-top: 1px solid #f1f5f9; margin: 24px 0;">

        <p style="font-size: 12px; color: #94a3b8; margin-bottom: 0;">
            Jika Anda tidak meminta perubahan kata sandi ini, silakan abaikan email ini dengan aman.
        </p>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} ReUseMart. Hak cipta dilindungi undang-undang.
    </div>
</body>
</html>
