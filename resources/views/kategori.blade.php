<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReUseMart - Collection</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">


    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- ReUseMart Unified Design System -->
    <link rel="stylesheet" href="{{ asset('css/reusemart-theme.css') }}">

    <style>
        .category-filter-section {
            max-width: 1320px;
            margin: 28px auto 0 auto;
            padding: 0 24px;
        }

        .category-container {
            display: grid;
            grid-template-columns: repeat(10, 1fr);
            gap: 12px;
            margin-bottom: 24px;
        }

        .category-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 10px 6px;
            text-align: center;
            text-decoration: none;
            box-shadow: var(--shadow-subtle);
            transition: var(--transition-smooth);
            min-height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .category-card h3 {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-body);
            margin: 0;
            line-height: 1.3;
            transition: var(--transition-smooth);
            text-align: center;
        }

        .category-card:hover {
            transform: translateY(-2px);
            border-color: var(--border-hover);
            box-shadow: var(--shadow-card-hover);
            background-color: #ffffff;
        }

        .category-card:hover h3 {
            color: var(--brand-primary);
        }

        .category-card.active {
            background-color: var(--brand-primary);
            border-color: var(--brand-primary);
        }

        .category-card.active h3 {
            color: #ffffff;
        }

        .carousel-divider {
            max-width: 1320px;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(111, 143, 70, 0.35) 20%, rgba(111, 143, 70, 0.35) 80%, transparent);
            margin: 28px auto;
        }

        .product-section {
            max-width: 1320px;
            margin: 0 auto 60px auto;
            padding: 0 24px;
        }

        .search-bar-wrapper {
            display: flex;
            justify-content: flex-start;
            margin-bottom: 24px;
        }

        .search-form {
            display: flex;
            align-items: center;
            gap: 8px;
            max-width: 380px;
            width: 100%;
        }

        .search-form .form-control {
            border-radius: 9999px;
            padding: 9px 18px;
            font-size: 13.5px;
        }

        .search-form .btn-search {
            background-color: var(--brand-primary);
            color: #ffffff;
            border-radius: 9999px;
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            transition: var(--transition-smooth);
        }

        .search-form .btn-search:hover {
            background-color: var(--brand-primary-hover);
            transform: scale(1.05);
        }

        .product-container {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 20px;
        }

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

        .product-status-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 9999px;
            background-color: var(--accent-green-bg);
            color: var(--accent-green);
            border: 1px solid var(--accent-green-border);
            z-index: 2;
        }

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

        .product-footer {
            margin-top: auto;
            padding-top: 12px;
            border-top: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
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
        }

        .add-to-cart:hover {
            background-color: var(--brand-primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 14px rgba(111, 143, 70, 0.35);
        }

        .product-link-overlay {
            position: absolute;
            inset: 0;
            z-index: 1;
        }

        .empty-state-text {
            grid-column: 1 / -1;
            text-align: center;
            padding: 48px 24px;
            color: var(--text-muted);
            font-size: 15px;
            background: #ffffff;
            border: 1px dashed var(--border-color);
            border-radius: var(--radius-lg);
        }

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
        }

        @media (max-width: 768px) {
            .category-container {
                grid-template-columns: repeat(5, 1fr);
                gap: 8px;
            }
            .product-container {
                grid-template-columns: repeat(2, 1fr);
                gap: 14px;
            }
            .product-image-box {
                height: 160px;
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
            <!-- Cart & Account Icons -->
            <div class="cart-search">
                <div class="icons">
                    <a href="{{ route('keranjang') }}" title="Keranjang Belanja">
                        <img src="https://img.icons8.com/material/24/ffffff/shopping-cart.png" alt="Cart">
                    </a>
                    <a href="{{ url('login') }}" title="Akun Pengguna">
                        <img src="https://img.icons8.com/material/24/ffffff/user.png" alt="Account">
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Section -->
    <main>
        <!-- Featured Categories Filter -->
        <section class="category-filter-section">
            <div class="category-container">
                <!-- Category 1 -->
                <a href="{{ url('kategori/1') }}" class="category-card {{ request()->is('kategori/1') ? 'active' : '' }}">
                    <h3>Elektronik & Gadget</h3>
                </a>
                <!-- Category 2 -->
                <a href="{{ url('kategori/2') }}" class="category-card {{ request()->is('kategori/2') ? 'active' : '' }}">
                    <h3>Pakaian & Aksesori</h3>
                </a>
                <!-- Category 3 -->
                <a href="{{ url('kategori/3') }}" class="category-card {{ request()->is('kategori/3') ? 'active' : '' }}">
                    <h3>Perabotan Rumah Tangga</h3>
                </a>
                <!-- Category 4 -->
                <a href="{{ url('kategori/4') }}" class="category-card {{ request()->is('kategori/4') ? 'active' : '' }}">
                    <h3>Buku, Alat Tulis, Peralatan Sekolah</h3>
                </a>
                <!-- Category 5 -->
                <a href="{{ url('kategori/5') }}" class="category-card {{ request()->is('kategori/5') ? 'active' : '' }}">
                    <h3>Hobi, Mainan, Koleksi</h3>
                </a>
                <!-- Category 6 -->
                <a href="{{ url('kategori/6') }}" class="category-card {{ request()->is('kategori/6') ? 'active' : '' }}">
                    <h3>Perlengkapan Bayi & Anak</h3>
                </a>
                <!-- Category 7 -->
                <a href="{{ url('kategori/7') }}" class="category-card {{ request()->is('kategori/7') ? 'active' : '' }}">
                    <h3>Otomotif & Aksesori</h3>
                </a>
                <!-- Category 8 -->
                <a href="{{ url('kategori/8') }}" class="category-card {{ request()->is('kategori/8') ? 'active' : '' }}">
                    <h3>Perlengkapan Taman & Outdoor</h3>
                </a>
                <!-- Category 9 -->
                <a href="{{ url('kategori/9') }}" class="category-card {{ request()->is('kategori/9') ? 'active' : '' }}">
                    <h3>Peralatan Kantor & Industri</h3>
                </a>
                <!-- Category 10 -->
                <a href="{{ url('kategori/10') }}" class="category-card {{ request()->is('kategori/10') ? 'active' : '' }}">
                    <h3>Kosmetik & Perawatan Diri</h3>
                </a>
            </div>
        </section>

        <div class="carousel-divider"></div>

        <!-- Product Listing Section -->
        <section class="product-section">
            <div class="search-bar-wrapper">
                <form class="search-form" action="{{ route('barang.cari') }}" method="GET" novalidate>
                    <input class="form-control" 
                        type="search" 
                        name="search" 
                        placeholder="Cari barang titipan..." 
                        value="{{ request('search') }}" 
                        aria-label="Search">
                    <button class="btn-search" type="submit" title="Cari">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>

            <div class="product-container" id="product-container">
                @if($produk->isEmpty())
                    <div class="empty-state-text">
                        <i class="bi bi-inbox fs-2 d-block mb-2 text-muted"></i>
                        Tidak ada produk yang ditemukan dengan kriteria tersebut.
                    </div>
                @else
                    @forelse($produk as $item)
                        <div class="product-card">
                            <a href="{{ url('product/' . $item->id_barang) }}" class="product-link-overlay" aria-label="Lihat detail {{ $item->nama_barang }}"></a>
                            <div class="product-image-box">
                                <span class="product-status-badge">{{ $item->status_barang }}</span>
                                <img src="{{ asset('images/barang/' . ($item->fotoBarang->first()->nama_file ?? 'default.jpg')) }}" alt="{{ $item->nama_barang }}" loading="lazy">
                            </div>
                            <div class="product-info">
                                <span class="product-category">{{ $item->kategori->nama_kategori ?? 'Kategori Tidak Ada' }}</span>
                                <h3 class="product-name">{{ $item->nama_barang }}</h3>
                                <div class="product-footer">
                                    <div class="price-container">
                                        <span class="current-price">Rp{{ number_format($item->harga_jual, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="add-to-cart-container">
                                        <form action="{{ route('keranjang.tambah') }}" method="POST" novalidate>
                                            @csrf
                                            <input type="hidden" name="id_barang" value="{{ $item->id_barang }}">
                                            <button type="submit" class="add-to-cart" title="Tambah ke Keranjang">
                                                <img src="https://img.icons8.com/material/24/ffffff/shopping-cart.png" alt="Cart">
                                                Add
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state-text">
                            Tidak ada produk tersedia saat ini.
                        </div>
                    @endforelse
                @endif
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

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>