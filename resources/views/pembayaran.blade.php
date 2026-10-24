<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Pesanan - ReUseMart</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">


    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- ReUseMart Unified Design System -->
    <link rel="stylesheet" href="{{ asset('css/reusemart-theme.css') }}">

    <style>
        .payment-page-section {
            max-width: 760px;
            margin: 40px auto 60px auto;
            padding: 0 24px;
        }

        .payment-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-card);
            padding: 32px;
        }

        .timer-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: var(--bg-page);
            padding: 16px 20px;
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-color);
            margin-bottom: 24px;
        }

        .countdown-badge {
            background-color: var(--accent-danger);
            color: #ffffff;
            font-size: 16px;
            font-weight: 800;
            padding: 6px 14px;
            border-radius: var(--radius-sm);
            min-width: 55px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(220, 38, 38, 0.25);
        }

        .payment-info-box {
            background-color: var(--brand-primary-subtle);
            border: 1px solid rgba(111, 143, 70, 0.25);
            border-radius: var(--radius-lg);
            padding: 20px;
            margin-bottom: 24px;
        }

        .va-number {
            font-size: 24px;
            font-weight: 800;
            color: var(--text-heading);
            letter-spacing: 2px;
        }

        .upload-dropzone {
            border: 2px dashed var(--border-color);
            border-radius: var(--radius-lg);
            padding: 24px;
            text-align: center;
            background-color: var(--bg-page);
            transition: var(--transition-smooth);
        }

        .upload-dropzone:hover {
            border-color: var(--brand-primary);
            background-color: #ffffff;
        }
    </style>
</head>
<body>
    {{-- Toast Notifikasi --}}
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

        @if (session('error'))
            <div id="liveToast" class="toast fade shadow-lg border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-danger text-white">
                    <strong class="me-auto">Peringatan</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body bg-white text-dark">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <div id="dynamicToast" class="toast fade shadow-lg border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header text-white" id="dynamicToastHeader" style="background-color: var(--brand-primary);">
                <strong class="me-auto" id="dynamicToastTitle">Info</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body bg-white text-dark" id="dynamicToastBody">
            </div>
        </div>
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
        <div class="payment-page-section">
            <div class="payment-card">
                <!-- Header Countdown Timer -->
                <div class="timer-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="text-warning fs-3">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-dark">Batas Waktu Pembayaran</h5>
                            <small class="text-muted">{{ $tanggalTransaksiPlus1Menit->format('d M Y, H:i') }}</small>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <div id="countdown-minutes" class="countdown-badge">1m</div>
                        <div id="countdown-seconds" class="countdown-badge">00s</div>
                    </div>
                </div>

                <!-- Info Alert -->
                <div class="alert alert-warning py-3 mb-4 border-0 shadow-sm" role="alert">
                    <div class="d-flex gap-2">
                        <i class="bi bi-info-circle-fill fs-5 text-warning flex-shrink-0"></i>
                        <div>
                            <strong>Tinggal selangkah lagi untuk menyelesaikan pesanan Anda!</strong><br />
                            Segera lakukan transfer dan unggah bukti pembayaran agar pesanan segera diproses.
                        </div>
                    </div>
                </div>

                <!-- Detail Pembayaran & Virtual Account -->
                <div class="payment-info-box">
                    <div class="row g-3">
                        <div class="col-md-7">
                            <div class="text-muted small mb-1 fw-semibold">Nomor Virtual Account (BCA / Mandiri)</div>
                            <div class="va-number">075048615248</div>
                        </div>
                        <div class="col-md-5 text-md-end">
                            <div class="text-muted small mb-1 fw-semibold">Total Tagihan</div>
                            <h3 class="fw-bold mb-0" style="color: var(--brand-primary);">Rp{{ number_format($totalHarga, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Form Upload Bukti Pembayaran -->
                <form action="{{ route('upload.bukti') }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    <input type="hidden" name="id_transaksi" value="{{ request('id_transaksi') }}">
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Unggah Bukti Pembayaran</label>
                        <div class="upload-dropzone mb-3">
                            <i class="bi bi-cloud-arrow-up fs-1 text-muted d-block mb-2"></i>
                            <input type="file" id="buktiPembayaran" name="bukti_pembayaran" accept="image/png, image/jpeg, image/jpg" class="form-control" />
                            <small class="text-muted d-block mt-2">Format yang didukung: JPG, JPEG, PNG (Maks 2MB)</small>
                            <div id="fileError" class="text-danger mt-2 small" style="display:none;">
                                <i class="bi bi-exclamation-circle me-1"></i>Format file tidak valid! Harap pilih file gambar (JPG, JPEG, PNG).
                            </div>
                        </div>

                        <div class="text-center">
                            <img id="previewImage" src="" alt="Preview Bukti Pembayaran" style="max-width: 80%; max-height: 260px; display: none; border-radius: 12px; border: 1px solid var(--border-color); margin: 0 auto;" />
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3 fs-6">
                        <i class="bi bi-check2-circle me-1"></i> Kirim Bukti Pembayaran
                    </button>
                </form>
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

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

    <script>
        let countDownDate = new Date().getTime() + 60 * 1000;
        const idTransaksi = "{{ request('id_transaksi') }}";

        function showCustomToast(title, message, isError = false) {
            const toastEl = document.getElementById('dynamicToast');
            const titleEl = document.getElementById('dynamicToastTitle');
            const bodyEl = document.getElementById('dynamicToastBody');
            const headerEl = document.getElementById('dynamicToastHeader');

            titleEl.textContent = title;
            bodyEl.textContent = message;
            headerEl.style.backgroundColor = isError ? 'var(--accent-danger)' : 'var(--brand-primary)';

            const toast = new bootstrap.Toast(toastEl);
            toast.show();
        }

        function updateCountdown() {
            let now = new Date().getTime();
            let distance = countDownDate - now;

            if (distance < 0) {
                document.getElementById("countdown-minutes").textContent = "0m";
                document.getElementById("countdown-seconds").textContent = "00s";
                clearInterval(interval);

                fetch("{{ route('batal.transaksi') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        id_transaksi: idTransaksi
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showCustomToast("Waktu Habis", data.message, true);
                        setTimeout(() => {
                            window.location.href = "{{ route('home') }}";
                        }, 2000);
                    } else {
                        console.log(data.message);
                    }
                })
                .catch(error => {
                    console.error("Terjadi kesalahan:", error);
                });

                return;
            }

            let minutes = Math.floor(distance / (1000 * 60));
            let seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("countdown-minutes").textContent = minutes + "m";
            document.getElementById("countdown-seconds").textContent = (seconds < 10 ? "0" : "") + seconds + "s";
        }

        let interval = setInterval(updateCountdown, 1000);
        updateCountdown();

        const inputFile = document.getElementById('buktiPembayaran');
        const fileError = document.getElementById('fileError');
        const previewImage = document.getElementById('previewImage');

        inputFile.addEventListener('change', () => {
            const file = inputFile.files[0];
            if (!file) {
                fileError.style.display = 'none';
                previewImage.style.display = 'none';
                previewImage.src = '';
                return;
            }

            const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            if (!validTypes.includes(file.type)) {
                fileError.style.display = 'block';
                previewImage.style.display = 'none';
                previewImage.src = '';
                inputFile.value = '';
            } else {
                fileError.style.display = 'none';
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });

        const toastLive = document.getElementById('liveToast');
        if (toastLive) {
            const toast = new bootstrap.Toast(toastLive);
            toast.show();
        }
    </script>
</body>
</html>
