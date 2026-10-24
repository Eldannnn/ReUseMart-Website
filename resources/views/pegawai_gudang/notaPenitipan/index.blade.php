@extends('pegawai_gudang.dashboard')

@section('isi')
<div class="container-fluid px-2">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1" style="color: var(--text-heading);">Daftar Nota Konsinyasi Penitipan</h3>
            <p class="text-muted small mb-0">Riwayat penerimaan nota titip barang baru dan pencetakan dokumen serah terima gudang</p>
        </div>

        <div class="d-flex flex-wrap align-items-center gap-2">
            <form class="d-flex align-items-center gap-2" action="{{ route('pegawai_gudang.notaPenitipan.index') }}" method="GET" novalidate>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0" style="border-color: var(--border-color);">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input class="form-control border-start-0 ps-0" 
                        type="search" 
                        name="search" 
                        placeholder="Cari nomor nota / penitip..." 
                        value="{{ request('search') }}"
                        style="width: 220px; border-color: var(--border-color);">
                </div>
                <input class="form-control" type="date" name="date" value="{{ request('date') }}" style="width: 150px;">
                <button class="btn btn-outline-primary" type="submit">Filter</button>
            </form>

            <a href="{{ route('pegawai_gudang.barangTitipan.createBlank') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Buat Penitipan Baru
            </a>
        </div>
    </div>

    {{-- Flash message --}}
    @if (session('success'))
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
                        <th style="width: 130px;">No Nota</th>
                        <th class="text-start">Nama Mitra Penitip</th>
                        <th class="text-center" style="width: 200px;">Waktu Penitipan</th>
                        <th class="text-center" style="width: 140px;">Jumlah Barang</th>
                        <th class="text-center" style="width: 160px;">Dokumen & Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notas as $nota)
                    <tr>
                        <td class="fw-semibold text-muted font-monospace">
                            {{ $nota->no_nota }}
                        </td>
                        <td class="text-start fw-bold" style="color: var(--text-heading);">
                            <i class="bi bi-person me-1 text-muted"></i>
                            T{{ $nota->penitip->id_penitip }} – {{ $nota->penitip->nama_penitip }}
                        </td>
                        <td class="text-muted">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ \Carbon\Carbon::parse($nota->tanggal_penitipan)->format('d/m/Y H:i') }}
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border px-3 py-1 font-monospace">
                                {{ $nota->barang_titipan_count }} item
                            </span>
                        </td>
                        <td>
                            <div class="d-inline-flex gap-2">
                                <a href="{{ route('pegawai_gudang.notaPenitipan.show', $nota->id_nota) }}"
                                   class="btn btn-sm btn-outline-primary" title="Lihat Rincian Nota">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                                <a href="{{ route('pegawai_gudang.notaPenitipan.print', $nota->id_nota) }}"
                                   class="btn btn-sm btn-outline-danger" title="Cetak Nota PDF">
                                    <i class="bi bi-printer"></i> PDF
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-5 text-center text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2 text-muted opacity-50"></i>
                            Tidak ada data transaksi penitipan yang ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $notas->appends(['search'=>request('search'), 'date'=>request('date')])->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection