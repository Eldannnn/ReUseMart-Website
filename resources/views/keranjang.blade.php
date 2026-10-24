<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - ReUseMart</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">


    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- ReUseMart Unified Design System -->
    <link rel="stylesheet" href="{{ asset('css/reusemart-theme.css') }}">

    <style>
        .cart-page-section {
            max-width: 960px;
            margin: 40px auto 60px auto;
            padding: 0 24px;
        }

        .cart-header-title {
            font-size: 26px;
            font-weight: 800;
            color: var(--text-heading);
            margin-bottom: 24px;
            position: relative;
            display: inline-block;
        }

        .cart-header-title::after {
            content: '';
            display: block;
            width: 40px;
            height: 3px;
            background-color: var(--brand-primary);
            border-radius: 9999px;
            margin-top: 6px;
        }

        .cart-item-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 24px;
            margin-bottom: 16px;
            box-shadow: var(--shadow-card);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            transition: var(--transition-smooth);
        }

        .cart-item-card:hover {
            border-color: var(--border-hover);
            box-shadow: var(--shadow-card-hover);
        }

        .cart-item-info {
            flex-grow: 1;
        }

        .cart-item-name {
            font-size: 18px;
            font-weight: 700;
            color: var(--brand-primary);
            text-decoration: none;
            display: block;
            margin-bottom: 6px;
            transition: var(--transition-smooth);
        }

        .cart-item-name:hover {
            color: var(--brand-primary-hover);
        }

        .cart-item-desc {
            font-size: 14px;
            color: var(--text-muted);
            margin-bottom: 12px;
            line-height: 1.5;
        }

        .cart-item-price {
            font-size: 18px;
            font-weight: 800;
            color: var(--text-heading);
        }

        .cart-item-sold-alert {
            background-color: var(--accent-danger-bg);
            color: var(--accent-danger);
            border: 1px solid var(--accent-danger-border);
            border-radius: var(--radius-sm);
            padding: 6px 12px;
            font-size: 13px;
            font-weight: 600;
            display: inline-block;
            margin-top: 8px;
        }

        .cart-checkout-bar {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 20px 24px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            box-shadow: var(--shadow-card);
            margin-top: 24px;
        }

        .empty-cart-card {
            background-color: var(--bg-card);
            border: 1px dashed var(--border-color);
            border-radius: var(--radius-xl);
            padding: 56px 24px;
            text-align: center;
            color: var(--text-muted);
        }

        @media (max-width: 768px) {
            .cart-item-card {
                flex-direction: column;
                align-items: flex-start;
            }
            .cart-checkout-bar {
                justify-content: stretch;
            }
            .cart-checkout-bar a {
                width: 100%;
                text-align: center;
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
                    <a href="{{ route('diskusi.index') }}" title="Diskusi Produk">
                        <img src="https://img.icons8.com/?size=100&id=123773&format=png&color=ffffff" alt="Diskusi">
                    </a>
                    <a href="{{ route('pembeli.profil') }}" title="Akun Pengguna">
                        <img src="https://img.icons8.com/material/24/ffffff/user.png" alt="Account">
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Section -->
    <main>
        <div class="cart-page-section">
            <h1 class="cart-header-title">Keranjang Anda</h1>

            @forelse($items as $item)
                <div class="cart-item-card">
                    <div class="cart-item-info">
                        <a href="{{ url('product/' . $item->id_barang) }}" class="cart-item-name">
                            {{ $item->nama_barang }}
                        </a>
                        <p class="cart-item-desc">{{ $item->deskripsi }}</p>
                        
                        <p id="status-{{ $item->id_barang }}" class="d-none">{{ $item->status_barang }}</p>
                        @if($item->status_barang == 'Terjual')
                            <div class="cart-item-sold-alert">
                                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                Barang sudah sold out dan tidak bisa dibeli!
                            </div>
                        @endif

                        <div class="cart-item-price mt-2">
                            Rp{{ number_format($item->harga_jual, 0, ',', '.') }}
                        </div>
                    </div>

                    <form action="{{ route('keranjang.hapus', $item->id_barang) }}" method="POST" novalidate>
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="bi bi-trash3 me-1"></i> Hapus
                        </button>
                    </form>
                </div>
            @empty
                <div class="empty-cart-card">
                    <i class="bi bi-cart-x fs-1 d-block mb-3 text-muted"></i>
                    <h4 class="fw-bold mb-2">Keranjang Anda Masih Kosong</h4>
                    <p class="text-muted mb-4">Temukan barang berkualitas ramah lingkungan sekarang juga.</p>
                    <a href="{{ url('/kategori') }}" class="btn btn-primary">
                        Mulai Belanja
                    </a>
                </div>
            @endforelse

            @if(count($items) > 0)
                <div class="cart-checkout-bar">
                    <a href="{{ route('checkout') }}" class="btn btn-primary btn-lg px-4">
                        <i class="bi bi-arrow-right-circle me-1"></i> Lanjut ke Checkout
                    </a>
                </div>
            @endif
        </div>
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