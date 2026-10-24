@extends('pegawai_gudang.dashboard')

@section('isi')
<div class="container-fluid px-2">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1" style="color: var(--text-heading);">Daftar Barang Titipan</h3>
            <p class="text-muted small mb-0">Kelola inventaris fisik barang titipan, status ketersediaan, dan detail spesifikasi</p>
        </div>

        <div class="d-flex flex-wrap align-items-center gap-2">
            <form class="d-flex align-items-center gap-2" action="{{ route('pegawai_gudang.barangTitipan.index') }}" method="GET" novalidate>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0" style="border-color: var(--border-color);">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input class="form-control border-start-0 ps-0" 
                        type="search" 
                        name="search" 
                        placeholder="Cari barang titipan..." 
                        value="{{ request('search') }}"
                        style="width: 200px; border-color: var(--border-color);">
                </div>
                <input class="form-control" type="date" name="date" value="{{ request('date') }}" style="width: 150px;">
                <button class="btn btn-outline-primary" type="submit">Filter</button>
            </form>
        </div>
    </div>

    {{-- Flash message --}}
    @if (session('success'))
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Tabel --}}
    <div class="table-card">
        <div class="table-responsive">
            <table class="table align-middle mb-0 text-center">
                <thead>
                    <tr>
                        <th style="width: 110px;">Kode Barang</th>
                        <th class="text-start">Nama Barang</th>
                        <th class="text-start">Kategori</th>
                        <th class="text-center" style="width: 140px;">Status</th>
                        <th class="text-start">Penitip</th>
                        <th class="text-center" style="width: 110px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($barang as $item)
                    <tr>
                        <td class="fw-semibold text-muted font-monospace">
                            {{ strtoupper(substr($item->nama_barang, 0, 1)) . $item->id_barang }}
                        </td>
                        <td class="text-start fw-bold" style="color: var(--text-heading);">{{ $item->nama_barang }}</td>
                        <td class="text-start text-muted">
                            <span class="badge bg-light text-dark border">
                                {{ $item->kategori->nama_kategori ?? '-' }}
                            </span>
                        </td>
                        <td>
                            @php
                                $statusLower = strtolower($item->status_barang);
                            @endphp
                            @if(str_contains($statusLower, 'tersedia'))
                                <span class="badge-status badge-tersedia">
                                    <i class="bi bi-check-circle-fill me-1"></i> Tersedia
                                </span>
                            @elseif(str_contains($statusLower, 'terjual'))
                                <span class="badge-status badge-terjual">
                                    <i class="bi bi-bag-check-fill me-1"></i> Terjual
                                </span>
                            @elseif(str_contains($statusLower, 'donasi'))
                                <span class="badge-status badge-didonasikan">
                                    <i class="bi bi-heart-fill me-1"></i> Didonasikan
                                </span>
                            @else
                                <span class="badge bg-light text-muted border">
                                    {{ $item->status_barang }}
                                </span>
                            @endif
                        </td>
                        <td class="text-start text-muted">
                            <i class="bi bi-person me-1"></i>
                            T{{ $item->penitip->id_penitip ?? '-' }} - {{ $item->penitip->nama_penitip ?? '-' }}
                        </td>
                        <td>
                            <a href="{{ route('pegawai_gudang.barangTitipan.showDetail', $item->id_barang) }}" class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-5 text-center text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2 text-muted opacity-50"></i>
                            Belum ada barang titipan yang ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $barang->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
