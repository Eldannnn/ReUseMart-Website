<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReUseMart - Home</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            /* Warna Default Brand (Sesuai Identitas ReUseMart) */
            --brand-primary: #6f8f46;
            --brand-primary-rgb: 111, 143, 70;
            --brand-primary-hover: #5c7739;
            --brand-primary-dark: #4b622e;
            --brand-primary-subtle: #f5f8f2;
            --brand-primary-light: rgba(111, 143, 70, 0.12);
            --brand-accent-green: #15803d;
            --brand-accent-bg: #ecfdf5;
            --brand-accent-border: #bbf7d0;

            /* Tipografi & Warna Netral */
            --font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            --text-heading: #1e293b;
            --text-body: #334155;
            --text-muted: #64748b;
            --text-subtle: #94a3b8;
            --bg-page: #f8fafc;
            --bg-card: #ffffff;
            --border-color: #e2e8f0;
            --border-hover: rgba(111, 143, 70, 0.35);

            /* Bayangan & Radius Elemen */
            --radius-sm: 8px;
            --radius-md: 14px;
            --radius-lg: 18px;
            --radius-xl: 24px;
            --shadow-subtle: 0 2px 8px rgba(0, 0, 0, 0.04);
            --shadow-card: 0 4px 16px -2px rgba(15, 23, 42, 0.06);
            --shadow-card-hover: 0 16px 32px -6px rgba(111, 143, 70, 0.18);
            --transition-smooth: all 0.28s cubic-bezier(0.16, 1, 0.3, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-family);
            color: var(--text-body);
            background-color: var(--bg-page);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            overflow-x: hidden;
        }

        /* -------------------------------------------------
           HEADER & NAVIGATION BAR
        ------------------------------------------------- */
        header {
            background-color: var(--brand-primary);
            background: linear-gradient(135deg, rgba(111, 143, 70, 0.98), rgba(95, 124, 59, 0.98));
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 20px -2px rgba(111, 143, 70, 0.25);
            transition: var(--transition-smooth);
        }

        .header-container {
            max-width: 1320px;
            margin: 0 auto;
            padding: 12px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 36px;
        }

        .logo a {
            display: inline-flex;
            align-items: center;
            text-decoration: none;
            transition: var(--transition-smooth);
        }

        .logo img {
            height: 52px;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 2px 6px rgba(0, 0, 0, 0.18));
            transition: var(--transition-smooth);
        }

        .logo a:hover img {
            transform: scale(1.04);
            filter: drop-shadow(0 4px 10px rgba(0, 0, 0, 0.25));
        }

        nav ul {
            display: flex;
            align-items: center;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 8px;
        }

        nav ul li a {
            text-decoration: none;
            color: rgba(255, 255, 255, 0.92);
            font-size: 14.5px;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 9999px;
            transition: var(--transition-smooth);
            display: inline-block;
        }

        nav ul li a:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.16);
            transform: translateY(-1px);
        }

        .cart-search {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .cart-search .icons {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .cart-search .icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.22);
            text-decoration: none;
            transition: var(--transition-smooth);
        }

        .cart-search .icons a img {
            width: 20px;
            height: 20px;
            transition: var(--transition-smooth);
            filter: brightness(0) invert(1);
        }

        .cart-search .icons a:hover {
            background-color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .cart-search .icons a:hover img {
            filter: invert(53%) sepia(23%) saturate(954%) hue-rotate(44deg) brightness(95%) contrast(87%);
            transform: scale(1.1);
        }

        /* -------------------------------------------------
           HERO CAROUSEL SECTION
        ------------------------------------------------- */
        .hero-section {
            max-width: 1320px;
            margin: 24px auto 0 auto;
            padding: 0 24px;
        }

        #carouselExampleCaptions {
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: 0 16px 36px -10px rgba(0, 0, 0, 0.12);
            position: relative;
            background-color: #1e293b;
        }

        .carousel-item {
            height: 440px;
            position: relative;
            background-color: #0f172a;
        }

        .carousel-item img {
            height: 100%;
            width: 100%;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .carousel-item a:hover img {
            transform: scale(1.025);
        }

        /* Gradient Overlay yang Elegan */
        .carousel-caption-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.4) 50%, rgba(0, 0, 0, 0.82) 100%);
            display: flex;
            align-items: flex-end;
            padding: 36px 48px;
            pointer-events: none;
        }

        .carousel-caption-content {
            color: #ffffff;
            text-align: left;
            max-width: 720px;
            pointer-events: auto;
        }

        .carousel-caption-content h5 {
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.5px;
            margin-bottom: 8px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
            line-height: 1.25;
        }

        .carousel-caption-content p {
            font-size: 15px;
            line-height: 1.55;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 0;
            text-shadow: 0 1px 6px rgba(0, 0, 0, 0.4);
        }

        /* Sleek Indicators */
        .carousel-indicators {
            bottom: 20px;
            gap: 8px;
            margin-bottom: 0;
        }

        .carousel-indicators [data-bs-target] {
            width: 10px;
            height: 6px;
            border-radius: 9999px;
            background-color: rgba(255, 255, 255, 0.55);
            border: none;
            opacity: 0.8;
            transition: width 0.3s ease, background-color 0.3s ease;
        }

        .carousel-indicators .active {
            width: 32px;
            background-color: #ffffff;
            opacity: 1;
        }

        /* Glassmorphic Arrow Controls */
        .carousel-control-prev,
        .carousel-control-next {
            width: 50px;
            height: 50px;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(255, 255, 255, 0.22);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.35);
            border-radius: 50%;
            margin: 0 20px;
            opacity: 0;
            transition: var(--transition-smooth);
        }

        #carouselExampleCaptions:hover .carousel-control-prev,
        #carouselExampleCaptions:hover .carousel-control-next {
            opacity: 0.9;
        }

        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            opacity: 1 !important;
            background-color: rgba(255, 255, 255, 0.45);
            transform: translateY(-50%) scale(1.08);
        }

        /* Divider Garis Elegan */
        .carousel-divider {
            max-width: 1320px;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(111, 143, 70, 0.35) 20%, rgba(111, 143, 70, 0.35) 80%, transparent);
            margin: 36px auto 28px auto;
        }

        /* -------------------------------------------------
           CATEGORY SECTION
        ------------------------------------------------- */
        .category-section {
            max-width: 1320px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .category-title {
            text-align: center;
            margin-bottom: 24px;
        }

        .category-title h2 {
            font-size: 26px;
            font-weight: 700;
            color: var(--text-heading);
            letter-spacing: -0.5px;
            position: relative;
            display: inline-block;
        }

        .category-title h2::after {
            content: '';
            display: block;
            width: 44px;
            height: 3px;
            background-color: var(--brand-primary);
            border-radius: 9999px;
            margin: 8px auto 0 auto;
        }

        /* Modern Grid untuk Kategori */
        .category-container {
            display: grid;
            grid-template-columns: repeat(10, 1fr);
            gap: 14px;
            margin-bottom: 40px;
        }

        .category-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 12px 8px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            box-shadow: var(--shadow-subtle);
            transition: var(--transition-smooth);
            min-height: 116px;
        }

        .category-card-icon-wrapper {
            width: 58px;
            height: 58px;
            border-radius: var(--radius-md);
            background-color: var(--brand-primary-subtle);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
            transition: var(--transition-smooth);
        }

        .category-card img {
            width: 40px;
            height: 40px;
            object-fit: contain;
            transition: var(--transition-smooth);
        }

        .category-card h3 {
            font-size: 11.5px;
            font-weight: 600;
            color: var(--text-body);
            text-align: center;
            line-height: 1.3;
            margin: 0;
            transition: var(--transition-smooth);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 30px;
        }

        .category-card:hover {
            transform: translateY(-4px);
            border-color: var(--border-hover);
            box-shadow: var(--shadow-card-hover);
            background-color: #ffffff;
        }

        .category-card:hover .category-card-icon-wrapper {
            background-color: var(--brand-primary-light);
            transform: scale(1.05);
        }

        .category-card:hover h3 {
            color: var(--brand-primary);
        }

        /* -------------------------------------------------
           PRODUCT LISTING SECTION
        ------------------------------------------------- */
        .product-section {
            max-width: 1320px;
            margin: 0 auto 60px auto;
            padding: 0 24px;
        }

        .product-container {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 20px;
        }

        /* Kartu Produk Modern */
        .product-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: var(--shadow-card);
            transition: var(--transition-smooth);
            text-decoration: none;
            color: inherit;
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-6px);
            border-color: var(--border-hover);
            box-shadow: var(--shadow-card-hover);
            color: inherit;
        }

        /* Area Gambar Produk */
        .product-image-box {
            position: relative;
            width: 100%;
            height: 200px;
            background-color: #f8faf9;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            overflow: hidden;
        }

        .product-image-box img {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
            transition: transform 0.4s ease;
        }

        .product-card:hover .product-image-box img {
            transform: scale(1.06);
        }

        /* Status Badge (Tersedia) */
        .product-status-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 9999px;
            background-color: var(--brand-accent-bg);
            color: var(--brand-accent-green);
            border: 1px solid var(--brand-accent-border);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
            z-index: 2;
            letter-spacing: 0.2px;
        }

        /* Informasi Produk */
        .product-info {
            padding: 16px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .product-category {
            font-size: 11px;
            font-weight: 700;
            color: var(--brand-primary);
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 6px;
        }

        .product-name {
            font-size: 14.5px;
            font-weight: 600;
            color: var(--text-heading);
            line-height: 1.4;
            margin-bottom: 14px;
            height: 42px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            transition: color 0.2s ease;
        }

        .product-card:hover .product-name {
            color: var(--brand-primary);
        }

        /* Footer Kartu: Harga & Tombol Add */
        .product-footer {
            margin-top: auto;
            padding-top: 12px;
            border-top: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }

        .price-container {
            display: flex;
            flex-direction: column;
        }

        .price-label {
            font-size: 10.5px;
            color: var(--text-muted);
            font-weight: 500;
            margin-bottom: 2px;
        }

        .current-price {
            font-size: 15.5px;
            font-weight: 800;
            color: var(--text-heading);
            letter-spacing: -0.3px;
        }

        .add-to-cart-container {
            position: relative;
            z-index: 5;
        }

        .add-to-cart {
            background-color: var(--brand-primary);
            color: #ffffff;
            border: none;
            padding: 7px 14px;
            border-radius: var(--radius-sm);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12.5px;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition-smooth);
            box-shadow: 0 2px 8px rgba(111, 143, 70, 0.25);
        }

        .add-to-cart img {
            width: 14px;
            height: 14px;
            filter: brightness(0) invert(1);
            transition: transform 0.2s ease;
        }

        .add-to-cart:hover {
            background-color: var(--brand-primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 14px rgba(111, 143, 70, 0.35);
        }

        .add-to-cart:hover img {
            transform: scale(1.15);
        }

        .add-to-cart:active {
            transform: translateY(0);
        }

        /* Stretched Link untuk Navigasi Kartu Aman */
        .product-link-overlay {
            position: absolute;
            inset: 0;
            z-index: 1;
        }

        /* -------------------------------------------------
           FOOTER SECTION
        ------------------------------------------------- */
        footer {
            background-color: #ffffff;
            border-top: 1px solid var(--border-color);
            padding: 24px 0;
            margin-top: 40px;
        }

        .footer-container {
            max-width: 1320px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .footer-left p {
            margin: 0;
            font-size: 13.5px;
            font-weight: 500;
            color: var(--text-muted);
        }

        .footer-middle {
            display: flex;
            align-items: center;
        }

        .social-icons {
            display: flex;
            gap: 10px;
        }

        .social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: var(--bg-page);
            border: 1px solid var(--border-color);
            transition: var(--transition-smooth);
            text-decoration: none;
        }

        .social-icon img {
            width: 17px;
            height: 17px;
            opacity: 0.7;
            transition: var(--transition-smooth);
        }

        .social-icon:hover {
            background-color: var(--brand-primary-subtle);
            border-color: var(--brand-primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(111, 143, 70, 0.15);
        }

        .social-icon:hover img {
            opacity: 1;
            transform: scale(1.1);
        }

        /* -------------------------------------------------
           RESPONSIVE BREAKPOINTS (Mobile & Tablet)
        ------------------------------------------------- */
        @media (max-width: 1200px) {
            .category-container {
                grid-template-columns: repeat(5, 1fr);
            }

            .product-container {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        @media (max-width: 992px) {
            .product-container {
                grid-template-columns: repeat(3, 1fr);
            }

            .carousel-item {
                height: 360px;
            }

            .carousel-caption-content h5 {
                font-size: 22px;
            }
        }

        @media (max-width: 768px) {
            .header-container {
                padding: 10px 16px;
            }

            .header-left {
                gap: 16px;
            }

            .logo img {
                height: 44px;
            }

            nav ul li a {
                font-size: 13.5px;
                padding: 6px 12px;
            }

            .carousel-item {
                height: 260px;
            }

            .carousel-caption-overlay {
                padding: 20px 24px;
            }

            .carousel-caption-content h5 {
                font-size: 18px;
            }

            .carousel-caption-content p {
                font-size: 13px;
            }

            .carousel-control-prev,
            .carousel-control-next {
                display: none;
            }

            .category-container {
                grid-template-columns: repeat(5, 1fr);
                gap: 10px;
            }

            .category-card {
                padding: 10px 6px;
                min-height: 100px;
            }

            .category-card-icon-wrapper {
                width: 46px;
                height: 46px;
            }

            .category-card img {
                width: 28px;
                height: 28px;
            }

            .category-card h3 {
                font-size: 10.5px;
            }

            .product-container {
                grid-template-columns: repeat(2, 1fr);
                gap: 14px;
            }

            .product-image-box {
                height: 160px;
                padding: 10px;
            }

            .product-info {
                padding: 12px;
            }

            .product-name {
                font-size: 13px;
                height: 36px;
                margin-bottom: 8px;
            }

            .current-price {
                font-size: 14px;
            }

            .add-to-cart {
                padding: 6px 10px;
                font-size: 11.5px;
            }

            .footer-container {
                flex-direction: column;
                text-align: center;
                gap: 12px;
            }
        }

        @media (max-width: 480px) {
            .category-container {
                grid-template-columns: repeat(3, 1fr);
            }
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="header-container">
            <div class="header-left">
                <div class="logo">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('images/logo2.png') }}" alt="Brand Logo">
                    </a>
                </div>
                <nav>
                    <ul>
                        <li><a href="{{ url('/kategori') }}">Collection</a></li>
                        <li><a href="{{ url('/about') }}">About Us</a></li>
                    </ul>
                </nav>
            </div>
            <!-- Cart, Search, and Account Icons -->
            <div class="cart-search">
                <div class="icons">
                    <a href="{{ route('keranjang') }}" title="Keranjang Belanja">
                        <img src="https://img.icons8.com/material/24/ffffff/shopping-cart.png" alt="Cart">
                    </a>
                    <a href="{{ route('diskusi.index') }}" title="Diskusi Produk">
                        <img src="https://img.icons8.com/?size=100&id=123773&format=png&color=ffffff" alt="Diskusi">
                    </a>
                    <a href="{{ route(Auth::guard('penitip')->check() ? 'penitip.profil' : 'pembeli.profil') }}" title="Akun Pengguna">
                        <img src="https://img.icons8.com/material/24/ffffff/user.png" alt="Account">
                    </a>
                </div>
            </div>
        </div>
    </header>

    {{-- Toast Notifikasi Sukses / Peringatan --}}
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1055;">
        @if (session('success'))
            <div id="liveToast" class="toast fade shadow-lg border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header text-white" style="background-color: var(--brand-primary);">
                    <strong class="me-auto">Sukses</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body bg-white text-dark">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if (session('warning'))
            <div id="liveToast" class="toast fade shadow-lg border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-danger text-white">
                    <strong class="me-auto">Peringatan</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body bg-white text-dark">
                    {{ session('warning') }}
                </div>
            </div>
        @endif
    </div>

    <!-- Main Section -->
    <main>
        <!-- Hero Carousel Section -->
        <section class="hero-section">
            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    @foreach($barangs->take(3) as $index => $barang)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <a href="{{ url('product/' . $barang->id_barang) }}">
                            <img src="{{ asset('images/barang/' . ($barang->fotoBarang->first()->nama_file ?? 'default.jpg')) }}" alt="{{ $barang->nama_barang }}" class="d-block w-100">
                        </a>
                        <div class="carousel-caption-overlay d-none d-md-flex">
                            <div class="carousel-caption-content">
                                <h5>{{ $barang->nama_barang }}</h5>
                                <p>{{ Str::limit($barang->deskripsi, 110) }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section>

        <!-- Garis Pemisah Carousel -->
        <div class="carousel-divider"></div>

        <!-- Featured Categories Section -->
        <section class="category-section">
            <div class="category-title">
                <h2>Kategori</h2>
            </div>

            <div class="category-container">
                <!-- Category 1 -->
                <a href="{{ url('kategori/1') }}" class="category-card">
                    <div class="category-card-icon-wrapper">
                        <img src="{{ asset('images/kategori/laptop.png') }}" alt="Elektronik & Gadget">
                    </div>
                    <h3>Elektronik & Gadget</h3>
                </a>
                <!-- Category 2 -->
                <a href="{{ url('kategori/2') }}" class="category-card">
                    <div class="category-card-icon-wrapper">
                        <img src="{{ asset('images/kategori/baju.png') }}" alt="Pakaian & Aksesori">
                    </div>
                    <h3>Pakaian & Aksesori</h3>
                </a>
                <!-- Category 3 -->
                <a href="{{ url('kategori/3') }}" class="category-card">
                    <div class="category-card-icon-wrapper">
                        <img src="{{ asset('images/kategori/sofa.png') }}" alt="Perabotan Rumah Tangga">
                    </div>
                    <h3>Perabotan Rumah Tangga</h3>
                </a>
                <!-- Category 4 -->
                <a href="{{ url('kategori/4') }}" class="category-card">
                    <div class="category-card-icon-wrapper">
                        <img src="{{ asset('images/kategori/tas.png') }}" alt="Buku, Alat Tulis, Peralatan Sekolah">
                    </div>
                    <h3>Buku, Alat Tulis, Peralatan Sekolah</h3>
                </a>
                <!-- Category 5 -->
                <a href="{{ url('kategori/5') }}" class="category-card">
                    <div class="category-card-icon-wrapper">
                        <img src="{{ asset('images/kategori/mainan.png') }}" alt="Hobi, Mainan, Koleksi">
                    </div>
                    <h3>Hobi, Mainan, Koleksi</h3>
                </a>
                <!-- Category 6 -->
                <a href="{{ url('kategori/6') }}" class="category-card">
                    <div class="category-card-icon-wrapper">
                        <img src="{{ asset('images/kategori/bayi.png') }}" alt="Perlengkapan Bayi & Anak">
                    </div>
                    <h3>Perlengkapan Bayi & Anak</h3>
                </a>
                <!-- Category 7 -->
                <a href="{{ url('kategori/7') }}" class="category-card">
                    <div class="category-card-icon-wrapper">
                        <img src="{{ asset('images/kategori/roda.png') }}" alt="Otomotif & Aksesori">
                    </div>
                    <h3>Otomotif & Aksesori</h3>
                </a>
                <!-- Category 8 -->
                <a href="{{ url('kategori/8') }}" class="category-card">
                    <div class="category-card-icon-wrapper">
                        <img src="{{ asset('images/kategori/tenda.png') }}" alt="Perlengkapan Taman & Outdoor">
                    </div>
                    <h3>Perlengkapan Taman & Outdoor</h3>
                </a>
                <!-- Category 9 -->
                <a href="{{ url('kategori/9') }}" class="category-card">
                    <div class="category-card-icon-wrapper">
                        <img src="{{ asset('images/kategori/kantor.png') }}" alt="Peralatan Kantor & Industri">
                    </div>
                    <h3>Peralatan Kantor & Industri</h3>
                </a>
                <!-- Category 10 -->
                <a href="{{ url('kategori/10') }}" class="category-card">
                    <div class="category-card-icon-wrapper">
                        <img src="{{ asset('images/kategori/cermin.png') }}" alt="Kosmetik & Perawatan Diri">
                    </div>
                    <h3>Kosmetik & Perawatan Diri</h3>
                </a>
            </div>
        </section>

        <!-- Product Listing Section -->
        <section class="product-section">
            <div class="product-container">
                @foreach($barangs->take(10) as $barang)
                <div class="product-card">
                    <!-- Overlay Link ke Halaman Detail Produk -->
                    <a href="{{ url('product/' . $barang->id_barang) }}" class="product-link-overlay" aria-label="Lihat detail {{ $barang->nama_barang }}"></a>

                    <!-- Area Gambar & Status -->
                    <div class="product-image-box">
                        <span class="product-status-badge">{{ $barang->status_barang }}</span>
                        <img src="{{ asset('images/barang/' . ($barang->fotoBarang->first()->nama_file ?? 'default.jpg')) }}" alt="{{ $barang->nama_barang }}" loading="lazy">
                    </div>

                    <!-- Informasi Produk -->
                    <div class="product-info">
                        <span class="product-category">{{ $barang->kategori->nama_kategori ?? 'Kategori Tidak Ada' }}</span>
                        <h3 class="product-name">{{ $barang->nama_barang }}</h3>
                        
                        <!-- Harga & Tombol Aksi Tambah ke Keranjang -->
                        <div class="product-footer">
                            <div class="price-container">
                                <span class="current-price">Rp{{ number_format($barang->harga_jual, 0, ',', '.') }}</span>
                            </div>
                            <div class="add-to-cart-container">
                                <form action="{{ route('keranjang.tambah') }}" method="POST" novalidate>
                                    @csrf
                                    <input type="hidden" name="id_barang" value="{{ $barang->id_barang }}">
                                    <button type="submit" class="add-to-cart" title="Tambah ke Keranjang">
                                        <img src="https://img.icons8.com/material/24/ffffff/shopping-cart.png" alt="Cart">
                                        Add
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
    </main>

    <!-- Footer Section -->
    <footer>
        <div class="footer-container">
            <div class="footer-left">
                <p>© 2025 ReUseMart. All rights reserved.</p>
            </div>
            <div class="footer-middle">
                <div class="social-icons">
                    <a href="#" class="social-icon" aria-label="Facebook"><img src="https://img.icons8.com/material/24/000000/facebook.png" alt="Facebook"></a>
                    <a href="#" class="social-icon" aria-label="Twitter"><img src="https://img.icons8.com/material/24/000000/twitter.png" alt="Twitter"></a>
                    <a href="#" class="social-icon" aria-label="Instagram"><img src="https://img.icons8.com/material/24/000000/instagram.png" alt="Instagram"></a>
                    <a href="#" class="social-icon" aria-label="Pinterest"><img src="https://img.icons8.com/material/24/000000/pinterest.png" alt="Pinterest"></a>
                    <a href="#" class="social-icon" aria-label="YouTube"><img src="https://img.icons8.com/material/24/000000/youtube.png" alt="YouTube"></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS and dependencies (Popper.js and Bootstrap JS) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

    <script>
        const toastLive = document.getElementById('liveToast');
        if (toastLive) {
            const toast = new bootstrap.Toast(toastLive);
            toast.show();
        }
    </script>
</body>
</html>
