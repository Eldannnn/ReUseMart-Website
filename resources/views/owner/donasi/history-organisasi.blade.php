@extends('owner.dashboard')
@section('isi')
<div class="container-fluid px-2">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1" style="color: var(--text-heading);">
                Histori Donasi — {{ $organisasi->nama_organisasi }}
            </h3>
            <p class="text-muted small mb-0">
                <i class="bi bi-geo-alt me-1"></i> {{ $organisasi->alamat }}
            </p>
        </div>
        <a href="{{ route('owner.donasi.index') }}" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Kelola Donasi
        </a>
    </div>

    <div class="table-card">
        <div class="table-responsive">
            <table class="table align-middle mb-0 text-center">
                <thead>
                    <tr>
                        <th style="width: 140px;">Kode Barang</th>
                        <th class="text-start">Nama Barang</th>
                        <th class="text-center" style="width: 180px;">Tanggal Donasi</th>
                        <th class="text-start">Nama Penerima</th>
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
                        <td class="text-muted">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ $d->tanggal_donasi ? $d->tanggal_donasi->format('d M Y') : '-' }}
                        </td>
                        <td class="text-start text-muted">{{ $d->penerima }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-5 text-center text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2 text-muted opacity-50"></i>
                            Belum ada riwayat penyaluran donasi untuk organisasi ini.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
