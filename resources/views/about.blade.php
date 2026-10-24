<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReUseMart - About Us</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">


    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- ReUseMart Unified Design System -->
    <link rel="stylesheet" href="{{ asset('css/reusemart-theme.css') }}">

    <style>
        .about-container {
            max-width: 1100px;
            margin: 36px auto 60px auto;
            padding: 0 24px;
        }

        .header-image {
            display: flex;
            justify-content: center;
            margin-bottom: 36px;
        }

        .header-image img {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-card);
        }

        .about-card {
            background-color: var(--bg-card);
            padding: 32px;
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-card);
            border: 1px solid var(--border-color);
            margin-bottom: 24px;
        }

        .about-card h2 {
            font-size: 24px;
            color: var(--text-heading);
            margin-bottom: 14px;
            position: relative;
            display: inline-block;
        }

        .about-card h2::after {
            content: '';
            display: block;
            width: 36px;
            height: 3px;
            background-color: var(--brand-primary);
            border-radius: 9999px;
            margin-top: 6px;
        }

        .about-card p {
            font-size: 15px;
            color: var(--text-body);
            line-height: 1.7;
        }

        .mission-list {
            padding-left: 20px;
            margin-top: 16px;
        }

        .mission-list li {
            font-size: 14.5px;
            color: var(--text-heading);
            margin-bottom: 14px;
            line-height: 1.6;
        }

        .mission-list li p {
            font-size: 14px;
            color: var(--text-muted);
            margin-top: 4px;
            margin-bottom: 0;
        }

        .values-section-title {
            text-align: center;
            font-size: 26px;
            margin-bottom: 24px;
        }

        .values-section-title::after {
            margin: 6px auto 0 auto !important;
        }

        .values-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 20px;
        }

        .value-box {
            background-color: var(--bg-page);
            padding: 24px 20px;
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-color);
            text-align: center;
            transition: var(--transition-smooth);
            display: flex;
            flex-direction: column;
        }

        .value-box:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-card-hover);
            border-color: var(--border-hover);
            background-color: #ffffff;
        }

        .value-box h3 {
            font-size: 17px;
            font-weight: 700;
            color: var(--text-heading);
            margin-bottom: 10px;
        }

        .value-box hr {
            width: 40px;
            margin: 0 auto 14px auto;
            border: none;
            height: 2px;
            background-color: var(--brand-primary);
            opacity: 1;
        }

        .value-box p {
            font-size: 13.5px;
            color: var(--text-muted);
            line-height: 1.6;
            text-align: center;
            margin: 0;
        }

        /* Contact Banner */
        .contact-banner {
            background: var(--brand-primary-gradient);
            color: #ffffff;
            padding: 48px 24px;
            border-radius: 0;
            box-shadow: 0 4px 20px rgba(111, 143, 70, 0.25);
            text-align: center;
        }

        .contact-inner {
            max-width: 800px;
            margin: 0 auto;
        }

        .contact-banner h2 {
            color: #ffffff !important;
            font-size: 26px;
            margin-bottom: 12px;
        }

        .contact-banner p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 15px;
            margin-bottom: 8px;
        }

        .contact-info-pills {
            display: flex;
            justify-content: center;
            gap: 16px;
            flex-wrap: wrap;
            margin-top: 16px;
        }

        .contact-pill {
            background-color: rgba(255, 255, 255, 0.16);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            padding: 8px 18px;
            border-radius: 9999px;
            font-size: 14px;
            font-weight: 600;
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        @media (max-width: 992px) {
            .values-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .values-grid {
                grid-template-columns: 1fr;
            }
            .header-image img {
                height: 250px;
            }
            .about-card {
                padding: 20px;
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
        <div class="about-container">
            <!-- Gambar Header Banner -->
            <div class="header-image">
                <img src="{{ asset('images/barang/reusemart.jpg') }}" alt="ReUseMart Banner">
            </div>

            <!-- Visi Card -->
            <div class="about-card">
                <h2>Visi</h2>
                <p><strong>ReUseMart</strong> menjadi platform e-commerce terkemuka yang mendorong keberlanjutan dan pengurangan sampah dengan menyediakan tempat untuk membeli dan menjual barang bekas berkualitas tinggi.</p>
            </div>

            <!-- Misi Card -->
            <div class="about-card">
                <h2>Misi</h2>
                <p><strong>ReUseMart</strong> hadir dengan tujuan menciptakan pasar berkelanjutan yang memudahkan orang untuk membeli dan menjual barang bekas. Kami ingin mengurangi limbah dan mendorong gaya hidup ramah lingkungan.</p>
                <ol class="mission-list">
                    <li>
                        <strong>Meningkatkan Aksesibilitas untuk Barang Bekas Berkualitas:</strong>
                        <p>Memberikan pengalaman berbelanja yang mudah, nyaman, dan terpercaya bagi konsumen yang mencari barang bekas berkualitas.</p>
                    </li>
                    <li>
                        <strong>Mendorong Keberlanjutan:</strong>
                        <p>Mengurangi limbah dengan memberikan barang bekas kesempatan kedua untuk dipakai oleh orang lain, sehingga mendukung prinsip ekonomi sirkular dan keberlanjutan.</p>
                    </li>
                    <li>
                        <strong>Menyediakan Pilihan yang Beragam:</strong>
                        <p>Menawarkan berbagai kategori produk bekas yang terjamin kualitasnya, mulai dari elektronik, pakaian, perabotan rumah tangga, hingga barang koleksi.</p>
                    </li>
                    <li>
                        <strong>Memberdayakan Komunitas:</strong>
                        <p>Membantu individu dan komunitas untuk mendapatkan akses ke barang bekas dengan harga terjangkau serta memberikan mereka kesempatan untuk menjual barang yang tidak lagi mereka butuhkan.</p>
                    </li>
                    <li>
                        <strong>Edukasi dan Kesadaran Konsumen:</strong>
                        <p>Meningkatkan kesadaran masyarakat mengenai pentingnya membeli barang bekas untuk mendukung keberlanjutan dan pengurangan limbah.</p>
                    </li>
                </ol>
            </div>

            <!-- Values Card -->
            <div class="about-card">
                <div class="text-center">
                    <h2 class="values-section-title">Our Values</h2>
                </div>

                <div class="values-grid">
                    <div class="value-box">
                        <h3>Keberlanjutan</h3>
                        <hr>
                        <p>ReUseMart berkomitmen untuk mengurangi dampak lingkungan melalui perdagangan barang bekas yang masih berkualitas, mendukung pengurangan sampah dan penggunaan ulang sumber daya.</p>
                    </div>

                    <div class="value-box">
                        <h3>Kualitas</h3>
                        <hr>
                        <p>Meskipun barang yang dijual adalah barang bekas, kami memastikan bahwa setiap produk yang tersedia di platform kami telah melalui pemeriksaan kualitas yang ketat agar hanya barang berkualitas tinggi yang bisa ditemukan oleh pembeli.</p>
                    </div>

                    <div class="value-box">
                        <h3>Transparansi</h3>
                        <hr>
                        <p>Kami percaya bahwa kepercayaan adalah dasar dari hubungan jangka panjang dengan pelanggan dan penjual. Oleh karena itu, kami selalu memastikan bahwa deskripsi barang dan proses transaksi dilakukan secara terbuka dan jelas.</p>
                    </div>

                    <div class="value-box">
                        <h3>Inovasi</h3>
                        <hr>
                        <p>Kami terus berinovasi untuk menciptakan platform yang lebih baik, mempermudah proses transaksi, serta meningkatkan pengalaman pelanggan dan penjual di ReUseMart.</p>
                    </div>

                    <div class="value-box">
                        <h3>Kehidupan yang Lebih Baik</h3>
                        <hr>
                        <p>Dengan menawarkan akses kepada barang-barang bekas berkualitas, kami membantu masyarakat mendapatkan barang yang mereka butuhkan dengan harga terjangkau sambil mendukung keberlanjutan dan kehidupan yang lebih baik.</p>
                    </div>

                    <div class="value-box">
                        <h3>Komunitas</h3>
                        <hr>
                        <p>Kami mengutamakan pemberdayaan komunitas untuk menciptakan ekosistem yang inklusif, yang dapat menghubungkan pembeli dan penjual untuk berbagi barang yang masih berguna dan mengurangi pemborosan.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Banner -->
        <section class="contact-banner">
            <div class="contact-inner">
                <h2>Our Contact</h2>
                <p>Jika Anda memiliki pertanyaan atau ingin tahu lebih banyak tentang ReUseMart, silakan hubungi kami:</p>
                <div class="contact-info-pills">
                    <span class="contact-pill"><i class="bi bi-envelope"></i> support@reusemart.com</span>
                    <span class="contact-pill"><i class="bi bi-telephone"></i> +1 (123) 456-7890</span>
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
</body>
</html>
