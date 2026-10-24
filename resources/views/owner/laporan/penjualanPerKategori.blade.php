@extends('owner.dashboard')

@section('isi')
<div class="container-fluid px-2">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1" style="color: var(--text-heading);">Laporan Penjualan Per Kategori</h3>
            <p class="text-muted small mb-0">Perbandingan jumlah produk laku terjual dan gagal terjual menurut kategori tahun {{ $tahun }}</p>
        </div>

        <div class="d-flex flex-wrap align-items-center gap-2">
            <form method="GET" action="{{ route('owner.laporan.penjualanPerKategori') }}" class="d-flex align-items-center gap-2" novalidate>
                <div class="input-group">
                    <span class="input-group-text bg-white" style="border-color: var(--border-color); font-size: 13px;">Tahun</span>
                    <select id="year-select" name="tahun" class="form-select" onchange="this.form.submit()" style="border-color: var(--border-color);">
                        @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                            <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endfor
                    </select>
                </div>
            </form>

            <a href="{{ route('owner.laporan.penjualanPerKategori-pdf', ['tahun' => $tahun]) }}" class="btn btn-outline-danger">
                <i class="bi bi-file-earmark-pdf me-1"></i> Unduh PDF
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-card">
        <div class="p-3 border-bottom d-flex align-items-center justify-content-between">
            <h6 class="fw-bold mb-0" style="color: var(--text-heading);">
                <i class="bi bi-grid-fill me-2" style="color: var(--brand-primary);"></i>
                Rekap Kategori Produk Tahun {{ $tahun }}
            </h6>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0 text-center">
                <thead>
                    <tr>
                        <th class="text-start">Kategori Barang</th>
                        <th class="text-center" style="width: 240px;">Jumlah Item Terjual</th>
                        <th class="text-center" style="width: 240px;">Jumlah Item Gagal Terjual</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalTerjual = 0;
                        $totalGagal = 0;
                    @endphp
                    @forelse($laporan as $item)
                        <tr>
                            <td class="text-start fw-bold" style="color: var(--text-heading);">
                                <i class="bi bi-tag-fill me-2" style="color: var(--brand-primary);"></i>
                                {{ $item->nama_kategori }}
                            </td>
                            <td>
                                <span class="badge-status badge-tersedia">
                                    <i class="bi bi-check-circle-fill me-1"></i> {{ $item->jumlah_terjual }} item
                                </span>
                            </td>
                            <td>
                                <span class="badge-status badge-terjual">
                                    <i class="bi bi-x-circle-fill me-1"></i> {{ $item->jumlah_gagal + $item->jumlah_donasi }} item
                                </span>
                            </td>
                        </tr>
                        @php
                            $totalTerjual += $item->jumlah_terjual;
                            $totalGagal += ($item->jumlah_gagal + $item->jumlah_donasi);
                        @endphp
                    @empty
                        <tr>
                            <td colspan="3" class="py-5 text-center text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-muted opacity-50"></i>
                                Tidak ada data penjualan untuk tahun ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="fw-bold bg-light">
                        <td class="text-start">Total Seluruh Kategori</td>
                        <td class="text-center text-success">{{ $totalTerjual }} item</td>
                        <td class="text-center text-danger">{{ $totalGagal }} item</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
