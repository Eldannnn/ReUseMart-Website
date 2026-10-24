<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Organisasi - ReUseMart</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/reusemart-theme.css') }}">
    <style>
        .org-header {
            background: var(--brand-primary-gradient) !important;
            box-shadow: 0 4px 20px -2px rgba(111, 143, 70, 0.25);
        }
    </style>
</head>
<body class="bg-light">

<header class="org-header py-3 px-4 border-bottom sticky-top">
    <div class="container d-flex align-items-center justify-content-between">
        <div class="logo">
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/logo2.png') }}" alt="Logo" style="height: 48px;">
            </a>
        </div>

        <div>
            <h5 class="mb-0 fw-bold text-white">Dashboard Organisasi</h5>
        </div>

        <div class="d-flex align-items-center gap-3">
            <span class="text-white small fw-medium">
                <i class="bi bi-building me-1"></i> {{ Auth::user()->nama_organisasi ?? 'Organisasi' }}
            </span>
            <button type="button" class="btn btn-sm btn-outline-light rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#logoutConfirmModal">
                Logout
            </button>
        </div>
    </div>
</header>

<div class="container py-5" style="max-width: 1080px;">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3 border-bottom d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h5 class="fw-bold mb-0" style="color: var(--brand-primary-dark);">Daftar Request Donasi</h5>
                <small class="text-muted">Kelola permohonan donasi barang untuk organisasi Anda</small>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <form action="{{ route('organisasi.request.index') }}" method="GET" class="d-flex gap-2" novalidate>
                    <input type="text" name="q" class="form-control form-control-sm" placeholder="Cari barang dibutuhkan..." value="{{ $search ?? '' }}" style="width: 220px;">
                    <button class="btn btn-outline-primary btn-sm px-3" type="submit">Cari</button>
                </form>
                <button class="btn btn-primary btn-sm px-3" data-bs-toggle="modal" data-bs-target="#createModal">
                    + Tambah Request Donasi
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 60px;">No</th>
                        <th>Barang Dibutuhkan</th>
                        <th>Status Request</th>
                        <th>Nama Organisasi</th>
                        <th class="text-center" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requestDonasis as $index => $requestDonasi)
                        <tr>
                            <td class="text-center text-muted small">{{ $requestDonasis->firstItem() + $index }}</td>
                            <td>
                                <strong class="text-dark">{{ $requestDonasi->barang_dibutuhkan }}</strong>
                            </td>
                            <td>
                                @php
                                    $st = strtolower($requestDonasi->status_request);
                                @endphp
                                <span class="badge-status 
                                    {{ $st == 'diterima' ? 'badge-tersedia' : 
                                       ($st == 'menunggu' ? 'badge-didonasikan' : 'badge-terjual') }}">
                                    {{ $requestDonasi->status_request }}
                                </span>
                            </td>
                            <td class="small">{{ $requestDonasi->organisasi->nama_organisasi }}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editModal{{ $requestDonasi->id_request }}">
                                        Edit
                                    </button>
                                    <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $requestDonasi->id_request }}">
                                        Hapus
                                    </button>
                                </div>

                                <!-- Modal Edit -->
                                <div class="modal fade" id="editModal{{ $requestDonasi->id_request }}" tabindex="-1" aria-labelledby="editModalLabel{{ $requestDonasi->id_request }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form action="{{ route('organisasi.request.update', $requestDonasi->id_request) }}" method="POST" enctype="multipart/form-data" novalidate>
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel{{ $requestDonasi->id_request }}">Edit Request Donasi</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body p-4 text-start">
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold">Barang Dibutuhkan</label>
                                                        <input type="text" name="barang_dibutuhkan" class="form-control" value="{{ $requestDonasi->barang_dibutuhkan }}">
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-top-0 pt-0">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Hapus -->
                                <div class="modal fade" id="deleteModal{{ $requestDonasi->id_request }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title text-white">Konfirmasi Hapus Request</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4 text-center">
                                                <p class="mb-0">Yakin ingin menghapus permohonan donasi <strong>{{ $requestDonasi->barang_dibutuhkan }}</strong>?</p>
                                            </div>
                                            <div class="modal-footer border-top-0 pt-0 justify-content-center">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                <form action="{{ route('organisasi.request.destroy', $requestDonasi->id_request) }}" method="POST" class="d-inline" novalidate>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger px-4">Ya, Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center p-5 text-muted">Belum ada permohonan donasi yang diajukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer bg-white border-top-0 py-3 d-flex justify-content-center">
            {{ $requestDonasis->withQueryString()->links() }}
        </div>
    </div>

    <!-- Modal Tambah Request Donasi -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('organisasi.request.store') }}" method="POST" enctype="multipart/form-data" class="modal-content" novalidate>
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Tambah Request Donasi Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body p-4 text-start">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Barang Yang Dibutuhkan Organisasi</label>
                        <input type="text" name="barang_dibutuhkan" class="form-control" placeholder="Contoh: Pakaian hangat anak, buku pelajaran SD...">
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Kirim Permohonan</button>
                </div>
            </form>
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
                <p class="mb-0">Apakah Anda yakin ingin keluar dari sesi akun organisasi?</p>
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
