<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pembeli - ReUseMart</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/reusemart-theme.css') }}">
</head>
<body class="d-flex flex-column min-vh-100">

    <header class="reusemart-header sticky-top">
        <div class="header-container">
            <div class="header-left">
                <a href="{{ url('/') }}" class="logo-link">
                    <img src="{{ asset('images/logo2.png') }}" alt="Logo ReUseMart" class="logo-img">
                </a>
            </div>

            <nav class="nav-links">
                <a href="{{ url('/') }}" class="nav-link-item">Beranda</a>
                <a href="{{ url('/kategori') }}" class="nav-link-item">Kategori</a>
                <a href="{{ url('/about') }}" class="nav-link-item">Tentang Kami</a>
            </nav>

            <div class="header-right">
                <a href="{{ route('profile.pembeli') }}" class="header-icon-btn position-relative" title="Profil Pembeli">
                    <i class="bi bi-person-fill"></i>
                </a>
                <a href="{{ route('keranjang.index') }}" class="header-icon-btn position-relative" title="Keranjang Belanja">
                    <i class="bi bi-cart3"></i>
                </a>
            </div>
        </div>
    </header>

    <main class="flex-grow-1 py-5">
        <div class="container" style="max-width: 1000px;">
            <div class="card border-0 shadow-sm p-4 mb-4" style="border: 1px solid var(--border-color) !important; border-radius: var(--radius-lg);">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 pb-3 mb-4 border-bottom">
                    <div>
                        <h3 class="fw-bold mb-1" style="color: var(--text-heading);">Dashboard Pembeli</h3>
                        <p class="text-muted small mb-0">Selamat datang di akun ReUseMart Anda. Kelola pesanan, alamat pengiriman, dan riwayat transaksi.</p>
                    </div>
                    <a href="{{ route('profile.pembeli') }}" class="btn btn-outline-primary">
                        <i class="bi bi-person-gear me-1"></i> Edit Profil
                    </a>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-12 col-md-4">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="bi bi-bag-check"></i>
                            </div>
                            <div>
                                <div class="stat-label">Pesanan Aktif</div>
                                <div class="stat-value">1</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="bi bi-stars"></i>
                            </div>
                            <div>
                                <div class="stat-label">Poin Belanja</div>
                                <div class="stat-value">200</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="bi bi-cart3"></i>
                            </div>
                            <div>
                                <div class="stat-label">Keranjang</div>
                                <div class="stat-value">3</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <a href="{{ route('pembeli.transaksi') }}" class="card border p-3 text-center text-decoration-none h-100" style="border-radius: var(--radius-md); transition: var(--transition-smooth);">
                            <i class="bi bi-clock-history fs-2 mb-2" style="color: var(--brand-primary);"></i>
                            <h6 class="fw-bold mb-1" style="color: var(--text-heading);">Riwayat Transaksi</h6>
                            <p class="text-muted small mb-0">Lihat status pembayaran dan pesanan sebelumnya</p>
                        </a>
                    </div>
                    <div class="col-12 col-md-4">
                        <a href="{{ route('pembeli.alamat.index') }}" class="card border p-3 text-center text-decoration-none h-100" style="border-radius: var(--radius-md); transition: var(--transition-smooth);">
                            <i class="bi bi-geo-alt fs-2 mb-2" style="color: var(--brand-primary);"></i>
                            <h6 class="fw-bold mb-1" style="color: var(--text-heading);">Alamat Pengiriman</h6>
                            <p class="text-muted small mb-0">Kelola alamat domisili tujuan pengantaran</p>
                        </a>
                    </div>
                    <div class="col-12 col-md-4">
                        <a href="{{ url('/kategori') }}" class="card border p-3 text-center text-decoration-none h-100" style="border-radius: var(--radius-md); transition: var(--transition-smooth);">
                            <i class="bi bi-shop fs-2 mb-2" style="color: var(--brand-primary);"></i>
                            <h6 class="fw-bold mb-1" style="color: var(--text-heading);">Mulai Belanja</h6>
                            <p class="text-muted small mb-0">Temukan barang bekas berkualitas bergaransi</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-container">
            <div class="footer-left">
                <p>&copy; 2025 ReUseMart — Platform Titip Jual Barang Bekas Berkualitas. All rights reserved.</p>
            </div>
            <div class="footer-right">
                <div class="social-icons">
                    <a href="#" class="social-icon" aria-label="Facebook"><img src="{{ asset('images/facebook.png') }}" alt="Facebook"></a>
                    <a href="#" class="social-icon" aria-label="Instagram"><img src="{{ asset('images/instagram.png') }}" alt="Instagram"></a>
                    <a href="#" class="social-icon" aria-label="Twitter"><img src="{{ asset('images/twitter.png') }}" alt="Twitter"></a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
