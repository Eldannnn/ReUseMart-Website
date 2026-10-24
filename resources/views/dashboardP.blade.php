<!-- ReUseMart - Dashboard Penitip -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penitip - ReUseMart</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/reusemart-theme.css') }}">
    <style>
        .penitip-header {
            background: var(--brand-primary-gradient) !important;
            box-shadow: 0 4px 20px -2px rgba(111, 143, 70, 0.25);
        }
        .stat-card {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 18px 24px;
            transition: var(--transition-smooth);
        }
        .stat-card:hover {
            box-shadow: var(--shadow-card);
            border-color: var(--border-hover);
        }
    </style>
</head>
<body class="bg-light">

<header class="penitip-header py-3 px-4 border-bottom sticky-top">
    <div class="container d-flex align-items-center justify-content-between">
        <div class="logo">
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/logo2.png') }}" alt="Logo" style="height: 48px;">
            </a>
        </div>

        <div>
            <h5 class="mb-0 fw-bold text-white">Dashboard Penitip</h5>
        </div>

        <div class="dropdown text-end">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle gap-2" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="bg-white bg-opacity-25 rounded-circle p-1 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                    <img src="https://img.icons8.com/material/24/ffffff/user.png" alt="Account" width="22" height="22">
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="dropdownUser1">
                <li>
                    <a class="dropdown-item py-2" href="{{ route('penitip.profil') }}">
                        <i class="bi bi-person-circle me-2"></i> Profil Saya
                    </a>
                </li>
                <li><hr class="dropdown-divider my-1"></li>
                <li>
                    <button type="button" class="dropdown-item py-2 text-danger" data-bs-toggle="modal" data-bs-target="#logoutConfirmModal">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </button>
                </li>
            </ul>
        </div>
    </div>
</header>

<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Stat Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="stat-card d-flex align-items-center justify-content-between p-4">
                <div>
                    <span class="text-muted small fw-semibold">Total Barang Dititipkan</span>
                    <h3 class="fw-bold mb-0 text-dark">{{ $totalBarang }}</h3>
                </div>
                <div class="stat-icon-wrapper rounded-circle p-3" style="background: rgba(111,143,70,0.1); color: var(--brand-primary);">
                    <i class="bi bi-box-seam fs-2"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="stat-card d-flex align-items-center justify-content-between p-4">
                <div>
                    <span class="text-muted small fw-semibold">Barang Belum Terjual</span>
                    <h3 class="fw-bold mb-0 text-dark" style="color: var(--brand-primary) !important;">{{ $totalBarangBelumLaku }}</h3>
                </div>
                <div class="stat-icon-wrapper rounded-circle p-3" style="background: rgba(234,179,8,0.1); color: #ca8a04;">
                    <i class="bi bi-hourglass-split fs-2"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Table Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 border-bottom d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h5 class="fw-bold mb-0" style="color: var(--brand-primary-dark);">Daftar Barang Titipan Anda</h5>
                <small class="text-muted">Pantau status, masa titip, dan sisa waktu barang secara transparan</small>
            </div>
            <form action="{{ route('penitip.barang.index') }}" method="GET" class="d-flex gap-2" novalidate>
                <input type="text" name="q" class="form-control form-control-sm" placeholder="Cari nama barang..." value="{{ request('q') }}" style="width: 220px;">
                <button class="btn btn-primary btn-sm px-3" type="submit">Cari</button>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">No</th>
                        <th style="width: 90px;">Foto</th>
                        <th>Nama Barang</th>
                        <th>Status</th>
                        <th>Tgl Masuk</th>
                        <th>Tgl Keluar</th>
                        <th>Sisa Waktu</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barangs as $index => $barang)
                        <tr>
                            <td class="text-center text-muted small">{{ $barangs->firstItem() + $index }}</td>
                            <td>
                                <img src="{{ asset('images/barang/' . ($barang->fotoBarang->first()->nama_file ?? 'default.jpg')) }}" 
                                     alt="Foto" 
                                     class="rounded border" 
                                     style="width: 70px; height: 70px; object-fit: cover; cursor:pointer" 
                                     data-bs-toggle="modal" 
                                     data-bs-target="#modalDeskripsi{{ $barang->id_barang }}">
                            </td>
                            <td>
                                <strong class="text-dark">{{ $barang->nama_barang }}</strong>
                                <div class="small text-muted">Rp{{ number_format($barang->harga_jual, 0, ',', '.') }}</div>
                            </td>
                            <td>
                                @php
                                    $status = strtolower($barang->status_barang);
                                @endphp
                                <span class="badge-status
                                    {{ $status === 'tersedia' ? 'badge-tersedia' : '' }}
                                    {{ $status === 'terjual' ? 'badge-terjual' : '' }}
                                    {{ $status === 'didonasikan' ? 'badge-didonasikan' : '' }}
                                    {{ $status === 'barang untuk donasi' ? 'badge-didonasikan' : '' }}
                                    {{ in_array($status, ['diambil kembali', 'pengambilan diproses']) ? 'badge-terjual' : '' }}">
                                    {{ $barang->status_barang }}
                                </span>
                            </td>
                            <td class="small">{{ \Carbon\Carbon::parse($barang->tanggal_masuk)->locale('id')->isoFormat('D MMM YYYY') }}</td>
                            <td class="small">
                            {{ $barang->tanggal_keluar 
                                ? \Carbon\Carbon::parse($barang->tanggal_keluar)->locale('id')->isoFormat('D MMM YYYY') 
                                : '-' 
                            }}
                            </td>
                            <td>
                                @if($barang->status_barang === 'Tersedia')
                                    @php
                                        $tanggalAkhir = \Carbon\Carbon::parse($barang->tanggal_akhir);
                                        $hariSekarang = now();

                                        $sisaHari = round($hariSekarang->diffInDays($tanggalAkhir, false));
                                        $hariLewat = round($hariSekarang->diffInDays($tanggalAkhir, false) * -1);
                                        $batasAmbil = 7; 
                                    @endphp

                                    @if($sisaHari > 0)
                                        <span class="badge bg-success-subtle text-success-emphasis border">{{ $sisaHari }} hari tersisa</span>
                                    @elseif($sisaHari === 0)
                                        <span class="badge bg-warning-subtle text-warning-emphasis border">Hari terakhir!</span>
                                    @elseif($hariLewat <= $batasAmbil)
                                        <span class="badge bg-danger-subtle text-danger-emphasis border">Sisa {{ $batasAmbil - $hariLewat }} hari ambil</span>
                                    @else
                                        <span class="badge bg-danger text-white">Terlambat {{ $hariLewat }} hari</span>
                                    @endif
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td class="text-center">
                                @if($barang->status_barang === 'Tersedia')
                                    @if(!$barang->status_perpanjangan && $hariSekarang->isAfter($tanggalAkhir) || ($batasAmbil - $hariLewat == 7))
                                        <form action="{{ route('penitip.perpanjang', $barang->id_barang) }}" method="POST" class="d-inline-block" novalidate>
                                            @csrf
                                            <button class="btn btn-sm btn-outline-primary">Perpanjang</button>
                                        </form>
                                    @endif

                                    @if($hariLewat >= 0 && $hariLewat <= $batasAmbil)
                                        <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalAmbil{{ $barang->id_barang }}">
                                            Ambil Barang
                                        </button>

                                        <!-- Modal Konfirmasi Ambil Barang -->
                                        <div class="modal fade" id="modalAmbil{{ $barang->id_barang }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-success text-white">
                                                        <h5 class="modal-title text-white">Konfirmasi Pengambilan Barang</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                    </div>
                                                    <div class="modal-body p-4 text-center">
                                                        <p class="mb-0">Apakah Anda yakin ingin mengambil barang <strong>{{ $barang->nama_barang }}</strong>?</p>
                                                    </div>
                                                    <div class="modal-footer border-top-0 pt-0 justify-content-center">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                        <form action="{{ route('penitip.ambil', $barang->id_barang) }}" method="POST" class="d-inline" novalidate>
                                                            @csrf
                                                            <button type="submit" class="btn btn-success px-4">Ya, Ambil</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @elseif($barang->status_barang === 'Terjual')
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $barang->id_barang }}">Detail</button>
                                @endif
                            </td>                               
                        </tr>

                        <!-- Modal Deskripsi -->
                        <div class="modal fade" id="modalDeskripsi{{ $barang->id_barang }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Deskripsi Barang</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <h5 class="fw-bold mb-2">{{ $barang->nama_barang }}</h5>
                                        <div class="fs-6 fw-bold mb-3" style="color: var(--brand-primary);">
                                            Harga Jual: Rp{{ number_format($barang->harga_jual, 0, ',', '.') }}
                                        </div>
                                        <p class="text-muted small mb-0">{{ $barang->deskripsi }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Detail Penjualan -->
                        <div class="modal fade" id="modalDetail{{ $barang->id_barang }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Detail Penjualan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <p><strong>Nama:</strong> {{ $barang->nama_barang }}</p>
                                        <p class="mb-0"><strong>Harga Jual:</strong> Rp{{ number_format($barang->harga_jual, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="8" class="text-center p-5 text-muted">Tidak ada barang titipan ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer bg-white border-top-0 py-3 d-flex justify-content-center">
            {!! $barangs->withQueryString()->links('pagination::bootstrap-5') !!}
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Logout -->
<div class="modal fade" id="logoutConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title text-white">Konfirmasi Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <p class="mb-0">Apakah Anda yakin ingin keluar dari sesi akun ReUseMart?</p>
            </div>
            <div class="modal-footer border-top-0 pt-0 justify-content-center">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('logout') }}" method="POST" class="d-inline" novalidate>
                    @csrf
                    <button type="submit" class="btn btn-danger px-4">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Unified Footer -->
<footer>
    <div class="footer-container">
        <div class="footer-left">
            <p>© 2025 ReUseMart. All rights reserved.</p>
        </div>
        <div class="footer-middle">
            <div class="social-icons">
                <a href="#" class="social-icon"><img src="https://img.icons8.com/material/24/000000/facebook.png" alt="Facebook"></a>
                <a href="#" class="social-icon"><img src="https://img.icons8.com/material/24/000000/twitter.png" alt="Twitter"></a>
                <a href="#" class="social-icon"><img src="https://img.icons8.com/material/24/000000/instagram.png" alt="Instagram"></a>
                <a href="#" class="social-icon"><img src="https://img.icons8.com/material/24/000000/pinterest.png" alt="Pinterest"></a>
                <a href="#" class="social-icon"><img src="https://img.icons8.com/material/24/000000/youtube.png" alt="YouTube"></a>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
