@extends('CS.dashboard')

@section('isi')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container-fluid px-2">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1" style="color: var(--text-heading);">Diskusi Produk Belum Dijawab</h3>
            <p class="text-muted small mb-0">Pertanyaan pembeli seputar detail barang titipan yang memerlukan respon Customer Service</p>
        </div>
    </div>

    {{-- Pesan Sukses Session --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Daftar Diskusi --}}
    <div class="discussion-container">
        @forelse ($diskusi as $d)
            <div class="card border-0 shadow-sm mb-3" id="diskusi_{{ $d->id_diskusi }}" style="border: 1px solid var(--border-color) !important; border-radius: var(--radius-md);">
                <div class="card-header bg-white border-bottom p-3 d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge-status badge-didonasikan">
                            <i class="bi bi-box-seam me-1"></i> Produk
                        </span>
                        <span class="fw-bold" style="color: var(--text-heading);">
                            {{ $d->barang_titipan ? $d->barang_titipan->nama_barang : 'Produk tidak ditemukan' }}
                        </span>
                    </div>
                    <span class="badge bg-light text-muted border">
                        ID Diskusi #{{ $d->id_diskusi }}
                    </span>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div class="stat-icon" style="width: 40px; height: 40px; font-size: 16px;">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <h6 class="fw-bold mb-0" style="color: var(--text-heading);">
                                    {{ $d->pembeli->nama_pembeli ?? 'Pembeli' }}
                                </h6>
                                <span class="badge bg-light text-muted border small">Pembeli</span>
                            </div>
                            <div class="p-3 rounded-3 mt-2" style="background-color: var(--bg-muted); border-left: 3px solid var(--brand-primary);">
                                <p class="mb-0 text-dark" style="font-size: 14.5px;">{{ $d->pertanyaan }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end pt-2">
                        <button class="btn btn-primary btn-jawab" 
                                data-bs-toggle="modal" 
                                data-bs-target="#jawabModal" 
                                data-id="{{ $d->id_diskusi }}" 
                                data-pertanyaan="{{ $d->pertanyaan }}"
                                data-produk="{{ $d->barang_titipan ? $d->barang_titipan->nama_barang : 'Produk' }}"
                                data-pembeli="{{ $d->pembeli->nama_pembeli ?? 'Pembeli' }}">
                            <i class="bi bi-reply-fill me-1"></i> Berikan Jawaban
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="table-card p-5 text-center text-muted">
                <i class="bi bi-chat-heart fs-1 d-block mb-2 text-muted opacity-50"></i>
                <h6 class="fw-bold mb-1">Semua Pertanyaan Telah Terjawab!</h6>
                <p class="small mb-0">Tidak ada pertanyaan baru dari pembeli yang menunggu respon saat ini.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $diskusi->links() }}
    </div>
</div>

{{-- Toast Container --}}
<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1090;">
  <div id="csToast" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body d-flex align-items-center gap-2" id="csToastMsg">
        <i class="bi bi-check-circle-fill fs-5"></i>
        <span>Pesan aksi</span>
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>

<!-- Modal Form Jawaban -->
<div class="modal fade" id="jawabModal" tabindex="-1" aria-labelledby="jawabModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="jawabModalLabel">Respon Diskusi Pembeli</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formJawaban" method="POST" novalidate>
                @csrf
                <div class="modal-body p-4">
                    <input type="hidden" id="diskusi_id" name="diskusi_id">
                    
                    <div class="p-3 rounded-3 mb-3" style="background-color: var(--bg-muted);">
                        <div class="text-muted small mb-1">
                            <span class="fw-semibold" id="modalTargetProduk">-</span> • Dari: <span id="modalTargetPembeli">-</span>
                        </div>
                        <div class="fw-semibold text-dark small" id="modalTargetPertanyaan">-</div>
                    </div>

                    <div class="mb-3">
                        <label for="jawaban" class="form-label fw-semibold">Jawaban Customer Service</label>
                        <textarea id="jawaban" name="jawaban" class="form-control" rows="4" placeholder="Tuliskan jawaban informatif dan ramah kepada pembeli..."></textarea>
                        <div class="invalid-feedback d-none" id="jawabanError">Jawaban tidak boleh kosong.</div>
                    </div>
                </div>
                <div class="modal-footer bg-light px-4 py-3">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnSubmitJawaban">
                        <i class="bi bi-send-fill me-1"></i> Kirim Jawaban
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

function showToastCS(msg, isSuccess = true) {
    const toastEl = document.getElementById('csToast');
    const toastMsg = document.getElementById('csToastMsg');
    toastEl.classList.remove('bg-success', 'bg-danger');
    toastEl.classList.add(isSuccess ? 'bg-success' : 'bg-danger');
    toastMsg.innerHTML = `<i class="bi ${isSuccess ? 'bi-check-circle-fill' : 'bi-exclamation-octagon-fill'} fs-5"></i> <span>${msg}</span>`;
    const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
    toast.show();
}

const jawabModal = document.getElementById('jawabModal');
jawabModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const diskusiId = button.getAttribute('data-id');
    const pertanyaan = button.getAttribute('data-pertanyaan');
    const produk = button.getAttribute('data-produk');
    const pembeli = button.getAttribute('data-pembeli');

    document.getElementById('diskusi_id').value = diskusiId;
    document.getElementById('modalTargetPertanyaan').textContent = `"${pertanyaan}"`;
    document.getElementById('modalTargetProduk').textContent = produk;
    document.getElementById('modalTargetPembeli').textContent = pembeli;

    const textarea = document.getElementById('jawaban');
    textarea.value = '';
    textarea.classList.remove('is-invalid');
    document.getElementById('jawabanError').classList.add('d-none');
});

document.getElementById('formJawaban').addEventListener('submit', function (e) {
    e.preventDefault();

    const id = document.getElementById('diskusi_id').value;
    const textarea = document.getElementById('jawaban');
    const jawabanText = textarea.value.trim();

    if (!jawabanText) {
        textarea.classList.add('is-invalid');
        document.getElementById('jawabanError').classList.remove('d-none');
        return;
    } else {
        textarea.classList.remove('is-invalid');
        document.getElementById('jawabanError').classList.add('d-none');
    }

    const btn = document.getElementById('btnSubmitJawaban');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Mengirim...';

    fetch('/cs/diskusi/' + id + '/jawab', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({ jawaban: jawabanText })
    })
    .then(response => {
        if (!response.ok) throw new Error('Gagal mengirim jawaban');
        return response.json();
    })
    .then(res => {
        const modalInstance = bootstrap.Modal.getInstance(jawabModal);
        modalInstance.hide();
        showToastCS(res.message || 'Jawaban berhasil dikirimkan.', true);
        setTimeout(() => {
            window.location.replace("/cs/diskusi/belum-dijawab");
        }, 800);
    })
    .catch(error => {
        console.error('Error:', error);
        showToastCS('Terjadi kesalahan saat mengirim jawaban.', false);
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-send-fill me-1"></i> Kirim Jawaban';
    });
});
</script>

@endsection
