@extends('pegawai_gudang.dashboard')

@section('isi')
<div class="container-fluid px-2">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1" style="color: var(--text-heading);">Cari Data Penitip</h3>
            <p class="text-muted small mb-0">Temukan profil mitra penitip untuk pembuatan nota konsinyasi titipan baru</p>
        </div>

        <form method="GET" action="{{ route('pegawai_gudang.barangTitipan.cariPenitip') }}" class="d-flex align-items-center gap-2" novalidate>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0" style="border-color: var(--border-color);">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="ID, Nama, No KTP, Username..." value="{{ request('search') }}" style="width: 260px; border-color: var(--border-color);">
            </div>
            <button class="btn btn-outline-primary" type="submit">Cari Penitip</button>
        </form>
    </div>

    @if(count($penitip) > 0)
    <div class="table-card">
        <div class="table-responsive">
            <table class="table align-middle mb-0 text-center">
                <thead>
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th class="text-start">Nama Penitip</th>
                        <th class="text-start">No. KTP</th>
                        <th class="text-start">Username</th>
                        <th class="text-start">Alamat</th>
                        <th class="text-start">Email</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($penitip as $p)
                    <tr>
                        <td class="fw-semibold text-muted font-monospace">T{{ $p->id_penitip }}</td>
                        <td class="text-start fw-bold" style="color: var(--text-heading);">{{ $p->nama_penitip }}</td>
                        <td class="text-start text-muted font-monospace small">{{ $p->no_ktp }}</td>
                        <td class="text-start text-muted">{{ $p->username }}</td>
                        <td class="text-start text-muted small">{{ $p->alamat }}</td>
                        <td class="text-start text-muted small">{{ $p->email }}</td>
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
                            @if($p->status_aktif == 1)
                                <a href="{{ route('pegawai_gudang.notaPenitipan.create', ['id_penitip' => $p->id_penitip]) }}" 
                                   class="btn btn-primary btn-sm">
                                    <i class="bi bi-check2 me-1"></i> Pilih
                                </a>
                            @else
                                <button class="btn btn-outline-secondary btn-sm" disabled title="Penitip tidak aktif">
                                    Nonaktif
                                </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @elseif(request('search'))
        <div class="table-card p-5 text-center text-muted">
            <i class="bi bi-person-x fs-1 d-block mb-2 text-muted opacity-50"></i>
            <h6 class="fw-bold mb-1">Data Penitip Tidak Ditemukan</h6>
            <p class="small mb-0">Pastikan nomor KTP, nama, atau username yang dimasukkan sudah terdaftar di sistem.</p>
        </div>
    @endif
</div>
@endsection
