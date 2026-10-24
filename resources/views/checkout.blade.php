<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReUseMart - Checkout</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">


    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- ReUseMart Unified Design System -->
    <link rel="stylesheet" href="{{ asset('css/reusemart-theme.css') }}">

    <style>
        .checkout-section {
            max-width: 1200px;
            margin: 36px auto 60px auto;
            padding: 0 24px;
        }

        .checkout-page-title {
            font-size: 28px;
            font-weight: 800;
            color: var(--text-heading);
            margin-bottom: 28px;
            position: relative;
            display: inline-block;
        }

        .checkout-page-title::after {
            content: '';
            display: block;
            width: 44px;
            height: 3px;
            background-color: var(--brand-primary);
            border-radius: 9999px;
            margin-top: 6px;
        }

        .checkout-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
            margin-bottom: 20px;
            overflow: hidden;
        }

        .checkout-card-header {
            padding: 18px 24px;
            border-bottom: 1px solid var(--border-color);
            background-color: #ffffff;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .checkout-card-header h4,
        .checkout-card-header h5 {
            font-size: 16px;
            font-weight: 700;
            margin: 0;
            color: var(--text-heading);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .checkout-card-body {
            padding: 24px;
        }

        .item-row {
            display: flex;
            gap: 20px;
            align-items: center;
            padding: 16px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .item-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .item-row:first-child {
            padding-top: 0;
        }

        .item-thumb-box {
            width: 90px;
            height: 90px;
            border-radius: var(--radius-md);
            background-color: #f8faf9;
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px;
            flex-shrink: 0;
        }

        .item-thumb-box img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .summary-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
            padding: 24px;
            position: sticky;
            top: 90px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            font-size: 14.5px;
            color: var(--text-body);
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 16px;
            margin-top: 16px;
            border-top: 2px dashed var(--border-color);
        }

        .summary-total-label {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-heading);
        }

        .summary-total-value {
            font-size: 22px;
            font-weight: 800;
            color: var(--brand-primary);
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
                    <a href="{{ route(Auth::guard('penitip')->check() ? 'penitip.profil' : 'pembeli.profil') }}" title="Akun Pengguna">
                        <img src="https://img.icons8.com/material/24/ffffff/user.png" alt="Account">
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Section -->
    <main>
        <div class="checkout-section">
            @if (session('error'))
                <div class="alert alert-danger mb-4 shadow-sm border-0">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                </div>
            @endif

            @php
                $alamatPertama = $alamatList->first();
            @endphp

            <h1 class="checkout-page-title">Checkout Pesanan</h1>

            <div class="row g-4">
                {{-- KIRI: Detail Alamat, Pengiriman & Produk --}}
                <div class="col-lg-8">
                    {{-- Alamat Pengiriman --}}
                    <div class="checkout-card">
                        <div class="checkout-card-header">
                            <h4><i class="bi bi-geo-alt me-2 text-success"></i>Alamat Pengiriman</h4>
                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#gantiAlamatModal">
                                Ganti Alamat
                            </button>
                        </div>
                        <div class="checkout-card-body">
                            <div id="alamatUtama">
                                @if($alamatPertama)
                                    <p class="mb-1 fw-bold text-dark">{{ $alamatPertama->jalan }}</p>
                                    <p class="mb-1 text-muted">
                                        {{ $alamatPertama->kelurahan }}, {{ $alamatPertama->kecamatan }}, {{ $alamatPertama->kota }}, {{ $alamatPertama->provinsi }} {{ $alamatPertama->kode_pos }}
                                    </p>
                                    @if($alamatPertama->detail)
                                        <p class="mb-0 text-muted small"><span class="fw-semibold">Detail:</span> {{ $alamatPertama->detail }}</p>
                                    @endif
                                @else
                                    <p class="text-danger mb-0">Belum ada alamat pengiriman terdaftar.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Jenis Pengiriman --}}
                    <div class="checkout-card">
                        <div class="checkout-card-header">
                            <h4><i class="bi bi-truck me-2 text-success"></i>Metode Pengiriman</h4>
                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#gantiPengirimanModal">
                                Ganti Metode
                            </button>
                        </div>
                        <div class="checkout-card-body">
                            <div id="jenisPengirimanTerpilih">
                                <span class="badge bg-light text-dark border p-2 fs-6">
                                    <i class="bi bi-check-circle-fill text-success me-1"></i> Kurir
                                </span>
                            </div>
                            <input type="hidden" id="inputJenisPengiriman" value="Kurir">
                        </div>
                    </div>

                    {{-- Daftar Produk --}}
                    <div class="checkout-card">
                        <div class="checkout-card-header">
                            <h4><i class="bi bi-bag-check me-2 text-success"></i>Item Pesanan</h4>
                        </div>
                        <div class="checkout-card-body">
                            @foreach ($items as $item)
                                <div class="item-row">
                                    <div class="item-thumb-box">
                                        <img src="{{ asset('images/barang/' . ($item->fotoBarang->first()->nama_file ?? 'default.jpg')) }}" alt="{{ $item->nama_barang }}">
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="fw-bold fs-6 mb-1 text-dark">{{ $item->nama_barang }}</h5>
                                        <p class="text-muted small mb-1">{{ Str::limit($item->deskripsi, 90) }}</p>
                                        <div class="fw-bold text-dark">Rp{{ number_format($item->harga_jual, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- KANAN: Poin & Rincian Pembayaran --}}
                <div class="col-lg-4">
                    {{-- Penukaran Poin --}}
                    <div class="checkout-card">
                        <div class="checkout-card-header">
                            <h5><i class="bi bi-coin me-2 text-warning"></i>Poin Pembeli</h5>
                        </div>
                        <div class="checkout-card-body">
                            <p class="mb-2">Total Poin Anda: <strong id="totalPoin" class="text-success fs-5">{{ $poin }}</strong></p>
                            <label for="poinInput" class="form-label small text-muted">Masukkan Poin yang Ingin Ditukar:</label>
                            <input type="number" class="form-control" id="poinInput" name="poin_tukar" placeholder="Contoh: 100" min="0" max="{{ $poin }}">
                            <div class="form-text small mt-1 text-muted">100 poin = Potongan Rp10.000</div>
                            <div id="poinError" class="text-danger small mt-1" style="visibility: hidden;">
                                Jumlah poin melebihi total poin yang Anda miliki.
                            </div>
                        </div>
                    </div>

                    {{-- Ringkasan Pembayaran --}}
                    <div class="summary-card">
                        <h5 class="fw-bold text-dark mb-3">Ringkasan Pembayaran</h5>
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span id="subtotalDisplay" class="fw-semibold">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                            <input type="hidden" id="subtotalHidden" value="{{ $subtotal }}">
                        </div>
                        <div class="summary-row">
                            <span>Potongan Poin</span>
                            <span class="text-danger fw-semibold" id="potonganPoin">-Rp0</span>
                        </div>
                        <div class="summary-row">
                            <span>Biaya Ongkir</span>
                            <span id="ongkirDisplay" class="fw-semibold">Rp0</span>
                        </div>
                        <div class="summary-total">
                            <span class="summary-total-label">Total Tagihan</span>
                            <span class="summary-total-value" id="totalBayar">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>

                        <form method="POST" action="{{ route('checkout.submit') }}" novalidate>
                            @csrf
                            <input type="hidden" name="total_pembayaran" id="totalPembayaranInput" value="{{ $subtotal }}">
                            <input type="hidden" name="jenis_pengiriman" id="inputJenisPengirimanForm" value="Kurir">
                            <input type="hidden" name="poin_tukar" id="inputPoinTukar" value="0">
                            <input type="hidden" name="id_alamat" id="inputIdAlamat" value="{{ $alamatPertama->id_alamat_pembeli ?? '' }}">
                            <button type="submit" class="btn btn-primary w-100 py-3 mt-4 fs-6">
                                <i class="bi bi-credit-card me-1"></i> Bayar Sekarang
                            </button>
                        </form>
                        <small class="d-block text-center text-muted mt-3">Dengan melanjutkan, Anda menyetujui Syarat & Ketentuan ReUseMart.</small>
                    </div>
                </div>
            </div>
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

    <!-- Modal Ganti Alamat -->
    <div class="modal fade" id="gantiAlamatModal" tabindex="-1" aria-labelledby="gantiAlamatModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="gantiAlamatModalLabel">Pilih Alamat Pengiriman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        @foreach ($alamatList as $alamat)
                            <div class="col-12">
                                <div class="card p-3 border shadow-sm">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <p class="mb-1 fw-bold text-dark">{{ $alamat->jalan }}</p>
                                            <p class="mb-1 text-muted small">
                                                {{ $alamat->kelurahan }}, {{ $alamat->kecamatan }}, {{ $alamat->kota }}, {{ $alamat->provinsi }} {{ $alamat->kode_pos }}
                                            </p>
                                            @if($alamat->detail)
                                                <p class="mb-0 text-muted small"><span class="fw-semibold">Detail:</span> {{ $alamat->detail }}</p>
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-outline-primary btn-sm ms-3"
                                            onclick="gunakanAlamatDariCard(this)"
                                            data-id="{{ $alamat->id_alamat_pembeli }}"
                                            data-jalan="{{ $alamat->jalan }}"
                                            data-kelurahan="{{ $alamat->kelurahan }}"
                                            data-kecamatan="{{ $alamat->kecamatan }}"
                                            data-kota="{{ $alamat->kota }}"
                                            data-provinsi="{{ $alamat->provinsi }}"
                                            data-kodepos="{{ $alamat->kode_pos }}"
                                            data-detail="{{ $alamat->detail }}">
                                            Pilih
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ganti Pengiriman -->
    <div class="modal fade" id="gantiPengirimanModal" tabindex="-1" aria-labelledby="gantiPengirimanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="gantiPengirimanModalLabel">Pilih Metode Pengiriman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        {{-- Opsi 1: Kurir --}}
                        <div class="col-12">
                            <div class="card p-3 border shadow-sm">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="fw-bold mb-1"><i class="bi bi-truck me-1 text-success"></i> Kurir ReUseMart</h6>
                                        <p class="mb-0 small text-muted">Pengiriman khusus wilayah Yogyakarta dan sekitarnya.</p>
                                    </div>
                                    <button type="button" class="btn btn-primary btn-sm" onclick="pilihPengiriman('kurir')">
                                        Pilih
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Opsi 2: Ambil Sendiri --}}
                        <div class="col-12">
                            <div class="card p-3 border shadow-sm">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="fw-bold mb-1"><i class="bi bi-building me-1 text-success"></i> Ambil Sendiri</h6>
                                        <p class="mb-0 small text-muted">Ambil barang langsung di gudang ReUseMart dalam 3 hari.</p>
                                    </div>
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="pilihPengiriman('ambil_sendiri')">
                                        Pilih
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const poinInput = document.getElementById('poinInput');
            const totalPoin = parseInt(document.getElementById('totalPoin').textContent) || 0;
            const subtotal = parseInt(document.getElementById('subtotalHidden').value) || 0;
            const errorEl = document.getElementById('poinError');
            const ongkirDisplay = document.getElementById('ongkirDisplay');

            window.hitungTotal = function () {
                let poin = parseInt(poinInput.value) || 0;

                if (poin > totalPoin) {
                    errorEl.style.visibility = 'visible';
                    return;
                } else {
                    errorEl.style.visibility = 'hidden';
                }

                const potongan = Math.floor(poin / 100) * 10000;
                const jenis = document.querySelector('input[name="jenis_pengiriman"]').value;
                let ongkir = 0;

                if (jenis === 'Kurir') {
                    ongkir = subtotal < 1500000 ? 100000 : 0;
                    ongkirDisplay.textContent = `Rp${ongkir.toLocaleString('id-ID')}`;
                } else {
                    ongkirDisplay.textContent = 'Rp0';
                }

                const total = Math.max(0, subtotal - potongan + ongkir);

                document.getElementById('potonganPoin').textContent = `-Rp${potongan.toLocaleString('id-ID')}`;
                document.getElementById('totalBayar').textContent = `Rp${total.toLocaleString('id-ID')}`;
                document.getElementById('totalPembayaranInput').value = total;
            }

            hitungTotal();

            poinInput.addEventListener('input', function () {
                document.getElementById('inputPoinTukar').value = poinInput.value;
                hitungTotal();
            });
        });

        function gunakanAlamatDariCard(button) {
            const data = button.dataset;

            const html = `
                <p class="mb-1 fw-bold text-dark">${data.jalan}</p>
                <p class="mb-1 text-muted">
                    ${data.kelurahan}, ${data.kecamatan}, ${data.kota}, ${data.provinsi} ${data.kodepos}
                </p>
                ${data.detail ? `<p class="mb-0 text-muted small"><span class="fw-semibold">Detail:</span> ${data.detail}</p>` : ''}
            `;

            document.getElementById('alamatUtama').innerHTML = html;
            document.getElementById('inputIdAlamat').value = data.id;

            const modalEl = document.getElementById('gantiAlamatModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();
        }

        function pilihPengiriman(jenis) {
            const labelText = jenis === 'kurir' ? 'Kurir' : 'Ambil Sendiri';
            document.getElementById('jenisPengirimanTerpilih').innerHTML = `
                <span class="badge bg-light text-dark border p-2 fs-6">
                    <i class="bi bi-check-circle-fill text-success me-1"></i> ${labelText}
                </span>
            `;

            const input = document.getElementById('inputJenisPengiriman');
            const inputForm = document.getElementById('inputJenisPengirimanForm');
            if (input) input.value = labelText;
            if (inputForm) inputForm.value = labelText;

            if (typeof hitungTotal === 'function') {
                hitungTotal();
            }

            const modalEl = document.getElementById('gantiPengirimanModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();
        }
    </script>
</body>
</html>
