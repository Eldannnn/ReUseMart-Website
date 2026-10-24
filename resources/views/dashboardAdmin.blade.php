@extends('Admin.dashboard')

@section('isi')
<div class="container-fluid px-2">
    <div class="mb-4">
        <h3 class="fw-bold mb-1" style="color: var(--text-heading);">Dashboard Administrator</h3>
        <p class="text-muted small mb-0">Selamat datang di panel kendali ReUseMart. Pantau dan kelola seluruh aktivitas operasional.</p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-12 col-md-4">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-buildings"></i>
                </div>
                <div>
                    <div class="stat-label">Organisasi Terdaftar</div>
                    <div class="stat-value">100</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-person-badge"></i>
                </div>
                <div>
                    <div class="stat-label">Total Pegawai</div>
                    <div class="stat-value">200</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-trophy"></i>
                </div>
                <div>
                    <div class="stat-label">Aktivitas Penjualan</div>
                    <div class="stat-value">300</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm p-4 text-center" style="border: 1px solid var(--border-color) !important; border-radius: var(--radius-md);">
        <div class="py-4">
            <div class="mb-3">
                <i class="bi bi-shield-check" style="font-size: 3rem; color: var(--brand-primary);"></i>
            </div>
            <h5 class="fw-bold mb-2" style="color: var(--text-heading);">Panel Administrasi ReUseMart</h5>
            <p class="text-muted small mx-auto mb-3" style="max-width: 500px;">
                Gunakan menu sidebar di sebelah kiri untuk mengelola master data Organisasi, Pegawai internal, serta penentuan Top Seller bulanan.
            </p>
            <div class="d-inline-flex gap-2">
                <a href="{{ url('organisasi') }}" class="btn btn-outline-primary">
                    <i class="bi bi-buildings me-1"></i> Data Organisasi
                </a>
                <a href="{{ url('pegawai') }}" class="btn btn-primary">
                    <i class="bi bi-person-badge me-1"></i> Data Pegawai
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
