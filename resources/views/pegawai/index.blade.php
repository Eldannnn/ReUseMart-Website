@extends('Admin.dashboard')
@section('isi')
<div class="container-fluid px-2">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1" style="color: var(--text-heading);">Kelola Pegawai</h3>
            <p class="text-muted small mb-0">Daftar akun pegawai internal dan staf operasional ReUseMart</p>
        </div>

        <div class="d-flex flex-wrap align-items-center gap-2">
            <form class="d-flex align-items-center" action="{{ route('pegawai.search') }}" method="GET" novalidate>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0" style="border-color: var(--border-color);">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input class="form-control border-start-0 ps-0" 
                        type="search" 
                        name="search" 
                        placeholder="Cari pegawai..." 
                        value="{{ request('search') }}"
                        style="width: 220px; border-color: var(--border-color);">
                </div>
                <button class="btn btn-outline-primary ms-2" type="submit">
                    Cari
                </button>
            </form>

            <a href="{{ route('pegawai.create') }}" class="btn btn-primary">
                <i class="bi bi-person-plus-fill me-1"></i> Tambah Pegawai
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($pegawai->isEmpty())
        <div class="table-card p-5 text-center text-muted">
            <i class="bi bi-person-x fs-1 d-block mb-2 text-muted opacity-50"></i>
            <h6 class="fw-bold mb-1">Pegawai Tidak Ditemukan</h6>
            <p class="small mb-3">Tidak ada data pegawai yang sesuai dengan kata kunci pencarian Anda.</p>
            <a href="{{ route('pegawai.index') }}" class="btn btn-sm btn-outline-primary">
                Reset Pencarian
            </a>
        </div>
    @else
        <div class="table-card">
            <div class="table-responsive">
                <table class="table align-middle mb-0 text-center">
                    <thead>
                        <tr>
                            <th style="width: 70px;">ID</th>
                            <th class="text-start">Nama Pegawai</th>
                            <th class="text-start">Email</th>
                            <th class="text-start">No. Telepon</th>
                            <th class="text-center">Jabatan</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" style="width: 200px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pegawai as $p)
                            <tr>
                                <td class="fw-semibold text-muted">{{ $p->id_pegawai }}</td>
                                <td class="text-start fw-bold" style="color: var(--text-heading);">
                                    {{ $p->nama_pegawai }}
                                </td>
                                <td class="text-start text-muted">{{ $p->email }}</td>
                                <td class="text-start text-muted">{{ $p->notelp }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ $p->jabatan->nama_jabatan ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    @if($p->status_aktif == 1)
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
                                        <a href="{{ route('pegawai.edit', $p->id_pegawai) }}" class="btn btn-sm btn-outline-primary" title="Edit Data">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        @if($p->status_aktif == 1)
                                            <button type="button" class="btn btn-sm btn-outline-secondary btn-toggle-status"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#toggleStatusPegawaiModal"
                                                    data-action="{{ route('pegawai.nonaktifkan', $p->id_pegawai) }}"
                                                    data-title="Nonaktifkan Pegawai?"
                                                    data-msg="Pegawai ini tidak akan dapat login ke sistem untuk sementara."
                                                    data-btn="Nonaktifkan"
                                                    data-btn-class="btn-secondary"
                                                    title="Nonaktifkan">
                                                <i class="bi bi-slash-circle"></i>
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-sm btn-outline-success btn-toggle-status"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#toggleStatusPegawaiModal"
                                                    data-action="{{ route('pegawai.aktifkan', $p->id_pegawai) }}"
                                                    data-title="Aktifkan Pegawai Kembali?"
                                                    data-msg="Pegawai ini akan kembali memiliki hak akses ke sistem."
                                                    data-btn="Aktifkan Kembali"
                                                    data-btn-class="btn-success"
                                                    title="Aktifkan">
                                                <i class="bi bi-check-circle"></i>
                                            </button>
                                        @endif

                                        <button type="button" class="btn btn-sm btn-outline-danger btn-hapus-pegawai"
                                                data-bs-toggle="modal"
                                                data-bs-target="#hapusPegawaiModal"
                                                data-action="{{ route('pegawai.destroy', $p->id_pegawai) }}"
                                                data-nama="{{ $p->nama_pegawai }}"
                                                title="Hapus Pegawai">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

{{-- Modal Konfirmasi Status Pegawai --}}
<div class="modal fade" id="toggleStatusPegawaiModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="toggleStatusPegawaiForm" method="POST" novalidate>
        @csrf
        @method('PATCH')
        <div class="modal-header">
          <h5 class="modal-title" id="statusModalTitle">Konfirmasi Status</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4 text-center">
          <p class="text-muted mb-0" id="statusModalMsg">-</p>
        </div>
        <div class="modal-footer bg-light justify-content-center">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn" id="btnSubmitStatus">Konfirmasi</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Modal Konfirmasi Hapus Pegawai --}}
<div class="modal fade" id="hapusPegawaiModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="hapusPegawaiForm" method="POST" novalidate>
        @csrf
        @method('DELETE')
        <div class="modal-header bg-danger">
          <h5 class="modal-title">Konfirmasi Hapus Pegawai</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4 text-center">
          <div class="text-danger mb-3">
            <i class="bi bi-exclamation-triangle-fill fs-1"></i>
          </div>
          <h5 class="fw-bold mb-2">Hapus Akun Pegawai Ini?</h5>
          <p class="text-muted small mb-0">
            Akun pegawai <strong id="hapusPegawaiNama">-</strong> akan dihapus permanen dari sistem.
          </p>
        </div>
        <div class="modal-footer bg-light justify-content-center">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger">
            <i class="bi bi-trash3 me-1"></i> Ya, Hapus Pegawai
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const toggleButtons = document.querySelectorAll('.btn-toggle-status');
    const toggleForm = document.getElementById('toggleStatusPegawaiForm');
    const statusModalTitle = document.getElementById('statusModalTitle');
    const statusModalMsg = document.getElementById('statusModalMsg');
    const btnSubmitStatus = document.getElementById('btnSubmitStatus');

    toggleButtons.forEach(btn => {
        btn.addEventListener('click', function(){
            toggleForm.action = this.dataset.action;
            statusModalTitle.textContent = this.dataset.title;
            statusModalMsg.textContent = this.dataset.msg;
            btnSubmitStatus.textContent = this.dataset.btn;
            btnSubmitStatus.className = 'btn ' + this.dataset.btnClass;
        });
    });

    const hapusButtons = document.querySelectorAll('.btn-hapus-pegawai');
    const hapusForm = document.getElementById('hapusPegawaiForm');
    const hapusNama = document.getElementById('hapusPegawaiNama');

    hapusButtons.forEach(btn => {
        btn.addEventListener('click', function(){
            hapusForm.action = this.dataset.action;
            hapusNama.textContent = this.dataset.nama;
        });
    });
});
</script>
@endsection
