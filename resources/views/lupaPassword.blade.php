<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reset Password - ReUseMart</title>

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
      top: 0; left: 0;
      width: 100%; height: 100%;
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

  <div class="container px-4 py-5 content">
    <div class="row justify-content-center">
      <div class="col-lg-5 col-md-8">
        <div class="card bg-glass border-0">
          <div class="card-body p-4 p-md-5">
            <div class="text-start mb-4">
              <span class="badge bg-white text-dark px-3 py-2 rounded-pill fw-semibold mb-2 shadow-sm" style="color: var(--brand-primary) !important;">
                Keamanan Akun
              </span>
              <h3 class="fw-bold mt-2 mb-1 text-dark">Reset Password</h3>
              <p class="text-muted small">Atur ulang kata sandi akun ReUseMart Anda</p>
            </div>

            <form action="{{ route('password.ubah') }}" method="POST" novalidate id="resetPasswordForm">
              @csrf
                <div class="form-floating mb-3">
                    <select name="tipe_user" class="form-select" id="floatingTipeUser">
                        <option value="" selected disabled>Pilih Tipe Pengguna</option>
                        <option value="pembeli">Pembeli</option>
                        <option value="penitip">Penitip</option>
                        <option value="organisasi">Organisasi</option>
                    </select>
                    <label for="floatingTipeUser">Tipe Pengguna</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="email"
                          name="email"
                          class="form-control"
                          id="floatingEmail"
                          placeholder="name@example.com">
                    <label for="floatingEmail">Alamat Email Terdaftar</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="password"
                          name="password"
                          class="form-control"
                          id="floatingPassword"
                          placeholder="Password Baru">
                    <label for="floatingPassword">Kata Sandi Baru</label>
                </div>

                @if ($errors->any())
                <div class="alert alert-danger py-2 px-3 small rounded-3 mb-3">
                  <ul class="mb-0 ps-3">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                  </ul>
                </div>
                @endif

                <button type="submit"
                        class="btn btn-primary w-100 py-2 fs-6 mb-3 shadow-sm">
                    Simpan Password Baru
                </button>

                <div class="text-center">
                  <a href="{{ url('login') }}" class="small fw-semibold text-muted text-decoration-none">← Kembali ke Halaman Login</a>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
