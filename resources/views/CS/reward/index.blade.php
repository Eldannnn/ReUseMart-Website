@extends('CS.dashboard')

@section('isi')
<div class="container-fluid px-2">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1" style="color: var(--text-heading);">Daftar Klaim Merchandise</h3>
            <p class="text-muted small mb-0">Kelola dan verifikasi pengambilan reward merchandise oleh pembeli setia ReUseMart</p>
        </div>

        <div class="d-flex flex-wrap align-items-center gap-2">
            <form method="GET" action="{{ route('cs.reward.index') }}" class="d-flex align-items-center gap-2" novalidate>
                <select 
                    id="filter-select" 
                    name="filter" 
                    class="form-select" 
                    style="width: 150px;"
                    onchange="this.form.submit()"
                >
                    <option value="semua" {{ $filter === 'semua' ? 'selected' : '' }}>Semua Status</option>
                    <option value="belum" {{ $filter === 'belum' ? 'selected' : '' }}>Belum Diambil</option>
                </select>

                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0" style="border-color: var(--border-color);">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input 
                        type="search" 
                        name="search" 
                        class="form-control border-start-0 ps-0" 
                        placeholder="Cari pembeli / merch..." 
                        value="{{ request('search') }}" 
                        style="width: 180px; border-color: var(--border-color);"
                    >
                </div>

                <input type="date" name="tanggal_klaim" class="form-control" value="{{ request('tanggal_klaim') }}" style="width: 150px;">
                <button class="btn btn-outline-primary" type="submit">Filter</button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Tabel daftar klaim --}}
    <div class="table-card">
        <div class="table-responsive">
            <table class="table align-middle mb-0 text-center">
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th class="text-start">Nama Pembeli</th>
                        <th class="text-start">Merchandise</th>
                        <th class="text-center">Tanggal Klaim</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Tanggal Ambil</th>
                        <th class="text-center" style="width: 160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rewards as $reward)
                        <tr>
                            <td class="text-muted">{{ $loop->iteration }}</td>
                            <td class="text-start fw-bold" style="color: var(--text-heading);">
                                {{ $reward->pembeli->nama_pembeli ?? 'Pembeli' }}
                            </td>
                            <td class="text-start fw-semibold text-muted">
                                <i class="bi bi-gift-fill me-1" style="color: var(--brand-primary);"></i>
                                {{ $reward->merchandise->nama_merchandise ?? 'Merchandise' }}
                            </td>
                            <td class="text-muted">{{ $reward->tanggal_klaim ? $reward->tanggal_klaim->format('d/m/Y') : '-' }}</td>
                            <td>
                                @if($reward->status_penukaran)
                                    <span class="badge-status badge-tersedia">
                                        <i class="bi bi-check-circle-fill me-1"></i> Sudah Diambil
                                    </span>
                                @else
                                    <span class="badge-status badge-didonasikan">
                                        <i class="bi bi-clock-fill me-1"></i> Belum Diambil
                                    </span>
                                @endif
                            </td>
                            <td class="text-muted">
                                {{ $reward->tanggal_ambil ? $reward->tanggal_ambil->format('d/m/Y') : '-' }}
                            </td>
                            <td>
                                @if(!$reward->status_penukaran)
                                    <button type="button" 
                                            class="btn btn-sm btn-primary btn-ambil-merch"
                                            data-bs-toggle="modal"
                                            data-bs-target="#ambilMerchModal"
                                            data-action="{{ route('cs.reward.ambilMerch', $reward->id_reward) }}"
                                            data-pembeli="{{ $reward->pembeli->nama_pembeli ?? 'Pembeli' }}"
                                            data-merch="{{ $reward->merchandise->nama_merchandise ?? 'Merchandise' }}">
                                        <i class="bi bi-check2-circle me-1"></i> Tandai Diambil
                                    </button>
                                @else
                                    <span class="badge bg-light text-muted border">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-5 text-center text-muted">
                                <i class="bi bi-gift fs-1 d-block mb-2 text-muted opacity-50"></i>
                                Klaim merchandise tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $rewards->appends(['search' => request('search'), 'filter' => request('filter'), 'tanggal_klaim' => request('tanggal_klaim')])->links('pagination::bootstrap-5') }}
    </div>
</div>

{{-- Modal Konfirmasi Pengambilan Merchandise --}}
<div class="modal fade" id="ambilMerchModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="ambilMerchForm" method="POST" novalidate>
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Konfirmasi Pengambilan Reward</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4 text-center">
          <div class="text-success mb-3">
            <i class="bi bi-patch-check-fill fs-1" style="color: var(--brand-primary);"></i>
          </div>
          <h5 class="fw-bold mb-2">Tandai Merchandise Telah Diambil?</h5>
          <p class="text-muted small mb-0">
            Klaim item <strong id="modalMerchText">-</strong> oleh <strong id="modalPembeliText">-</strong> akan ditandai telah diserahkan.
          </p>
        </div>
        <div class="modal-footer bg-light justify-content-center">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-check2 me-1"></i> Ya, Konfirmasi Penyerahan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const ambilButtons = document.querySelectorAll('.btn-ambil-merch');
    const ambilForm = document.getElementById('ambilMerchForm');
    const modalMerchText = document.getElementById('modalMerchText');
    const modalPembeliText = document.getElementById('modalPembeliText');

    ambilButtons.forEach(btn => {
        btn.addEventListener('click', function(){
            ambilForm.action = this.dataset.action;
            modalMerchText.textContent = this.dataset.merch || 'Merchandise';
            modalPembeliText.textContent = this.dataset.pembeli || 'Pembeli';
        });
    });
});
</script>
@endsection
