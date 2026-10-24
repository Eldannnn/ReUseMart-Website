@extends('owner.dashboard')
@section('isi')
<div class="container-fluid px-2">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1" style="color: var(--text-heading);">Laporan Donasi Barang</h3>
            <p class="text-muted small mb-0">Rekapitulasi riwayat penyaluran donasi barang titipan kepada organisasi mitra periode {{ $year }}</p>
        </div>

        <div class="d-flex flex-wrap align-items-center gap-2">
            <form class="d-flex align-items-center gap-2" method="GET" action="{{ route('owner.laporan.donasi') }}" novalidate>
                <div class="input-group">
                    <span class="input-group-text bg-white" style="border-color: var(--border-color); font-size: 13px;">Tahun</span>
                    <input type="number" name="year" class="form-control" 
                           value="{{ request('year', $year) }}" min="2000" max="2099" style="width: 100px; border-color: var(--border-color);">
                </div>
                <button class="btn btn-outline-primary" type="submit">Filter</button>
            </form>

            <a href="{{ route('owner.laporan.donasi.download', ['year' => request('year', $year)]) }}" class="btn btn-outline-danger">
                <i class="bi bi-file-earmark-pdf me-1"></i> Unduh PDF
            </a>
        </div>
    </div>

    <div class="table-card">
        <div class="table-responsive">
            <table class="table align-middle mb-0 text-center">
                <thead>
                    <tr>
                        <th style="width: 110px;">Kode Produk</th>
                        <th class="text-start">Nama Produk</th>
                        <th class="text-start">Nama Penitip</th>
                        <th class="text-center" style="width: 140px;">Tanggal Donasi</th>
                        <th class="text-start">Organisasi Penerima</th>
                        <th class="text-start">Nama Penerima</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($donations as $row)
                        <tr>
                            <td class="fw-semibold text-muted font-monospace">
                                {{ $row->barang_titipan ? strtoupper(substr($row->barang_titipan->nama_barang, 0, 1)) . $row->barang_titipan->id_barang : '-' }}
                            </td>
                            <td class="text-start fw-bold" style="color: var(--text-heading);">
                                {{ $row->barang_titipan->nama_barang ?? '-' }}
                            </td>
                            <td class="text-start text-muted">{{ $row->barang_titipan->penitip->nama_penitip ?? '-' }}</td>
                            <td class="text-muted">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ \Carbon\Carbon::parse($row->tanggal_donasi)->format('d/m/Y') }}
                            </td>
                            <td class="text-start fw-semibold" style="color: var(--brand-primary-dark);">
                                <i class="bi bi-buildings me-1"></i>
                                {{ $row->request_donasi->organisasi->nama_organisasi ?? '-' }}
                            </td>
                            <td class="text-start text-muted">{{ $row->penerima }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-5 text-center text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-muted opacity-50"></i>
                                Tidak ada data donasi untuk tahun ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="d-flex justify-content-center mt-4">
        {{ $donations->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
