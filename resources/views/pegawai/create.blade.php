@extends('Admin.dashboard')
@section('isi')
<div class="container-fluid px-2">
    <div class="row justify-content-center py-3">
        <div class="col-12 col-md-8 col-lg-7">
            <div class="card border-0 shadow-sm" style="border: 1px solid var(--border-color) !important; border-radius: var(--radius-lg);">
                <div class="card-header bg-white border-bottom p-4">
                    <div class="d-flex align-items-center gap-3">
                        <a href="{{ route('pegawai.index') }}" class="btn btn-sm btn-outline-secondary rounded-circle" style="width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        <div>
                            <h4 class="fw-bold mb-0" style="color: var(--text-heading);">Tambah Pegawai Baru</h4>
                            <p class="text-muted small mb-0">Isi data akun pegawai untuk akses sistem operasional</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm mb-4">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('pegawai.store') }}" method="POST" novalidate id="createPegawaiForm">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Nama Lengkap</label>
                                <input type="text" name="nama_pegawai" class="form-control" value="{{ old('nama_pegawai') }}" placeholder="Nama pegawai">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Username</label>
                                <input type="text" name="username" class="form-control" value="{{ old('username') }}" placeholder="Username sistem">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="alamat@email.com">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Password Akun</label>
                                <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Nomor Telepon</label>
                                <input type="text" name="notelp" class="form-control" value="{{ old('notelp') }}" placeholder="Contoh: 081234567890">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Jabatan Pegawai</label>
                                <select name="id_jabatan" class="form-select">
                                    <option value="" disabled selected>Pilih Jabatan</option>
                                    @foreach($jabatan as $j)
                                        <option value="{{ $j->id_jabatan }}" {{ old('id_jabatan') == $j->id_jabatan ? 'selected' : '' }}>
                                            {{ $j->nama_jabatan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('pegawai.index') }}" class="btn btn-outline-secondary">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check2 me-1"></i> Simpan Pegawai
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
