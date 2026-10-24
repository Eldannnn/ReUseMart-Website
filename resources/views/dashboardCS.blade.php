@extends('CS.dashboard')

@section('isi')

<div class="container-fluid px-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1" style="color: var(--brand-dark);">Dashboard Customer Service</h4>
            <p class="text-muted small mb-0">Kelola komunikasi dan data penitip ReUseMart</p>
        </div>
        <div>
            <a href="{{ route('cs.penitip.index') }}" class="btn btn-brand">
                <i class="bi bi-people me-1"></i> Buka Manajemen Penitip
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card stat-card border-0 shadow-sm p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small fw-semibold">Pusat Diskusi</div>
                        <h4 class="fw-bold mb-0 mt-2" style="color: var(--brand-dark);">Tanya Jawab</h4>
                    </div>
                    <div class="stat-icon-wrapper rounded-circle p-3" style="background: rgba(111,143,70,0.1); color: var(--brand-primary);">
                        <i class="bi bi-chat-dots-fill fs-3"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('diskusi.index') }}" class="btn btn-sm btn-outline-brand w-100">Buka Diskusi</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card stat-card border-0 shadow-sm p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small fw-semibold">Verifikasi Pembayaran</div>
                        <h4 class="fw-bold mb-0 mt-2" style="color: var(--brand-dark);">Bukti Transfer</h4>
                    </div>
                    <div class="stat-icon-wrapper rounded-circle p-3" style="background: rgba(14,165,233,0.1); color: #0284c7;">
                        <i class="bi bi-credit-card-2-front-fill fs-3"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('cs.pembayaran.index') }}" class="btn btn-sm btn-outline-primary w-100">Verifikasi Pembayaran</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card stat-card border-0 shadow-sm p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small fw-semibold">Penukaran Reward</div>
                        <h4 class="fw-bold mb-0 mt-2" style="color: var(--brand-dark);">Merchandise</h4>
                    </div>
                    <div class="stat-icon-wrapper rounded-circle p-3" style="background: rgba(234,179,8,0.1); color: #ca8a04;">
                        <i class="bi bi-gift-fill fs-3"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('cs.reward.index') }}" class="btn btn-sm btn-outline-warning w-100">Klaim Reward</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
