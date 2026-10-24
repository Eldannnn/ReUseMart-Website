@extends('owner.dashboard')
@section('isi')
<div class="container-fluid px-2">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1" style="color: var(--text-heading);">Laporan Stok Gudang</h3>
            <p class="text-muted small mb-0">Pemantauan ketersediaan unit barang titipan aktif di fasilitas pergudangan ReUseMart</p>
        </div>

        <div class="d-flex flex-wrap align-items-center gap-2">
            <form method="GET" class="d-flex align-items-center" novalidate>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0" style="border-color: var(--border-color);">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control border-start-0 ps-0" placeholder="Cari nama / kode..." style="width: 200px; border-color: var(--border-color);">
                </div>
                <button type="submit" class="btn btn-outline-primary ms-2">Cari</button>
            </form>

            @if(!$isPdf)
                <a href="{{ route('owner.laporan.stok.download') }}" class="btn btn-outline-danger">
                    <i class="bi bi-file-earmark-pdf me-1"></i> Unduh PDF
                </a>
            @endif
        </div>
    </div>

    <div class="table-card">
        <div class="table-responsive">
            <table class="table align-middle mb-0 text-center">
                <thead>
                    <tr>
                        <th style="width: 110px;">Kode Produk</th>
                        <th class="text-start">Nama Produk</th>
                        <th style="width: 100px;">ID Penitip</th>
                        <th class="text-start">Nama Penitip</th>
                        <th class="text-center">Tanggal Masuk</th>
                        <th class="text-center">Perpanjangan</th>
                        <th style="width: 90px;">Hunter</th>
                        <th class="text-start">Nama Hunter</th>
                        <th class="text-end">Harga Jual</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stokItems as $item)
                        <tr>
                            <td class="fw-semibold text-muted font-monospace">
                                {{ strtoupper(substr($item->nama_barang, 0, 1)) . $item->id_barang }}
                            </td>
                            <td class="text-start fw-bold" style="color: var(--text-heading);">{{ $item->nama_barang }}</td>
                            <td class="text-muted font-monospace">T{{ $item->id_penitip }}</td>
                            <td class="text-start text-muted">{{ $item->penitip->nama_penitip ?? '-' }}</td>
                            <td class="text-muted">{{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d/m/Y') }}</td>
                            <td>
                                @if($item->status_perpanjangan)
                                    <span class="badge-status badge-tersedia">Ya</span>
                                @else
                                    <span class="badge bg-light text-muted border">Tidak</span>
                                @endif
                            </td>
                            <td class="text-muted font-monospace">{{ $item->id_hunter ? 'P' . $item->id_hunter : '-' }}</td>
                            <td class="text-start text-muted">{{ $item->hunter->nama_pegawai ?? '-' }}</td>
                            <td class="text-end fw-bold text-success">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-5 text-center text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-muted opacity-50"></i>
                                Belum ada data stok barang untuk saat ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if(!$isPdf)
        <div class="d-flex justify-content-center mt-4">
            {{ $stokItems->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
