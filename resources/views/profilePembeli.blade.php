<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pembeli - ReUseMart</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/reusemart-theme.css') }}">
    <style>
        .profile-card {
            background-color: #fff;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
            overflow: hidden;
            border: 1px solid var(--border-color);
        }

        .profile-header {
            background: var(--brand-primary-gradient);
            color: white;
            padding: 2.2rem;
        }

        .profile-avatar-wrapper {
            width: 78px;
            height: 78px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-avatar-wrapper img {
            width: 44px;
            height: 44px;
            filter: brightness(0) invert(1);
        }

        .form-control[disabled] {
            background-color: var(--bg-muted);
            color: var(--text-heading);
            font-weight: 500;
            border-color: var(--border-color);
        }
    </style>
</head>
<body class="bg-light">

<div class="container my-5" style="max-width: 960px;">
    <div class="profile-card">
        <div class="profile-header d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="profile-avatar-wrapper">
                    <img src="https://img.icons8.com/ios-glyphs/90/ffffff/user--v1.png" alt="User Avatar">
                </div>
                <div>
                    <span class="badge bg-white text-dark px-2 py-1 rounded-pill small fw-semibold mb-1" style="color: var(--brand-primary) !important;">Akun Pembeli</span>
                    <h4 class="mb-0 fw-bold text-white">{{ $pembeli->nama_pembeli }}</h4>
                    <small class="text-white-50">{{ $pembeli->email }}</small>
                </div>
            </div>
            <a href="{{ route('home') }}" class="btn btn-sm btn-outline-light rounded-pill px-3">
                ← Kembali ke Beranda
            </a>
        </div>

        <div class="p-4 p-md-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0" style="color: var(--brand-primary-dark);">Informasi Akun</h5>
                <span class="badge {{ $pembeli->status_aktif ? 'badge-tersedia' : 'badge-terjual' }}">
                    {{ $pembeli->status_aktif ? '● Akun Aktif' : '● Tidak Aktif' }}
                </span>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger py-2 px-3 small rounded-3 mb-4">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-semibold text-muted">Nama Lengkap</label>
                    <input type="text" class="form-control" value="{{ $pembeli->nama_pembeli }}" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold text-muted">Username</label>
                    <input type="text" class="form-control" value="{{ $pembeli->username }}" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold text-muted">Nomor Telepon</label>
                    <input type="text" class="form-control" value="{{ $pembeli->notelp }}" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold text-muted">Total Poin ReUseMart</label>
                    <input type="text" class="form-control" value="{{ number_format($pembeli->poin, 0, ',', '.') }} Poin" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold text-muted">Status Akun</label>
                    <input type="text" class="form-control" value="{{ $pembeli->status_aktif ? 'Aktif' : 'Tidak Aktif' }}" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold text-muted">Alamat Email Terdaftar</label>
                    <input type="text" class="form-control" value="{{ $pembeli->email }}" disabled>
                </div>
            </div>

            <hr class="my-4 text-muted">

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('pembeli.riwayatTransaksi') }}" class="btn btn-outline-primary">
                        <i class="bi bi-bag-check me-1"></i> Riwayat Pembelian
                    </a>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        <i class="bi bi-pencil-square me-1"></i> Edit Profil
                    </button>
                    <a href="{{ route('alamatPembeli.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-geo-alt me-1"></i> Daftar Alamat
                    </a>
                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#toggleStatusModal">
                        {{ $pembeli->status_aktif ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}
                    </button>
                </div>
                <button type="button" class="btn btn-danger px-4" data-bs-toggle="modal" data-bs-target="#logoutConfirmModal">
                    Logout
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Profil -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form action="{{ route('pembeli.update', $pembeli->id_pembeli) }}" method="POST" class="modal-content" novalidate id="formEditProfile">
        @csrf
        @method('PUT')
        <div class="modal-header">
            <h5 class="modal-title" id="editProfileModalLabel">Perbarui Profil Pembeli</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Nama Lengkap</label>
                    <input type="text" name="nama_pembeli" class="form-control" value="{{ $pembeli->nama_pembeli }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Username</label>
                    <input type="text" name="username" class="form-control" value="{{ $pembeli->username }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Nomor Telepon</label>
                    <input type="text" name="notelp" class="form-control" value="{{ $pembeli->notelp }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Alamat Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $pembeli->email }}">
                </div>
            </div>
        </div>
        <div class="modal-footer border-top-0 pt-0">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
        </div>
        </form>
    </div>
</div>

<!-- Modal Konfirmasi Nonaktif / Aktif Status -->
<div class="modal fade" id="toggleStatusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title text-dark">Konfirmasi Perubahan Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <p class="mb-0">
                    Apakah Anda yakin ingin <strong>{{ $pembeli->status_aktif ? 'menonaktifkan' : 'mengaktifkan' }}</strong> akun ini?
                </p>
            </div>
            <div class="modal-footer border-top-0 pt-0 justify-content-center">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('pembeli.toggleStatus', $pembeli->id_pembeli) }}" method="POST" class="d-inline" novalidate>
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-warning px-4">Ya, Lanjutkan</button>
                </form>
            </div>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>