<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - ReUseMart</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/reusemart-theme.css') }}">
    <style>
        body {
            font-family: var(--font-family) !important;
            margin: 0;
            overflow: hidden;
        }

        .background-animation {
            position: relative;
            width: 100%;
            min-height: 100vh;
            overflow: hidden;
            display: flex;
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
            background-color: rgba(255, 255, 255, 0.9) !important;
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
            color: white;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>
<body class="antialiased">

<section class="background-animation">
    <video class="video-background" autoplay loop muted>
        <source src="{{ asset('images/video.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div class="bg-overlay"></div>
    <div class="container px-4 py-5 px-md-5 my-5 content">
        <div class="row gx-lg-5 align-items-center mb-5">
            <div class="col-lg-6 mb-5 mb-lg-0 text-center text-lg-start">
                <span class="badge bg-white text-dark px-3 py-2 rounded-pill fw-semibold mb-3 shadow-sm" style="color: var(--brand-primary) !important;">
                    ReUseMart Platform
                </span>
                <h1 class="my-3 display-5 fw-bold text-white lh-sm">
                    Gunakan Kembali, Kurangi Sampah, Berbagi Lebih Banyak
                </h1>
                <p class="text-white-50 lead fs-6">
                    Solusi terpadu belanja barang berkualitas second-hand, titip jual terpercaya, dan donasi terarah.
                </p>
            </div>
            <div class="col-lg-5 mb-5 mb-lg-0 position-relative ms-auto">
                <div class="card bg-glass border-0">
                    <div class="card-body px-4 py-5 px-md-5">
                    <form class="form" action="{{ url('login') }}" method="POST" novalidate id="loginForm">
                        @csrf
                        <div class="text-start mb-4">
                            <h3 class="fw-bold text-dark mb-1">Selamat Datang</h3>
                            <p class="text-muted small mb-0">Masuk ke akun ReUseMart Anda</p>
                        </div>

                        <div class="form-floating mb-3">
                            <select name="tipe_user" class="form-select" id="floatingTipeUser">
                                <option value="" selected disabled>Pilih Tipe Pengguna</option>
                                <option value="pembeli">Pembeli</option>
                                <option value="penitip">Penitip</option>
                                <option value="organisasi">Organisasi</option>
                                <option value="pegawai">Pegawai</option>
                            </select>
                            <label for="floatingTipeUser">Tipe Pengguna</label>
                        </div>

                        <div class="form-floating mb-3" id="emailField">
                            <input type="email" name="email" class="form-control" id="floatingInput" placeholder="Email" />
                            <label for="floatingInput">Alamat Email</label>
                        </div>

                        <div class="form-floating mb-3 d-none" id="organisasiSelectWrapper">
                            <select name="id_organisasi" class="form-select" id="organisasiSelect">
                                <option value="" disabled selected>Pilih Organisasi</option>
                                @foreach($organisasiList as $org)
                                    <option value="{{ $org->id_organisasi }}">{{ $org->nama_organisasi }}</option>
                                @endforeach
                            </select>
                            <label for="organisasiSelect">Nama Organisasi</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Kata Sandi" />
                            <label for="floatingPassword">Kata Sandi</label>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger py-2 px-3 small rounded-3">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <button type="submit" class="btn btn-primary w-100 py-2 fs-6 mb-3 mt-2 shadow-sm">
                            Masuk
                        </button>
                        <div class="d-flex justify-content-center">
                            <a href="{{ url('linkForm') }}" class="small fw-semibold text-muted text-decoration-none hover-primary">Lupa Password?</a>
                        </div>
                        <hr class="my-3 text-muted">
                        <div class="text-center">
                            <span class="text-muted small">Belum punya akun?</span>
                            <a href="{{ url('register') }}" class="small fw-bold ms-1" style="color: var(--brand-primary);">Daftar Sekarang</a>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const tipeUserSelect = document.getElementById('floatingTipeUser');
    const emailField = document.getElementById('emailField');
    const orgWrapper = document.getElementById('organisasiSelectWrapper');

    tipeUserSelect.addEventListener('change', function () {
        if (this.value === 'organisasi') {
            emailField.classList.add('d-none');
            orgWrapper.classList.remove('d-none');
        } else {
            emailField.classList.remove('d-none');
            orgWrapper.classList.add('d-none');
        }
    });
</script>

</body>
</html>