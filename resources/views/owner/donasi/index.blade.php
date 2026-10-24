@extends('owner.dashboard')

@section('isi')
<div class="container-fluid px-2">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1" style="color: var(--text-heading);">Kelola Alokasi Donasi</h3>
            <p class="text-muted small mb-0">Tinjau permohonan donasi dari organisasi mitra dan alokasikan barang titipan siap donasi</p>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($errors->has('error'))
        <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $errors->first('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Request Donasi Table --}}
    <div class="table-card mb-5">
        <div class="p-3 border-bottom d-flex align-items-center justify-content-between">
            <h6 class="fw-bold mb-0" style="color: var(--text-heading);">
                <i class="bi bi-inbox-fill me-2" style="color: var(--brand-primary);"></i>
                Permohonan Donasi Masuk
            </h6>
            <span class="badge bg-light text-muted border">Permintaan Mitra</span>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0 text-center">
                <thead>
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th class="text-start">Nama Organisasi</th>
                        <th class="text-start">Alamat</th>
                        <th class="text-start">Barang Dibutuhkan</th>
                        <th class="text-center" style="width: 140px;">Status</th>
                        <th class="text-center" style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($requests as $r)
                    <tr>
                        <td class="fw-semibold text-muted">REQ{{ $r->id_request }}</td>
                        <td class="text-start fw-bold" style="color: var(--text-heading);">
                            {{ $r->organisasi->nama_organisasi ?? '-' }}
                        </td>
                        <td class="text-start text-muted">{{ $r->organisasi->alamat ?? '-' }}</td>
                        <td class="text-start fw-semibold text-muted">
                            <i class="bi bi-box me-1"></i> {{ $r->barang_dibutuhkan }}
                        </td>
                        <td>
                            <span class="badge-status badge-didonasikan">
                                {{ $r->status_request }}
                            </span>
                        </td>
                        <td>
                            <button type="button" 
                                    class="btn btn-sm btn-outline-danger btn-tolak-request"
                                    data-bs-toggle="modal"
                                    data-bs-target="#tolakRequestModal"
                                    data-id="{{ $r->id_request }}"
                                    data-org="{{ $r->organisasi->nama_organisasi ?? 'Organisasi' }}"
                                    data-req="{{ $r->barang_dibutuhkan }}">
                                <i class="bi bi-x-circle me-1"></i> Tolak
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-5 text-center text-muted">
                            <i class="bi bi-check2-circle fs-1 d-block mb-2 text-muted opacity-50"></i>
                            Tidak ada permohonan donasi aktif saat ini.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Form Alokasikan Barang --}}
    <div class="card border-0 shadow-sm mb-5" style="border: 1px solid var(--border-color) !important; border-radius: var(--radius-lg);">
        <div class="card-header bg-white border-bottom p-4">
            <h5 class="fw-bold mb-1" style="color: var(--text-heading);">
                <i class="bi bi-heart-fill me-2" style="color: var(--brand-primary);"></i>
                Alokasikan Barang ke Permintaan Donasi
            </h5>
            <p class="text-muted small mb-0">Pilih barang titipan yang telah disetujui untuk didonasikan dan tentukan penerima</p>
        </div>
        <div class="card-body p-4">
            <form method="POST" action="{{ route('owner.donasi.allocate') }}" novalidate id="allocateForm">
                @csrf
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Pilih Barang Siap Donasi</label>
                        <select name="id_barang" class="form-select">
                            <option value="" disabled selected>Pilih Barang Siap Donasi</option>
                            @foreach($barangSiapDonasi as $b)
                                <option value="{{ $b->id_barang }}">{{ $b->nama_barang }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Pilih Request Donasi Organisasi</label>
                        <select name="id_request" class="form-select">
                            <option value="" disabled selected>Pilih Request Organisasi</option>
                            @foreach($requests as $r)
                                <option value="{{ $r->id_request }}">
                                    {{ $r->organisasi->nama_organisasi ?? 'Org' }} — {{ $r->barang_dibutuhkan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Nama Penerima / Perwakilan Organisasi</label>
                        <input type="text" name="penerima" class="form-control" placeholder="Nama lengkap perwakilan penerima">
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Waktu Penyerahan Donasi</label>
                        <input type="datetime-local" name="tanggal_donasi" class="form-control" value="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}">
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-heart me-1"></i> Proses Alokasi Donasi
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Histori Donasi --}}
    <div class="table-card">
        <div class="p-3 border-bottom d-flex align-items-center justify-content-between">
            <h6 class="fw-bold mb-0" style="color: var(--text-heading);">
                <i class="bi bi-clock-history me-2" style="color: var(--brand-primary);"></i>
                Histori Penyaluran Donasi ReUseMart
            </h6>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0 text-center">
                <thead>
                    <tr>
                        <th style="width: 120px;">Kode Barang</th>
                        <th class="text-start">Nama Barang</th>
                        <th class="text-start">Organisasi Mitra</th>
                        <th class="text-start">Nama Penerima</th>
                        <th class="text-center" style="width: 160px;">Tanggal Penyaluran</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($donasiHistori as $d)
                    <tr>
                        <td class="fw-semibold text-muted font-monospace">
                            {{ strtoupper(substr($d->barang_titipan->nama_barang ?? '-', 0, 1)) }}{{ $d->barang_titipan->id_barang ?? '-' }}
                        </td>
                        <td class="text-start fw-bold" style="color: var(--text-heading);">
                            {{ $d->barang_titipan->nama_barang ?? '-' }}
                        </td>
                        <td class="text-start text-muted">
                            <i class="bi bi-buildings me-1"></i>
                            {{ $d->request_donasi->organisasi->nama_organisasi ?? '-' }}
                        </td>
                        <td class="text-start text-muted">{{ $d->penerima }}</td>
                        <td class="text-muted">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ $d->tanggal_donasi->format('d M Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-5 text-center text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2 text-muted opacity-50"></i>
                            Belum ada riwayat penyaluran donasi.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Konfirmasi Tolak Request Donasi --}}
<div class="modal fade" id="tolakRequestModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="tolakRequestForm" method="POST" action="{{ route('owner.donasi.reject') }}" novalidate>
        @csrf
        <input type="hidden" name="id_request" id="modalTolakReqId">

        <div class="modal-header bg-danger">
          <h5 class="modal-title">Konfirmasi Tolak Permohonan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4 text-center">
          <div class="text-danger mb-3">
            <i class="bi bi-x-circle fs-1"></i>
          </div>
          <h5 class="fw-bold mb-2">Tolak Permohonan Donasi Ini?</h5>
          <p class="text-muted small mb-0">
            Permohonan dari <strong id="modalTolakOrgName">-</strong> untuk item <strong id="modalTolakReqItem">-</strong> akan ditolak.
          </p>
        </div>
        <div class="modal-footer bg-light justify-content-center">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger">
            <i class="bi bi-x-circle me-1"></i> Ya, Tolak Permohonan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const tolakButtons = document.querySelectorAll('.btn-tolak-request');
    const modalId = document.getElementById('modalTolakReqId');
    const modalOrg = document.getElementById('modalTolakOrgName');
    const modalReq = document.getElementById('modalTolakReqItem');

    tolakButtons.forEach(btn => {
        btn.addEventListener('click', function(){
            modalId.value = this.dataset.id;
            modalOrg.textContent = this.dataset.org;
            modalReq.textContent = this.dataset.req;
        });
    });
});
</script>
@endsection
