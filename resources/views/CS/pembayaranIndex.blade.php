@extends('CS.dashboard')

@section('isi')
<div class="container-fluid px-2">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1" style="color: var(--text-heading);">Verifikasi Bukti Transfer Pembeli</h3>
            <p class="text-muted small mb-0">Periksa kesesuaian nominal dan bukti pembayaran transfer bank untuk konfirmasi pesanan</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm mb-4">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="table-card">
        <div class="table-responsive">
            <table class="table align-middle mb-0 text-center">
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th>ID Pembayaran</th>
                        <th>ID Pembeli</th>
                        <th>Staf CS</th>
                        <th>ID Transaksi</th>
                        <th class="text-center">Status Verifikasi</th>
                        <th class="text-center" style="width: 140px;">Bukti Transfer</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembayarans as $index => $pembayaran)
                        <tr>
                            <td class="text-muted">{{ $pembayarans->firstItem() + $index }}</td>
                            <td class="fw-semibold text-muted">PMB{{ $pembayaran->id_pembayaran }}</td>
                            <td class="fw-bold" style="color: var(--text-heading);">{{ $pembayaran->id_pembeli }}</td>
                            <td>
                                @if($pembayaran->id_pegawai)
                                    <span class="badge bg-light text-muted border">CS-{{ $pembayaran->id_pegawai }}</span>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                            <td class="fw-semibold">TRX-{{ $pembayaran->id_transaksi }}</td>
                            <td>
                                @php
                                    $status = (int) $pembayaran->status_verifikasi;
                                    $idPegawai = $pembayaran->id_pegawai;
                                @endphp

                                @if ($status === 1)
                                    <span class="badge-status badge-tersedia">
                                        <i class="bi bi-check-circle-fill me-1"></i> Diterima
                                    </span>
                                @elseif ($status === 0 && !is_null($idPegawai) && $idPegawai != '')
                                    <span class="badge-status badge-terjual">
                                        <i class="bi bi-x-circle-fill me-1"></i> Ditolak
                                    </span>
                                @else
                                    <span class="badge-status badge-didonasikan">
                                        <i class="bi bi-clock-fill me-1"></i> Menunggu Verifikasi
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if ($pembayaran->bukti_transfer)
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-primary btn-inspect-bukti"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#verifikasiModal"
                                            data-id="{{ $pembayaran->id_pembayaran }}"
                                            data-trx="{{ $pembayaran->id_transaksi }}"
                                            data-img="{{ asset('images/bukti_pembayaran/' . $pembayaran->bukti_transfer) }}"
                                            data-status="{{ $pembayaran->status_verifikasi }}"
                                            data-verify-url="{{ route('cs.pembayaran.verifikasi', $pembayaran->id_transaksi) }}"
                                            data-reject-url="{{ route('cs.pembayaran.tolak', $pembayaran->id_transaksi) }}">
                                        <i class="bi bi-eye me-1"></i> Periksa
                                    </button>
                                @else
                                    <span class="text-muted small">Belum ada</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-5 text-center text-muted">
                                <i class="bi bi-receipt fs-1 d-block mb-2 text-muted opacity-50"></i>
                                Tidak ada data pembayaran yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {!! $pembayarans->withQueryString()->links('pagination::bootstrap-5') !!}
    </div>
</div>

{{-- Unified Modal Verifikasi Bukti Pembayaran --}}
<div class="modal fade" id="verifikasiModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-file-earmark-check me-2"></i> Periksa Bukti Pembayaran
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="mb-3 text-start p-3 rounded-3" style="background-color: var(--bg-muted);">
                    <div class="d-flex justify-content-between">
                        <span class="text-muted small">Nomor Transaksi:</span>
                        <strong id="modalTrxText">-</strong>
                    </div>
                </div>

                <div class="p-2 border rounded-3 bg-white mb-3">
                    <img id="modalBuktiImg" src="" alt="Bukti Transfer" class="img-fluid rounded" style="max-height: 440px; object-fit: contain;">
                </div>
            </div>
            <div class="modal-footer bg-light px-4 py-3 justify-content-between">
                <form id="formTolakPembayaran" method="POST" novalidate>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger" id="btnTolakPembayaran">
                        <i class="bi bi-x-circle me-1"></i> Tolak Pembayaran
                    </button>
                </form>

                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                    <form id="formTerimaPembayaran" method="POST" novalidate>
                        @csrf
                        <button type="submit" class="btn btn-primary" id="btnTerimaPembayaran">
                            <i class="bi bi-check-circle me-1"></i> Terima & Verifikasi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const inspectButtons = document.querySelectorAll('.btn-inspect-bukti');
    const modalBuktiImg = document.getElementById('modalBuktiImg');
    const modalTrxText = document.getElementById('modalTrxText');
    const formTolak = document.getElementById('formTolakPembayaran');
    const formTerima = document.getElementById('formTerimaPembayaran');
    const btnTolak = document.getElementById('btnTolakPembayaran');
    const btnTerima = document.getElementById('btnTerimaPembayaran');

    inspectButtons.forEach(btn => {
        btn.addEventListener('click', function(){
            const imgSrc = this.dataset.img;
            const trxId = this.dataset.trx;
            const status = parseInt(this.dataset.status);
            const verifyUrl = this.dataset.verifyUrl;
            const rejectUrl = this.dataset.rejectUrl;

            modalBuktiImg.src = imgSrc;
            modalTrxText.textContent = 'TRX-' + trxId;
            formTolak.action = rejectUrl;
            formTerima.action = verifyUrl;

            if (status === 1) {
                btnTolak.disabled = true;
                btnTolak.title = "Pembayaran sudah diverifikasi diterima";
                btnTerima.disabled = true;
                btnTerima.title = "Pembayaran sudah diverifikasi";
            } else {
                btnTolak.disabled = false;
                btnTolak.removeAttribute('title');
                btnTerima.disabled = false;
                btnTerima.removeAttribute('title');
            }
        });
    });
});
</script>
@endsection
