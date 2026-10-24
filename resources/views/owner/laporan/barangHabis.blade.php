@extends('owner.dashboard')

@section('isi')
<div class="container-fluid px-2">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1" style="color: var(--text-heading);">Laporan Barang Habis Masa Penitipan</h3>
            <p class="text-muted small mb-0">Daftar barang titipan yang telah melewati masa konsinyasi 30 hari dan batas tenggang pengambilan</p>
        </div>

        <a href="{{ route('owner.laporan.barangHabisPdf', ['tahun' => $tahun]) }}" class="btn btn-outline-danger">
            <i class="bi bi-file-earmark-pdf me-1"></i> Unduh PDF
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

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
                        <th class="text-center">Tanggal Akhir</th>
                        <th class="text-center">Batas Ambil (+7 Hari)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporan as $item)
                        <tr>
                            <td class="fw-semibold text-muted font-monospace">
                                {{ strtoupper(substr($item->nama_barang, 0, 1)) . $item->id_barang }}
                            </td>
                            <td class="text-start fw-bold" style="color: var(--text-heading);">{{ $item->nama_barang }}</td>
                            <td class="text-muted font-monospace">T{{ $item->id_penitip }}</td>
                            <td class="text-start text-muted">{{ optional($item->penitip)->nama_penitip ?? '-' }}</td>
                            <td class="text-muted">{{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d/m/Y') }}</td>
                            <td class="text-muted">{{ \Carbon\Carbon::parse($item->tanggal_akhir)->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge-status badge-terjual">
                                    <i class="bi bi-clock-history me-1"></i>
                                    {{ \Carbon\Carbon::parse($item->tanggal_akhir)->addDays(7)->format('d/m/Y') }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-5 text-center text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-muted opacity-50"></i>
                                Tidak ada data barang yang masa penitipannya sudah habis.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $laporan->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
