@extends('Admin.dashboard')
@section('isi')

<!-- CSRF token untuk AJAX -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container-fluid px-2">
  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div>
      <h3 class="fw-bold mb-1" style="color: var(--text-heading);">Kelola Organisasi</h3>
      <p class="text-muted small mb-0">Daftar mitra organisasi sosial penerima donasi ReUseMart</p>
    </div>

    <form class="d-flex align-items-center gap-2" method="GET" action="{{ route('organisasi.show') }}" novalidate>
      <div class="input-group">
        <span class="input-group-text bg-white border-end-0" style="border-color: var(--border-color);">
          <i class="bi bi-search text-muted"></i>
        </span>
        <input
          class="form-control border-start-0 ps-0"
          type="search"
          name="q"
          placeholder="Cari organisasi..."
          value="{{ old('q', $q) }}"
          style="width: 220px; border-color: var(--border-color);"
        >
      </div>
      <button class="btn btn-outline-primary" type="submit">
        Cari
      </button>
    </form>
  </div>

  <div class="table-card">
    <div class="table-responsive">
      <table class="table align-middle mb-0 text-center" id="organisasi-table">
        <thead>
          <tr>
            <th class="text-center" style="width: 90px;">ID</th>
            <th class="text-start">Nama Organisasi</th>
            <th class="text-start">Alamat</th>
            <th class="text-center" style="width: 130px;">Status</th>
            <th class="text-center" style="width: 240px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($organisasi as $org)
            <tr data-id="{{ $org->id_organisasi }}">
              <td class="fw-semibold text-muted">ORG{{ $org->id_organisasi }}</td>
              <td class="text-start fw-bold col-nama" style="color: var(--text-heading);">{{ $org->nama_organisasi }}</td>
              <td class="text-start text-muted col-alamat">{{ $org->alamat }}</td>
              <td>
                @if($org->status_aktif)
                  <span class="badge-status badge-tersedia">
                    <i class="bi bi-check-circle-fill me-1"></i> Aktif
                  </span>
                @else
                  <span class="badge-status badge-terjual">
                    <i class="bi bi-x-circle-fill me-1"></i> Nonaktif
                  </span>
                @endif
              </td>
              <td>
                <div class="d-inline-flex gap-2">
                  <button type="button"
                          class="btn btn-sm btn-outline-primary btn-edit"
                          data-bs-toggle="modal"
                          data-bs-target="#editModal"
                          data-id="{{ $org->id_organisasi }}"
                          data-nama="{{ $org->nama_organisasi }}"
                          data-alamat="{{ $org->alamat }}">
                    <i class="bi bi-pencil-square me-1"></i> Perbarui
                  </button>
                  <button type="button"
                          class="btn btn-sm btn-outline-secondary btn-nonaktif"
                          data-bs-toggle="modal"
                          data-bs-target="#nonaktifModal"
                          data-id="{{ $org->id_organisasi }}">
                    <i class="bi bi-slash-circle me-1"></i> Nonaktif
                  </button>
                  <button type="button"
                          class="btn btn-sm btn-outline-danger btn-hapus"
                          data-bs-toggle="modal"
                          data-bs-target="#hapusModal"
                          data-id="{{ $org->id_organisasi }}">
                    <i class="bi bi-trash3 me-1"></i> Hapus
                  </button>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="py-5 text-center text-muted">
                <i class="bi bi-inbox fs-1 d-block mb-2 text-muted opacity-50"></i>
                Tidak ada data organisasi yang ditemukan.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

{{-- Toast Feedback Container --}}
<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1090;">
  <div id="actionToast" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body d-flex align-items-center gap-2" id="toastMessage">
        <i class="bi bi-check-circle-fill fs-5"></i>
        <span>Pesan aksi</span>
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>

{{-- Modal Edit --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="editForm" novalidate>
        @csrf

        <div class="modal-header">
          <h5 class="modal-title">Perbarui Data Organisasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body p-4">
          <input type="hidden" id="editId">

          <div class="mb-3">
            <label class="form-label fw-semibold">Nama Organisasi</label>
            <input type="text" id="editNama" name="nama_organisasi" class="form-control" placeholder="Masukkan nama organisasi">
            <div class="invalid-feedback d-none" id="editNamaError">Nama organisasi tidak boleh kosong.</div>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Alamat</label>
            <textarea id="editAlamat" name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat lengkap organisasi"></textarea>
            <div class="invalid-feedback d-none" id="editAlamatError">Alamat tidak boleh kosong.</div>
          </div>
        </div>

        <div class="modal-footer bg-light px-4 py-3">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary" id="btnSubmitEdit">
            <i class="bi bi-check2 me-1"></i> Simpan Perubahan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Modal Nonaktif --}}
<div class="modal fade" id="nonaktifModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="nonaktifForm" novalidate>
        @csrf

        <div class="modal-header bg-danger">
          <h5 class="modal-title">Konfirmasi Nonaktif</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <input type="hidden" id="nonaktifId">

        <div class="modal-body p-4 text-center">
          <div class="text-danger mb-3">
            <i class="bi bi-slash-circle fs-1"></i>
          </div>
          <h5 class="fw-bold mb-2">Nonaktifkan Organisasi?</h5>
          <p class="text-muted small mb-0">Organisasi ini tidak akan aktif sementara dalam alokasi donasi barang.</p>
        </div>

        <div class="modal-footer bg-light justify-content-center px-4 py-3">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger">
            <i class="bi bi-slash-circle me-1"></i> Ya, Nonaktifkan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Modal Hapus --}}
<div class="modal fade" id="hapusModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="hapusForm" novalidate>
        @csrf

        <div class="modal-header bg-danger">
          <h5 class="modal-title">Konfirmasi Hapus</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <input type="hidden" id="hapusId">

        <div class="modal-body p-4 text-center">
          <div class="text-danger mb-3">
            <i class="bi bi-exclamation-triangle-fill fs-1"></i>
          </div>
          <h5 class="fw-bold mb-2">Hapus Organisasi Ini?</h5>
          <p class="text-muted small mb-0">Tindakan ini tidak dapat dibatalkan. Data organisasi akan dihapus secara permanen.</p>
        </div>

        <div class="modal-footer bg-light justify-content-center px-4 py-3">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger">
            <i class="bi bi-trash3 me-1"></i> Ya, Hapus Permanen
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
$(function(){
  // Pasang header CSRF untuk semua AJAX
  $.ajaxSetup({
    headers:{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
  });

  function showToast(message, isSuccess = true) {
    const toastEl = document.getElementById('actionToast');
    const toastMsg = document.getElementById('toastMessage');
    toastEl.classList.remove('bg-success', 'bg-danger');
    toastEl.classList.add(isSuccess ? 'bg-success' : 'bg-danger');
    toastMsg.innerHTML = `<i class="bi ${isSuccess ? 'bi-check-circle-fill' : 'bi-exclamation-octagon-fill'} fs-5"></i> <span>${message}</span>`;
    const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
    toast.show();
  }

  // Saat modal Edit dibuka, isi field
  $('#editModal').on('show.bs.modal', function(e){
    const btn  = $(e.relatedTarget);
    const id   = btn.data('id');
    const nama = btn.data('nama');
    const alamat = btn.data('alamat');

    $('#editId').val(id);
    $('#editNama').val(nama).removeClass('is-invalid');
    $('#editAlamat').val(alamat).removeClass('is-invalid');
    $('#editNamaError').addClass('d-none');
    $('#editAlamatError').addClass('d-none');
  });

  // Submit Edit via AJAX dengan validasi custom
  $('#editForm').on('submit', function(e){
    e.preventDefault();
    const id = $('#editId').val();
    const nama = $('#editNama').val().trim();
    const alamat = $('#editAlamat').val().trim();

    let hasError = false;
    if (!nama) {
      $('#editNama').addClass('is-invalid');
      $('#editNamaError').removeClass('d-none');
      hasError = true;
    } else {
      $('#editNama').removeClass('is-invalid');
      $('#editNamaError').addClass('d-none');
    }

    if (!alamat) {
      $('#editAlamat').addClass('is-invalid');
      $('#editAlamatError').removeClass('d-none');
      hasError = true;
    } else {
      $('#editAlamat').removeClass('is-invalid');
      $('#editAlamatError').addClass('d-none');
    }

    if (hasError) return;

    const data = { nama_organisasi: nama, alamat: alamat };

    $.post(`/organisasi/${id}`, data)
      .done(res => {
        $('#editModal').modal('hide');
        showToast('Data organisasi berhasil diperbarui.', true);
        setTimeout(() => location.reload(), 800);
      })
      .fail(xhr => {
        const msg = xhr.responseJSON?.message || xhr.statusText || 'Gagal memperbarui data.';
        showToast(msg, false);
      });
  });

  $('#nonaktifModal').on('show.bs.modal', function(e){
    const btn = $(e.relatedTarget);
    $('#nonaktifId').val(btn.data('id'));
  });

  // Submit Nonaktif via AJAX
  $('#nonaktifForm').on('submit', function(e){
    e.preventDefault();
    const id = $('#nonaktifId').val();

    $.post(`/organisasi/${id}/nonaktif`, {})
      .done(res => {
        $('#nonaktifModal').modal('hide');
        showToast('Organisasi berhasil dinonaktifkan.', true);
        setTimeout(() => location.reload(), 800);
      })
      .fail(xhr => {
        const msg = xhr.responseJSON?.message || xhr.statusText || 'Gagal menonaktifkan organisasi.';
        showToast(msg, false);
      });
  });

  // Saat modal hapus dibuka, simpan ID
  $('#hapusModal').on('show.bs.modal', function(e){
    const btn = $(e.relatedTarget);
    $('#hapusId').val(btn.data('id'));
  });

  // Submit hapus via AJAX
  $('#hapusForm').on('submit', function(e){
    e.preventDefault();
    const id = $('#hapusId').val();

    $.post(`/organisasi/${id}/hapus`, {})
      .done(res => {
        $('#hapusModal').modal('hide');
        showToast('Organisasi berhasil dihapus.', true);
        setTimeout(() => location.reload(), 800);
      })
      .fail(xhr => {
        const msg = xhr.responseJSON?.message || xhr.statusText || 'Gagal menghapus organisasi.';
        showToast(msg, false);
      });
  });
});
</script>

@endsection