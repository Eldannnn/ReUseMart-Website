@extends('owner.dashboard')
@section('isi')
<div class="container-fluid px-2">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1" style="color: var(--text-heading);">Laporan Request Donasi (Menunggu)</h3>
            <p class="text-muted small mb-0">Daftar permintaan kebutuhan barang dari organisasi mitra yang berstatus menunggu alokasi</p>
        </div>

        <a href="{{ route('owner.laporan.requestdonasi.download', ['year' => request('year')]) }}" class="btn btn-outline-danger">
            <i class="bi bi-file-earmark-pdf me-1"></i> Unduh PDF
        </a>
    </div>

    <div class="table-card">
        <div class="table-responsive">
            <table class="table align-middle mb-0 text-center">
                <thead>
                    <tr>
                        <th style="width: 120px;">ID Request</th>
                        <th class="text-start">Nama Organisasi</th>
                        <th class="text-start">Alamat Organisasi</th>
                        <th class="text-start">Barang yang Dibutuhkan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $row)
                        <tr>
                            <td class="fw-semibold text-muted font-monospace">{{ 'ORG' . $row->id_request }}</td>
                            <td class="text-start fw-bold" style="color: var(--text-heading);">
                                <i class="bi bi-buildings me-2" style="color: var(--brand-primary);"></i>
                                {{ optional($row->organisasi)->nama_organisasi ?? '-' }}
                            </td>
                            <td class="text-start text-muted">{{ optional($row->organisasi)->alamat ?? '-' }}</td>
                            <td class="text-start fw-semibold text-dark">{{ $row->barang_dibutuhkan }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-5 text-center text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-muted opacity-50"></i>
                                Tidak ada data permohonan donasi yang menunggu untuk saat ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $requests->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
