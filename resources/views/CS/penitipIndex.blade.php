@extends('CS.dashboard')

@section('isi')
<div class="container-fluid px-2">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1" style="color: var(--text-heading);">Kelola Akun Penitip</h3>
            <p class="text-muted small mb-0">Daftar mitra penitip barang ReUseMart, verifikasi KTP, dan kelola informasi akun</p>
        </div>

        <div class="d-flex flex-wrap align-items-center gap-2">
            <form action="{{ route('cs.penitip.index') }}" method="GET" class="d-flex align-items-center" novalidate>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0" style="border-color: var(--border-color);">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" name="q" class="form-control border-start-0 ps-0" placeholder="Cari data penitip..." value="{{ $search }}" style="width: 220px; border-color: var(--border-color);">
                </div>
                <button class="btn btn-outline-primary ms-2" type="submit">Cari</button>
            </form>

            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPenitipModal">
                <i class="bi bi-person-plus-fill me-1"></i> Tambah Penitip
            </button>
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
                        <th class="text-start">Nama Penitip</th>
                        <th class="text-start">No. KTP</th>
                        <th class="text-start">Email</th>
                        <th class="text-start">Username</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 100px;">Foto KTP</th>
                        <th class="text-center" style="width: 160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penitips as $index => $penitip)
                        <tr>
                            <td class="text-muted">{{ $penitips->firstItem() + $index }}</td>
                            <td class="text-start fw-bold" style="color: var(--text-heading);">
                                {{ $penitip->nama_penitip }}
                            </td>
                            <td class="text-start text-muted font-monospace small">{{ $penitip->no_ktp }}</td>
                            <td class="text-start text-muted">{{ $penitip->email }}</td>
                            <td class="text-start text-muted">{{ $penitip->username }}</td>
                            <td>
                                @if($penitip->status_aktif)
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
                                @if($penitip->foto_ktp)
                                    <a href="{{ asset('storage/' . $penitip->foto_ktp) }}" target="_blank" class="btn btn-sm btn-outline-secondary py-1 px-2" title="Lihat Foto KTP">
                                        <i class="bi bi-file-earmark-image"></i>
                                    </a>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-inline-flex gap-2">
                                    <button class="btn btn-sm btn-outline-primary btn-edit-penitip"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editPenitipModal"
                                            data-id="{{ $penitip->id_penitip }}"
                                            data-nama="{{ $penitip->nama_penitip }}"
                                            data-ktp="{{ $penitip->no_ktp }}"
                                            data-email="{{ $penitip->email }}"
                                            data-username="{{ $penitip->username }}"
                                            data-action="{{ route('cs.penitip.update', $penitip->id_penitip) }}"
                                            title="Edit Penitip">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <button class="btn btn-sm btn-outline-danger btn-hapus-penitip"
                                            data-bs-toggle="modal"
                                            data-bs-target="#hapusPenitipModal"
                                            data-action="{{ route('cs.penitip.destroy', $penitip->id_penitip) }}"
                                            data-nama="{{ $penitip->nama_penitip }}"
                                            title="Hapus Penitip">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-5 text-center text-muted">
                                <i class="bi bi-person-x fs-1 d-block mb-2 text-muted opacity-50"></i>
                                Data penitip tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {!! $penitips->withQueryString()->links('pagination::bootstrap-5') !!}
    </div>
</div>

{{-- Single Shared Modal: Edit Penitip --}}
<div class="modal fade" id="editPenitipModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editPenitipForm" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Penitip</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Penitip</label>
                        <input type="text" name="nama_penitip" id="edit_nama_penitip" class="form-control" placeholder="Nama lengkap penitip">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">No. KTP</label>
                        <input type="text" name="no_ktp" id="edit_no_ktp" class="form-control" placeholder="16 digit nomor KTP">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" id="edit_email" class="form-control" placeholder="alamat@email.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Username</label>
                        <input type="text" name="username" id="edit_username" class="form-control" placeholder="Username akun">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Foto KTP (Opsional jika ingin mengganti)</label>
                        <input type="file" name="foto_ktp" class="form-control">
                    </div>
                </div>
                <div class="modal-footer bg-light px-4 py-3">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check2 me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Tambah Penitip --}}
<div class="modal fade" id="createPenitipModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('cs.penitip.store') }}" method="POST" enctype="multipart/form-data" class="modal-content" novalidate id="createPenitipForm">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Tambah Penitip Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Penitip</label>
                    <input type="text" name="nama_penitip" class="form-control" placeholder="Nama lengkap penitip">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">No. KTP</label>
                    <input type="text" name="no_ktp" class="form-control" placeholder="16 digit nomor KTP">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="alamat@email.com">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Alamat Lengkap</label>
                    <textarea name="alamat" class="form-control" rows="2" placeholder="Alamat domisili penitip"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Username untuk login">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Password Akun</label>
                    <input type="password" name="password" class="form-control" placeholder="Password akun penitip">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Foto KTP</label>
                    <input type="file" name="foto_ktp" class="form-control">
                </div>
            </div>
            <div class="modal-footer bg-light px-4 py-3">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check2 me-1"></i> Simpan Penitip
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Konfirmasi Hapus Penitip --}}
<div class="modal fade" id="hapusPenitipModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="hapusPenitipForm" method="POST" novalidate>
        @csrf
        @method('DELETE')
        <div class="modal-header bg-danger">
          <h5 class="modal-title">Konfirmasi Hapus Penitip</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4 text-center">
          <div class="text-danger mb-3">
            <i class="bi bi-exclamation-triangle-fill fs-1"></i>
          </div>
          <h5 class="fw-bold mb-2">Hapus Akun Penitip Ini?</h5>
          <p class="text-muted small mb-0">
            Data mitra penitip <strong id="hapusPenitipNamaText">-</strong> akan dihapus dari sistem.
          </p>
        </div>
        <div class="modal-footer bg-light justify-content-center">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger">
            <i class="bi bi-trash3 me-1"></i> Ya, Hapus Penitip
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const editButtons = document.querySelectorAll('.btn-edit-penitip');
    const editForm = document.getElementById('editPenitipForm');
    const editNama = document.getElementById('edit_nama_penitip');
    const editKtp = document.getElementById('edit_no_ktp');
    const editEmail = document.getElementById('edit_email');
    const editUsername = document.getElementById('edit_username');

    editButtons.forEach(btn => {
        btn.addEventListener('click', function(){
            editForm.action = this.dataset.action;
            editNama.value = this.dataset.nama || '';
            editKtp.value = this.dataset.ktp || '';
            editEmail.value = this.dataset.email || '';
            editUsername.value = this.dataset.username || '';
        });
    });

    const hapusButtons = document.querySelectorAll('.btn-hapus-penitip');
    const hapusForm = document.getElementById('hapusPenitipForm');
    const hapusNamaText = document.getElementById('hapusPenitipNamaText');

    hapusButtons.forEach(btn => {
        btn.addEventListener('click', function(){
            hapusForm.action = this.dataset.action;
            hapusNamaText.textContent = this.dataset.nama || 'Penitip';
        });
    });
});
</script>
@endsection
