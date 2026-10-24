<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kirim Link Reset Password - ReUseMart</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- ReUseMart Central Theme -->
    <link rel="stylesheet" href="{{ asset('css/reusemart-theme.css') }}">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #152317 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
            padding: 2rem 1rem;
        }

        .auth-bg-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.25;
            pointer-events: none;
        }
        .auth-bg-blob-1 {
            width: 420px;
            height: 420px;
            background: #6f8f46;
            top: -100px;
            left: -100px;
        }
        .auth-bg-blob-2 {
            width: 380px;
            height: 380px;
            background: #4a632f;
            bottom: -80px;
            right: -80px;
        }

        .auth-card {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 480px;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 1.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
            overflow: hidden;
        }

        .auth-header-strip {
            height: 6px;
            background: linear-gradient(90deg, #6f8f46, #8fb359, #b4d87b);
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.4rem 1rem;
            background: rgba(111, 143, 70, 0.12);
            color: #6f8f46;
            border-radius: 9999px;
            font-weight: 700;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>

<div class="auth-bg-blob auth-bg-blob-1"></div>
<div class="auth-bg-blob auth-bg-blob-2"></div>

<div class="auth-card">
    <div class="auth-header-strip"></div>
    <div class="p-4 p-sm-5">
        <div class="text-center mb-4">
            <div class="brand-badge mb-3">
                <i class="bi bi-recycle fs-5"></i>
                <span>ReUseMart</span>
            </div>
            <h3 class="fw-bold text-dark mb-1">Lupa Password?</h3>
            <p class="text-muted small">Masukkan alamat email Anda untuk menerima tautan pemulihan kata sandi</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success d-flex align-items-center mb-4 border-0 shadow-sm rounded-3" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div class="small">{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger d-flex align-items-center mb-4 border-0 shadow-sm rounded-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div class="small">{{ session('error') }}</div>
            </div>
        @endif

        <form action="{{ route('kirim.link') }}" method="POST" novalidate id="kirimLinkForm">
            @csrf
            <div class="mb-3">
                <label for="inputEmail" class="form-label fw-semibold small text-secondary">Alamat Email Terdaftar</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted">
                        <i class="bi bi-envelope"></i>
                    </span>
                    <input type="text" 
                           id="inputEmail" 
                           name="email" 
                           class="form-control border-start-0 @error('email') is-invalid @enderror" 
                           placeholder="nama@email.com" 
                           value="{{ old('email') }}"
                           autocomplete="email">
                </div>
                <div id="emailErrorFeedback" class="text-danger small mt-1" style="display: none;"></div>
                @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-brand w-100 py-2 fw-semibold shadow-sm mb-3" id="btnSubmit">
                <i class="bi bi-send me-1"></i> Kirim Link Pemulihan
            </button>

            <div class="text-center">
                <a href="{{ route('login') }}" class="text-decoration-none small text-muted d-inline-flex align-items-center gap-1 hover-brand">
                    <i class="bi bi-arrow-left"></i> Kembali ke Halaman Login
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('kirimLinkForm');
    const emailInput = document.getElementById('inputEmail');
    const errorFeedback = document.getElementById('emailErrorFeedback');

    form.addEventListener('submit', function (e) {
        errorFeedback.style.display = 'none';
        errorFeedback.textContent = '';
        emailInput.classList.remove('is-invalid');

        const emailVal = emailInput.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailVal) {
            e.preventDefault();
            emailInput.classList.add('is-invalid');
            errorFeedback.textContent = 'Alamat email wajib diisi.';
            errorFeedback.style.display = 'block';
            emailInput.focus();
            return;
        }

        if (!emailRegex.test(emailVal)) {
            e.preventDefault();
            emailInput.classList.add('is-invalid');
            errorFeedback.textContent = 'Format alamat email tidak valid (contoh: user@domain.com).';
            errorFeedback.style.display = 'block';
            emailInput.focus();
            return;
        }
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
