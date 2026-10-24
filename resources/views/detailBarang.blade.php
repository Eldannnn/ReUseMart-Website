<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->nama_barang }} - ReUseMart</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">


    <!-- Bootstrap 5 CSS & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- ReUseMart Unified Design System -->
    <link rel="stylesheet" href="{{ asset('css/reusemart-theme.css') }}">

    <style>
        .detail-section {
            max-width: 1320px;
            margin: 36px auto 60px auto;
            padding: 0 24px;
        }

        .product-detail-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-card);
            overflow: hidden;
            padding: 32px;
        }

        .product-detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: start;
        }

        /* Carousel Gallery */
        #productCarousel {
            border-radius: var(--radius-lg);
            overflow: hidden;
            background-color: #f8faf9;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
            border: 1px solid var(--border-color);
        }

        #productCarousel .carousel-inner {
            height: 440px;
        }

        #productCarousel .carousel-item {
            height: 100%;
        }

        #productCarousel .carousel-item img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 20px;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 44px;
            height: 44px;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 50%;
            border: 1px solid rgba(0, 0, 0, 0.08);
            margin: 0 12px;
            transition: var(--transition-smooth);
        }

        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            background-color: #ffffff;
            transform: translateY(-50%) scale(1.08);
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            filter: invert(1) grayscale(100);
            width: 20px;
            height: 20px;
        }

        /* Product Info Styling */
        .product-category-badge {
            display: inline-block;
            font-size: 11.5px;
            font-weight: 700;
            color: var(--brand-primary);
            text-transform: uppercase;
            letter-spacing: 0.6px;
            background-color: var(--brand-primary-subtle);
            padding: 5px 12px;
            border-radius: 9999px;
            margin-bottom: 12px;
        }

        .product-title {
            font-size: 28px;
            font-weight: 800;
            color: var(--text-heading);
            line-height: 1.3;
            margin-bottom: 14px;
        }

        .product-penitip-rating {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-bottom: 16px;
            margin-bottom: 16px;
            border-bottom: 1px solid var(--border-color);
        }

        .penitip-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-body);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .rating-stars {
            display: flex;
            align-items: center;
            gap: 3px;
            font-size: 13.5px;
        }

        .product-price-box {
            background-color: var(--brand-primary-subtle);
            border: 1px solid rgba(111, 143, 70, 0.2);
            border-radius: var(--radius-md);
            padding: 16px 20px;
            margin-bottom: 20px;
        }

        .price-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--brand-primary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .price-value {
            font-size: 28px;
            font-weight: 800;
            color: var(--text-heading);
            letter-spacing: -0.5px;
        }

        .product-specs-box {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 20px;
            background-color: var(--bg-page);
            padding: 16px;
            border-radius: var(--radius-md);
            border: 1px solid var(--border-color);
        }

        .spec-item {
            font-size: 13px;
        }

        .spec-label {
            color: var(--text-muted);
            margin-bottom: 2px;
        }

        .spec-val {
            font-weight: 600;
            color: var(--text-heading);
        }

        .product-desc-box {
            margin-bottom: 28px;
        }

        .product-desc-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-heading);
            margin-bottom: 6px;
        }

        .product-desc-content {
            font-size: 14px;
            line-height: 1.6;
            color: var(--text-body);
            white-space: pre-line;
        }

        /* Action Buttons */
        .action-button-group {
            display: flex;
            gap: 14px;
        }

        .add-to-cart-btn {
            flex: 1;
            background-color: #ffffff;
            color: var(--brand-primary);
            border: 2px solid var(--brand-primary);
            padding: 12px 20px;
            border-radius: var(--radius-md);
            font-size: 14px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: var(--transition-smooth);
            cursor: pointer;
        }

        .add-to-cart-btn:hover {
            background-color: var(--brand-primary-subtle);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(111, 143, 70, 0.15);
        }

        .buy-now-btn {
            flex: 1.2;
            background-color: var(--brand-primary);
            color: #ffffff;
            border: none;
            padding: 12px 20px;
            border-radius: var(--radius-md);
            font-size: 14px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            transition: var(--transition-smooth);
            box-shadow: 0 4px 14px rgba(111, 143, 70, 0.3);
        }

        .buy-now-btn:hover {
            background-color: var(--brand-primary-hover);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(111, 143, 70, 0.4);
        }

        /* Related Products Section */
        .related-section {
            margin-top: 50px;
        }

        .related-title {
            font-size: 22px;
            font-weight: 700;
            color: var(--text-heading);
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
        }

        .related-title::after {
            content: '';
            display: block;
            width: 36px;
            height: 3px;
            background-color: var(--brand-primary);
            border-radius: 9999px;
            margin-top: 6px;
        }

        .related-products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
            gap: 20px;
        }

        .related-product-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            text-decoration: none;
            color: inherit;
            box-shadow: var(--shadow-subtle);
            transition: var(--transition-smooth);
        }

        .related-product-card:hover {
            transform: translateY(-4px);
            border-color: var(--border-hover);
            box-shadow: var(--shadow-card-hover);
            color: inherit;
        }

        .related-image-wrapper {
            height: 160px;
            background-color: #f8faf9;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px;
        }

        .related-image-wrapper img {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
            transition: transform 0.3s;
        }

        .related-product-card:hover .related-image-wrapper img {
            transform: scale(1.05);
        }

        .related-info {
            padding: 12px 14px;
        }

        .related-category {
            font-size: 10.5px;
            font-weight: 700;
            color: var(--brand-primary);
            text-transform: uppercase;
        }

        .related-name {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text-heading);
            margin: 4px 0 6px 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .related-price {
            font-size: 14.5px;
            font-weight: 700;
            color: var(--text-heading);
        }

        @media (max-width: 992px) {
            .product-detail-grid {
                grid-template-columns: 1fr;
                gap: 28px;
            }
            #productCarousel .carousel-inner {
                height: 340px;
            }
        }

        @media (max-width: 576px) {
            .product-detail-card {
                padding: 20px;
            }
            .action-button-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

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
                    <a href="{{ route('checkout') }}" title="Checkout">
                        <img src="https://img.icons8.com/material/24/ffffff/user.png" alt="Account">
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Section -->
    <main>
        <section class="detail-section">
            <div class="product-detail-card">
                <div class="product-detail-grid">
                    <!-- Gallery Carousel -->
                    <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            @foreach ($product->fotoBarang as $index => $foto)
                                <button type="button"
                                        data-bs-target="#productCarousel"
                                        data-bs-slide-to="{{ $index }}"
                                        class="{{ $index == 0 ? 'active' : '' }}"
                                        aria-current="{{ $index == 0 ? 'true' : 'false' }}"
                                        aria-label="Slide {{ $index + 1 }}"></button>
                            @endforeach
                        </div>

                        <div class="carousel-inner">
                            @foreach ($product->fotoBarang as $index => $foto)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <img src="{{ asset('images/barang/' . $foto->nama_file) }}"
                                        class="d-block w-100"
                                        alt="{{ $product->nama_barang }} - Foto {{ $index + 1 }}">
                                </div>
                            @endforeach
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev" aria-label="Previous">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next" aria-label="Next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>

                    <!-- Informasi Produk -->
                    <div class="product-info-box">
                        <span class="product-category-badge">{{ $product->kategori->nama_kategori }}</span>
                        <h1 class="product-title">{{ $product->nama_barang }}</h1>

                        <!-- Penitip & Rating Row -->
                        <div class="product-penitip-rating">
                            <span class="penitip-name">
                                <i class="bi bi-shop text-muted"></i>
                                Penitip: <strong>{{ $product->penitip->nama_penitip }}</strong>
                            </span>
                            <span class="text-muted">|</span>
                            <div class="rating-stars">
                                @if($avgRating > 0)
                                    @php
                                        $rounded = round($avgRating * 2) / 2; 
                                        $fullStars = floor($rounded);
                                        $halfStar  = ($rounded - $fullStars) == 0.5 ? 1 : 0;
                                        $emptyStars = 5 - $fullStars - $halfStar;
                                    @endphp
                                    @for($i = 0; $i < $fullStars; $i++)
                                        <i class="fas fa-star text-warning"></i>
                                    @endfor
                                    @if($halfStar)
                                        <i class="fas fa-star-half-alt text-warning"></i>
                                    @endif
                                    @for($i = 0; $i < $emptyStars; $i++)
                                        <i class="far fa-star text-warning"></i>
                                    @endfor
                                    <span class="fw-bold ms-1 text-dark">({{ number_format($avgRating, 1) }})</span>
                                @else
                                    @for($i = 0; $i < 5; $i++)
                                        <i class="far fa-star text-muted"></i>
                                    @endfor
                                    <small class="text-muted ms-1">(Belum ada rating)</small>
                                @endif
                            </div>
                        </div>

                        <!-- Harga Produk -->
                        <div class="product-price-box">
                            <div class="price-label">Harga Barang</div>
                            <div class="price-value">Rp{{ number_format($product->harga_jual, 0, ',', '.') }}</div>
                        </div>

                        <!-- Spesifikasi Cepat -->
                        <div class="product-specs-box">
                            <div class="spec-item">
                                <div class="spec-label">Berat Barang</div>
                                <div class="spec-val">{{ $product->berat }} kg</div>
                            </div>
                            <div class="spec-item">
                                <div class="spec-label">Status Barang</div>
                                <div class="spec-val">
                                    <span class="product-status-badge">{{ $product->status_barang }}</span>
                                </div>
                            </div>
                            <div class="spec-item" style="grid-column: 1 / -1;">
                                <div class="spec-label">Status Garansi</div>
                                <div class="spec-val">
                                    @if ($garansi_status !== "Garansi Tidak Tersedia")
                                        <span class="text-success"><i class="bi bi-shield-check me-1"></i>{{ $garansi_status }} hingga {{ \Carbon\Carbon::parse($product->tanggal_garansi)->format('d M Y') }}</span>
                                    @else
                                        <span class="text-muted"><i class="bi bi-shield-x me-1"></i>{{ $garansi_status }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Deskripsi Produk -->
                        <div class="product-desc-box">
                            <div class="product-desc-title">Deskripsi Produk</div>
                            <div class="product-desc-content">{{ $product->deskripsi }}</div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="action-button-group">
                            <form action="{{ route('keranjang.tambah') }}" method="POST" class="flex-grow-1" novalidate>
                                @csrf
                                <input type="hidden" name="id_barang" value="{{ $product->id_barang }}">
                                <button type="submit" class="add-to-cart-btn w-100">
                                    <i class="bi bi-cart-plus fs-5"></i>
                                    Add to Cart
                                </button>
                            </form>
                            <a href="{{ route('checkout') }}" class="buy-now-btn">
                                <i class="bi bi-lightning-charge fs-5"></i>
                                Beli Barang
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Produk Serupa -->
                <div class="related-section">
                    <h2 class="related-title">Produk Serupa</h2>
                    <div class="related-products-grid">
                        @forelse($produk_serupa as $item)
                            <a href="{{ url('product/' . $item->id_barang) }}" class="related-product-card">
                                <div class="related-image-wrapper">
                                    <img src="{{ asset('images/barang/' . ($item->fotoBarang->first()->nama_file ?? 'default.jpg')) }}" alt="{{ $item->nama_barang }}" loading="lazy">
                                </div>
                                <div class="related-info">
                                    <span class="related-category">{{ $item->kategori->nama_kategori ?? 'Kategori' }}</span>
                                    <h4 class="related-name">{{ $item->nama_barang }}</h4>
                                    <div class="related-price">Rp{{ number_format($item->harga_jual, 0, ',', '.') }}</div>
                                </div>
                            </a>
                        @empty
                            <p class="text-muted">Tidak ada produk serupa untuk ditampilkan.</p>
                        @endforelse
                    </div>
                </div>
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

    <script>
        const toastLive = document.getElementById('liveToast');
        if (toastLive) {
            const toast = new bootstrap.Toast(toastLive);
            toast.show();
        }
    </script>
</body>
</html>
