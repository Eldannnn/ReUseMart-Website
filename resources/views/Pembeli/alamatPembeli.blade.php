<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Alamat Pembeli - ReUseMart</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    
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

        .address-box {
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            transition: var(--transition-smooth);
        }

        .address-box:hover {
            box-shadow: var(--shadow-card);
            border-color: var(--border-hover);
        }
    </style>
</head>
<body class="bg-light">

<div class="container my-5" style="max-width: 960px;">
    <div class="profile-card">
        <div class="profile-header d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="profile-avatar-wrapper">
                    <img src="https://img.icons8.com/ios-glyphs/90/ffffff/user--v1.png" alt="User">
                </div>
                <div>
                    <span class="badge bg-white text-dark px-2 py-1 rounded-pill small fw-semibold mb-1" style="color: var(--brand-primary) !important;">Daftar Alamat</span>
                    <h4 class="mb-0 fw-bold text-white">{{ $pembeli->nama_pembeli }}</h4>
                    <small class="text-white-50">{{ $pembeli->email }}</small>
                </div>
            </div>
            <a href="{{ route('pembeli.profil') }}" class="btn btn-sm btn-outline-light rounded-pill px-3">
                ← Kembali ke Profil
            </a>
        </div>

        <div class="p-4 p-md-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0" style="color: var(--brand-primary-dark);">Alamat Pengiriman</h5>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahAlamatModal">
                    + Tambah Alamat Baru
                </button>
            </div>

            @foreach ($alamat as $almt)
            <div class="address-box p-4 mb-4 bg-white">
                <div class="row g-4">
                    <!-- Left: Data Alamat -->
                    <div class="col-lg-6">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="badge bg-light text-dark border px-2 py-1 rounded"><i class="bi bi-geo-alt me-1 text-muted"></i> Alamat #{{ $loop->iteration }}</span>
                        </div>
                        <p class="mb-1 text-dark fw-bold">{{ $almt->jalan }}</p>
                        <p class="mb-1 text-muted small">{{ $almt->kelurahan }}, {{ $almt->kecamatan }}</p>
                        <p class="mb-1 text-muted small">{{ $almt->kota }}, {{ $almt->provinsi }} {{ $almt->kode_pos }}</p>
                        @if($almt->detail)
                            <div class="mt-2 p-2 bg-light rounded small text-muted">
                                <strong>Catatan:</strong> {{ $almt->detail }}
                            </div>
                        @endif

                        <div class="mt-3">
                            <form action="{{ route('alamat.destroy', $almt->id_alamat_pembeli) }}" method="POST" class="d-inline" novalidate>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">Hapus Alamat</button>
                            </form>
                        </div>
                    </div>

                    <!-- Right: Form untuk Update -->
                    <div class="col-lg-6 border-start ps-lg-4">
                        <h6 class="small fw-bold mb-3 text-muted">Perbarui Alamat</h6>
                        <form action="{{ route('alamat.update', $almt->id_alamat_pembeli) }}" method="POST" novalidate>
                            @csrf
                            @method('PUT')
                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <input type="text" name="provinsi" class="form-control form-control-sm" value="{{ $almt->provinsi }}" placeholder="Provinsi">
                                </div>
                                <div class="col-6">
                                    <input type="text" name="kota" class="form-control form-control-sm" value="{{ $almt->kota }}" placeholder="Kota">
                                </div>
                            </div>
                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <input type="text" name="kecamatan" class="form-control form-control-sm" value="{{ $almt->kecamatan }}" placeholder="Kecamatan">
                                </div>
                                <div class="col-6">
                                    <input type="text" name="kelurahan" class="form-control form-control-sm" value="{{ $almt->kelurahan }}" placeholder="Kelurahan">
                                </div>
                            </div>
                            <div class="row g-2 mb-2">
                                <div class="col-8">
                                    <input type="text" name="jalan" class="form-control form-control-sm" value="{{ $almt->jalan }}" placeholder="Nama Jalan">
                                </div>
                                <div class="col-4">
                                    <input type="text" name="kode_pos" class="form-control form-control-sm" value="{{ $almt->kode_pos }}" placeholder="Kode Pos">
                                </div>
                            </div>
                            <div class="mb-2">
                                <textarea name="detail" class="form-control form-control-sm" rows="2" placeholder="Detail catatan (patokan, nomor rumah, dll)">{{ $almt->detail }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-outline-primary btn-sm">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Modal Tambah Alamat -->
<div class="modal fade" id="tambahAlamatModal" tabindex="-1" aria-labelledby="tambahAlamatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form action="{{ route('alamat.store') }}" method="POST" class="modal-content" novalidate>
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="tambahAlamatModalLabel">Tambah Alamat Pengiriman Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Provinsi</label>
                        <input type="text" name="provinsi" class="form-control" placeholder="Contoh: D.I. Yogyakarta">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Kota / Kabupaten</label>
                        <input type="text" name="kota" class="form-control" placeholder="Contoh: Sleman">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Kecamatan</label>
                        <input type="text" name="kecamatan" class="form-control" placeholder="Contoh: Depok">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Kelurahan / Desa</label>
                        <input type="text" name="kelurahan" class="form-control" placeholder="Contoh: Caturtunggal">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label small fw-semibold">Alamat Jalan</label>
                        <textarea class="form-control" name="jalan" rows="2" placeholder="Nama jalan, nomor rumah, RT/RW..."></textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold">Kode Pos</label>
                        <input type="text" name="kode_pos" class="form-control" placeholder="Contoh: 55281">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label small fw-semibold">Detail Patokan (Opsional)</label>
                        <textarea class="form-control" name="detail" rows="2" placeholder="Patokan atau instruksi khusus untuk kurir..."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top-0 pt-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary px-4">Simpan Alamat</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
