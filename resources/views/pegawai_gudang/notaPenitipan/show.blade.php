@extends('pegawai_gudang.dashboard')

@section('isi')
<div class="container-fluid px-2">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1" style="color: var(--text-heading);">Detail Nota Penitipan #{{ $nota->no_nota }}</h3>
            <p class="text-muted small mb-0">Informasi lengkap nota konsinyasi titip barang dan daftar seluruh item terdaftar</p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('pegawai_gudang.notaPenitipan.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <a href="{{ route('pegawai_gudang.notaPenitipan.print', $nota->id_nota) }}" class="btn btn-outline-danger">
                <i class="bi bi-printer me-1"></i> Cetak PDF
            </a>
        </div>
    </div>

    {{-- Info Card Ringkasan Nota --}}
    <div class="card border-0 shadow-sm p-4 mb-4" style="border: 1px solid var(--border-color) !important; border-radius: var(--radius-md);">
        <div class="row g-3">
            <div class="col-12 col-md-3">
                <div class="p-3 rounded-3 bg-light">
                    <small class="text-muted d-block mb-1">Mitra Penitip</small>
                    <span class="fw-bold text-dark">
                        <i class="bi bi-person me-1 text-muted"></i>
                        T{{ $nota->penitip->id_penitip }} – {{ $nota->penitip->nama_penitip }}
                    </span>
                </div>
            </div>

            <div class="col-12 col-md-3">
                <div class="p-3 rounded-3 bg-light">
                    <small class="text-muted d-block mb-1">Waktu Masuk Penitipan</small>
                    <span class="fw-bold text-dark">
                        <i class="bi bi-calendar3 me-1 text-muted"></i>
                        {{ \Carbon\Carbon::parse($nota->tanggal_penitipan)->format('d/m/Y H:i') }}
                    </span>
                </div>
            </div>

            <div class="col-12 col-md-3">
                <div class="p-3 rounded-3 bg-light">
                    <small class="text-muted d-block mb-1">Batas Akhir Konsinyasi</small>
                    <span class="fw-bold text-danger">
                        <i class="bi bi-clock-history me-1"></i>
                        {{ \Carbon\Carbon::parse($nota->masa_berakhir)->format('d/m/Y') }}
                    </span>
                </div>
            </div>

            <div class="col-12 col-md-3">
                <div class="p-3 rounded-3 bg-light">
                    <small class="text-muted d-block mb-1">Petugas QC Pemeriksa</small>
                    <span class="fw-bold text-dark">
                        <i class="bi bi-shield-check me-1 text-muted"></i>
                        P{{ $nota->pegawaiQc->id_pegawai ?? '-' }} – {{ $nota->pegawaiQc->nama_pegawai ?? '-' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Daftar Barang di Nota Ini --}}
    <div class="table-card">
        <div class="p-3 border-bottom d-flex align-items-center justify-content-between">
            <h6 class="fw-bold mb-0" style="color: var(--text-heading);">
                <i class="bi bi-boxes me-2" style="color: var(--brand-primary);"></i>
                Daftar Barang Terdaftar dalam Nota Ini
            </h6>
            <span class="badge bg-light text-muted border">{{ $nota->barangTitipan->count() }} item</span>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0 text-center">
                <thead>
                    <tr>
                        <th style="width: 110px;">Kode Barang</th>
                        <th class="text-start">Nama Barang</th>
                        <th class="text-end">Harga Jual</th>
                        <th class="text-start">Kategori</th>
                        <th class="text-center">Garansi</th>
                        <th class="text-center">Berat (kg)</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($nota->barangTitipan as $barang)
                    <tr>
                        <td class="fw-semibold text-muted font-monospace">
                            {{ strtoupper(substr($barang->nama_barang, 0, 1)) . $barang->id_barang }}
                        </td>
                        <td class="text-start fw-bold" style="color: var(--text-heading);">{{ $barang->nama_barang }}</td>
                        <td class="text-end fw-bold text-success">
                            Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}
                        </td>
                        <td class="text-start text-muted">{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                        <td>
                            @if($barang->garansi && $barang->tanggal_garansi)
                                <span class="badge bg-light text-success border">
                                    <i class="bi bi-shield-check me-1"></i> s.d {{ \Carbon\Carbon::parse($barang->tanggal_garansi)->format('M Y') }}
                                </span>
                            @else
                                <span class="text-muted small">Tidak Ada</span>
                            @endif
                        </td>
                        <td class="text-muted font-monospace">{{ $barang->berat }}</td>
                        <td>
                            @php
                                $statusLower = strtolower($barang->status_barang);
                            @endphp
                            @if(str_contains($statusLower, 'tersedia'))
                                <span class="badge-status badge-tersedia">Tersedia</span>
                            @elseif(str_contains($statusLower, 'terjual'))
                                <span class="badge-status badge-terjual">Terjual</span>
                            @elseif(str_contains($statusLower, 'donasi'))
                                <span class="badge-status badge-didonasikan">Didonasikan</span>
                            @else
                                <span class="badge bg-light text-muted border">{{ $barang->status_barang }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('pegawai_gudang.barangTitipan.showDetail', $barang->id_barang) }}" class="btn btn-sm btn-outline-primary" title="Detail Barang">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-5 text-center text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2 text-muted opacity-50"></i>
                            Belum ada barang yang terdaftar di nota ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
