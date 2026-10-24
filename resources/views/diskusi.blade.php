<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruang Diskusi Produk - ReUseMart</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/reusemart-theme.css') }}">
    <style>
        .discussion-card {
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            background: #ffffff;
            transition: var(--transition-smooth);
        }
        .discussion-card:hover {
            box-shadow: var(--shadow-card-hover);
            border-color: var(--border-hover);
        }
        .reply-box {
            background-color: var(--brand-primary-subtle);
            border-left: 3px solid var(--brand-primary);
            border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
        }
    </style>
</head>
<body class="bg-light">

    <!-- ReUseMart Unified Header -->
    <header class="reusemart-header">
        <div class="header-container container">
            <div class="header-left">
                <div class="logo">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('images/logo2.png') }}" alt="ReUseMart Brand Logo">
                    </a>
                </div>
                <nav>
                    <ul>
                        <li><a href="{{ url('/kategori') }}">Collection</a></li>
                        <li><a href="{{ url('/about') }}">About Us</a></li>
                    </ul>
                </nav>
            </div>
            
            <div class="cart-search">
                <div class="icons">
                    <a href="{{ route('keranjang') }}" title="Keranjang Belanja">
                        <img src="https://img.icons8.com/material/24/ffffff/shopping-cart.png" alt="Cart">
                    </a>
                    <a href="{{ route('diskusi.index') }}" title="Ruang Diskusi" class="active">
                        <img src="https://img.icons8.com/?size=100&id=123773&format=png&color=ffffff" alt="Diskusi">
                    </a>
                    <a href="{{ route(Auth::guard('penitip')->check() ? 'penitip.profil' : 'pembeli.profil') }}" title="Profil Pengguna">
                        <img src="https://img.icons8.com/material/24/ffffff/user.png" alt="Account">
                    </a>
                </div>
            </div>
        </div>
    </header>

<div class="container py-5" style="max-width: 1000px;">
    <!-- Page Header Title -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <span class="badge bg-white text-muted border px-3 py-1 rounded-pill small mb-2">Tanya & Jawab</span>
            <h2 class="fw-bold mb-1">Diskusi Produk</h2>
            <p class="text-muted small mb-0">Ajukan pertanyaan seputar produk titipan kepada pengelola ReUseMart</p>
        </div>
    </div>

    <!-- Formulir Pertanyaan Baru -->
    <div class="card mb-5 border-0 shadow-sm">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="card-title fw-bold mb-0" style="color: var(--brand-primary-dark);">
                <i class="bi bi-chat-left-text me-2"></i> Ajukan Pertanyaan Baru
            </h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('diskusi.tanya') }}" method="POST" novalidate id="formDiskusi">
                @csrf
                <div class="mb-3">
                    <label for="barang_id" class="form-label small fw-semibold">Pilih Produk Yang Ingin Ditanyakan</label>
                    <select id="barang_id" name="barang_id" class="form-select">
                        <option value="" selected disabled>— Pilih Produk Tersedia —</option>
                        @foreach ($barangAvailable as $barang)
                            <option value="{{ $barang->id_barang }}">
                                {{ $barang->nama_barang }} (Rp {{ number_format($barang->harga_jual, 0, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="pertanyaan" class="form-label small fw-semibold">Detail Pertanyaan</label>
                    <textarea id="pertanyaan" name="pertanyaan" class="form-control" rows="3" placeholder="Tuliskan pertanyaan Anda mengenai kondisi barang, kelengkapan, dll..."></textarea>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-4 py-2">
                        Kirim Pertanyaan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Daftar Diskusi -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h5 class="fw-bold mb-0">Daftar Tanya Jawab</h5>
        <span class="text-muted small">Total: {{ $diskusi->total() }} diskusi</span>
    </div>

    <div class="discussion-list">
        @forelse ($diskusi as $d)
            <div class="card discussion-card mb-3 p-4">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <span class="badge bg-light text-dark border px-2 py-1 rounded small fw-semibold">
                            <i class="bi bi-box me-1"></i> {{ $d->barang_titipan ? $d->barang_titipan->nama_barang : 'Produk tidak ditemukan' }}
                        </span>
                        <div class="mt-2 text-muted small">
                            Ditanyakan oleh <strong class="text-dark">{{ $d->pembeli->nama_pembeli ?? 'Pembeli' }}</strong>
                            • {{ $d->tanggal_tanya ? $d->tanggal_tanya->format('d M Y, H:i') : '' }}
                        </div>
                    </div>
                    @if ($d->jawaban)
                        <span class="badge-status badge-tersedia">
                            <i class="bi bi-check-circle me-1"></i> Sudah Dijawab
                        </span>
                    @else
                        <span class="badge-status badge-didonasikan">
                            <i class="bi bi-clock-history me-1"></i> Menunggu Jawaban
                        </span>
                    @endif
                </div>

                <div class="my-2">
                    <p class="mb-0 text-dark fw-medium">{{ $d->pertanyaan }}</p>
                </div>

                @if ($d->jawaban)
                    <div class="reply-box p-3 mt-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="small fw-bold" style="color: var(--brand-primary-dark);">
                                <i class="bi bi-shield-check me-1"></i> Pengelola ({{ $d->pegawai->nama_pegawai ?? 'Customer Service' }})
                            </span>
                            @if ($d->tanggal_jawab)
                                <span class="text-muted small">
                                    {{ $d->tanggal_jawab->format('d M Y, H:i') }}
                                </span>
                            @endif
                        </div>
                        <p class="mb-0 small text-dark">{{ $d->jawaban }}</p>
                    </div>
                @else
                    <div class="text-muted small fst-italic mt-2">
                        Belum ada jawaban dari pihak pengelola. Tim kami akan segera menanggapi.
                    </div>
                @endif
            </div>
        @empty
          <div class="card p-5 text-center text-muted border-0 shadow-sm">
            <div class="fs-1 mb-2 text-muted"><i class="bi bi-chat-square-dots"></i></div>
                <h6 class="fw-bold text-dark">Belum Ada Diskusi</h6>
                <p class="small mb-0">Jadilah yang pertama mengajukan pertanyaan tentang produk di ReUseMart.</p>
            </div>
        @endforelse

        <div class="d-flex justify-content-center mt-4">
            {!! $diskusi->withQueryString()->links('pagination::bootstrap-5') !!}
        </div>
    </div>
</div>

<!-- ReUseMart Unified Footer -->
<footer>
    <div class="footer-container">
        <div class="footer-left">
            <p>© 2025 ReUseMart. Solusi Belanja & Titip Jual Berkelanjutan.</p>
        </div>
        <div class="footer-middle">
            <div class="social-icons">
                <a href="#" class="social-icon" title="Facebook"><img src="https://img.icons8.com/material/24/000000/facebook.png" alt="Facebook"></a>
                <a href="#" class="social-icon" title="Twitter"><img src="https://img.icons8.com/material/24/000000/twitter.png" alt="Twitter"></a>
                <a href="#" class="social-icon" title="Instagram"><img src="https://img.icons8.com/material/24/000000/instagram.png" alt="Instagram"></a>
                <a href="#" class="social-icon" title="Pinterest"><img src="https://img.icons8.com/material/24/000000/pinterest.png" alt="Pinterest"></a>
                <a href="#" class="social-icon" title="YouTube"><img src="https://img.icons8.com/material/24/000000/youtube.png" alt="YouTube"></a>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
