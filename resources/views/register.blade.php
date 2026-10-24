<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Akun - ReUseMart</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/reusemart-theme.css') }}">
    <style>
        body {
            font-family: var(--font-family) !important;
            margin: 0;
            height: 100vh;
            overflow: hidden;
        }

        .background-animation {
            position: relative;
            width: 100%;
            height: 100%;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .video-background {
            position: absolute;
            top: 50%;
            left: 50%;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            z-index: 1;
            transform: translate(-50%, -50%);
            object-fit: cover;
        }

        .bg-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(74, 97, 45, 0.75), rgba(111, 143, 70, 0.65));
            z-index: 2;
        }

        .bg-glass {
            background-color: rgba(255, 255, 255, 0.92) !important;
            backdrop-filter: saturate(180%) blur(24px);
            -webkit-backdrop-filter: saturate(180%) blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: var(--radius-xl);
            box-shadow: 0 20px 45px -10px rgba(0, 0, 0, 0.25);
            z-index: 3;
        }

        .content {
            position: relative;
            z-index: 4;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card-container {
            width: 480px;
            max-width: 92vw;
            margin: auto;
        }
    </style>
</head>
<body class="antialiased">

<section class="background-animation">
    <video class="video-background" autoplay loop muted>
        <source src="{{ asset('images/test.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div class="bg-overlay"></div>

    <div class="container px-4 py-5 text-center content">
        <div class="card bg-glass card-container border-0">
            <div class="card-body p-4 p-md-5">
                <div class="mb-4">
                    <span class="badge bg-white text-dark px-3 py-2 rounded-pill fw-semibold mb-2 shadow-sm" style="color: var(--brand-primary) !important;">
                        Bergabung Bersama Kami
                    </span>
                    <h3 class="fw-bold mt-2 mb-1 text-dark">Daftar Akun ReUseMart</h3>
                    <p class="text-muted small">Pilih peran akun yang ingin Anda daftarkan</p>
                </div>

                <div class="d-grid gap-3">
                    <button type="button" class="btn btn-primary py-3 fs-6 d-flex align-items-center justify-content-center gap-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#regisPembeliModal">
                        <i class="bi bi-person fs-5"></i> Daftar Sebagai Pembeli
                    </button>
                    
                    <button type="button" class="btn btn-outline-primary py-3 fs-6 d-flex align-items-center justify-content-center gap-2" data-bs-toggle="modal" data-bs-target="#regisOrganisasiModal">
                        <i class="bi bi-building fs-5"></i> Daftar Sebagai Organisasi
                    </button>
                </div>

                <hr class="my-4 text-muted">
                <div class="text-center">
                    <span class="text-muted small">Sudah memiliki akun?</span>
                    <a href="{{ url('login') }}" class="small fw-bold ms-1" style="color: var(--brand-primary);">Masuk ke Akun</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Registrasi Pembeli -->
<div class="modal fade" id="regisPembeliModal" tabindex="-1" aria-labelledby="regisPembeliModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form action="{{ route('pembeli.register') }}" method="POST" class="modal-content" novalidate id="formRegisPembeli">
        @csrf
        @method('POST')
        <div class="modal-header">
            <h5 class="modal-title" id="regisPembeliModalLabel">Registrasi Pembeli</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Nama Lengkap</label>
                    <input type="text" name="nama_pembeli" class="form-control" placeholder="Contoh: Budi Santoso">
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Contoh: budisantoso">
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Nomor Telepon</label>
                    <input type="text" name="notelp" class="form-control" placeholder="Contoh: 08123456789">
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Alamat Email</label>
                    <input type="email" name="email" class="form-control" placeholder="nama@domain.com">
                </div>
                <div class="col-md-12">
                    <label class="form-label small fw-semibold">Kata Sandi</label>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter">
                </div>
            </div>
        </div>
        <div class="modal-footer border-top-0 pt-0">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary px-4">Daftar Sekarang</button>
        </div>
        </form>
    </div>
</div>

<!-- Modal Registrasi Organisasi -->
<div class="modal fade" id="regisOrganisasiModal" tabindex="-1" aria-labelledby="regisOrganisasiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form action="{{ route('organisasi.register') }}" method="POST" class="modal-content" novalidate id="formRegisOrganisasi">
        @csrf
        @method('POST')
        <div class="modal-header">
            <h5 class="modal-title" id="regisOrganisasiModalLabel">Registrasi Organisasi</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Nama Organisasi</label>
                    <input type="text" name="nama_organisasi" class="form-control" placeholder="Contoh: Yayasan Peduli Hijau">
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Alamat Kantor</label>
                    <input type="text" name="alamat" class="form-control" placeholder="Alamat lengkap organisasi">
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Alamat Email</label>
                    <input type="email" name="email" class="form-control" placeholder="info@organisasi.or.id">
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Kata Sandi</label>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter">
                </div>
            </div>
        </div>
        <div class="modal-footer border-top-0 pt-0">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary px-4">Daftar Sekarang</button>
        </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
