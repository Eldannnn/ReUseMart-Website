@extends('pegawai_gudang.dashboard')

@section('isi')

<div class="container-fluid px-2">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1" style="color: var(--text-heading);">Daftar Barang Pengembalian</h3>
            <p class="text-muted small mb-0">Verifikasi fisik pengembalian barang titipan yang tidak terjual kepada mitra penitip</p>
        </div>

        <div class="d-flex flex-wrap align-items-center gap-2">
            <form class="d-flex align-items-center gap-2" action="{{ route('pegawai_gudang.barang.pengembalian') }}" method="GET" novalidate>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0" style="border-color: var(--border-color);">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input class="form-control border-start-0 ps-0" 
                        type="search" 
                        name="search" 
                        placeholder="Cari nama / penitip..." 
                        value="{{ request('search') }}"
                        style="width: 200px; border-color: var(--border-color);">
                </div>
                <input class="form-control" type="date" name="date" value="{{ request('date') }}" style="width: 150px;">
                <button class="btn btn-outline-primary" type="submit">Filter</button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm mb-4">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="table-card">
        <div class="table-responsive">
            <table class="table align-middle mb-0 text-center">
                <thead>
                    <tr>
                        <th style="width: 110px;">Kode Barang</th>
                        <th class="text-start">Nama Barang</th>
                        <th class="text-start">Mitra Penitip</th>
                        <th class="text-center">Tanggal Masuk</th>
                        <th class="text-center">Tanggal Akhir</th>
                        <th class="text-end">Harga Jual</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 180px;">Aksi</th>
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
                                <i class="bi bi-person me-1"></i>
                                {{ $item->penitip->nama_penitip ?? '-' }}
                            </td>
                            <td class="text-muted">
                                {{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d/m/Y') }}
                            </td>
                            <td class="text-muted">
                                {{ $item->tanggal_akhir ? \Carbon\Carbon::parse($item->tanggal_akhir)->format('d/m/Y') : '-' }}
                            </td>
                            <td class="text-end fw-semibold">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge-status badge-didonasikan">
                                    {{ $item->status_barang }}
                                </span>
                            </td>
                            <td>
                                <button type="button" 
                                        class="btn btn-sm btn-primary btn-konfirmasi-pengembalian"
                                        data-bs-toggle="modal"
                                        data-bs-target="#konfirmasiPengembalianModal"
                                        data-action="{{ route('pegawai_gudang.barang.konfirmasiPengembalian', ['id_barang' => $item->id_barang]) }}"
                                        data-nama="{{ $item->nama_barang }}"
                                        data-penitip="{{ $item->penitip->nama_penitip ?? 'Penitip' }}">
                                    <i class="bi bi-check2 me-1"></i> Konfirmasi Selesai
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-5 text-center text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-muted opacity-50"></i>
                                Tidak ada barang dalam proses pengembalian saat ini.
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

{{-- Modal Konfirmasi Pengembalian Barang --}}
<div class="modal fade" id="konfirmasiPengembalianModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="konfirmasiPengembalianForm" method="POST" novalidate>
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title">Konfirmasi Serah Terima Pengembalian</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4 text-center">
          <div class="text-success mb-3">
            <i class="bi bi-box-arrow-left fs-1" style="color: var(--brand-primary);"></i>
          </div>
          <h5 class="fw-bold mb-2">Konfirmasi Pengembalian Barang?</h5>
          <p class="text-muted small mb-0">
            Barang <strong id="modalBarangNama">-</strong> akan dikonfirmasi telah dikembalikan kepada penitip <strong id="modalPenitipNama">-</strong>.
          </p>
        </div>
        <div class="modal-footer bg-light justify-content-center">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-check2 me-1"></i> Ya, Konfirmasi Pengembalian
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const confirmButtons = document.querySelectorAll('.btn-konfirmasi-pengembalian');
    const form = document.getElementById('konfirmasiPengembalianForm');
    const barangNama = document.getElementById('modalBarangNama');
    const penitipNama = document.getElementById('modalPenitipNama');

    confirmButtons.forEach(btn => {
        btn.addEventListener('click', function(){
            form.action = this.dataset.action;
            barangNama.textContent = this.dataset.nama;
            penitipNama.textContent = this.dataset.penitip;
        });
    });
});
</script>
@endsection
