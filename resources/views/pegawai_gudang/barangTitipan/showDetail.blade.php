@extends('pegawai_gudang.dashboard')

@section('isi')

@if (session('success'))
    <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="container-fluid px-2">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1" style="color: var(--text-heading);">Detail Barang Titipan</h3>
            <p class="text-muted small mb-0">Informasi spesifikasi lengkap, garansi, status konsinyasi, dan galeri foto barang</p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('pegawai_gudang.notaPenitipan.show', $barang->nota->id_nota) }}" class="btn btn-outline-secondary">
                <i class="bi bi-clipboard me-1"></i> Detail Nota
            </a>
            @php
                $isAvailable = strtolower($barang->status_barang) === 'tersedia';
            @endphp
            @if($isAvailable)
                <a href="{{ route('pegawai_gudang.barangTitipan.edit', ['id' => $barang->id_barang, 'context' => 'detail']) }}" class="btn btn-primary">
                    <i class="bi bi-pencil-square me-1"></i> Edit Barang
                </a>
            @endif
        </div>
    </div>

    <div class="row g-4 mb-4">
        {{-- Kolom Kiri: Detail Spesifikasi --}}
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm p-4 mb-4" style="border: 1px solid var(--border-color) !important; border-radius: var(--radius-md);">
                <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom">
                    <div>
                        <span class="badge bg-light text-muted border font-monospace me-2">
                            {{ strtoupper(substr($barang->nama_barang, 0, 1)) . $barang->id_barang }}
                        </span>
                        <h4 class="fw-bold d-inline align-middle mb-0" style="color: var(--text-heading);">
                            {{ $barang->nama_barang }}
                        </h4>
                    </div>
                    @php
                        $statusLower = strtolower($barang->status_barang);
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
                        <span class="badge bg-light text-muted border">{{ $barang->status_barang }}</span>
                    @endif
                </div>

                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <div class="p-3 rounded-3 bg-light">
                            <small class="text-muted d-block mb-1">Nomor Nota Konsinyasi</small>
                            <span class="fw-bold text-dark">{{ $nota->no_nota }}</span>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="p-3 rounded-3 bg-light">
                            <small class="text-muted d-block mb-1">Kategori Produk</small>
                            <span class="fw-bold text-dark">{{ $barang->kategori->nama_kategori ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="p-3 rounded-3 bg-light">
                            <small class="text-muted d-block mb-1">Harga Jual Ditetapkan</small>
                            <span class="fs-5 fw-extrabold text-success">Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="p-3 rounded-3 bg-light">
                            <small class="text-muted d-block mb-1">Estimasi Berat</small>
                            <span class="fw-bold text-dark">{{ $barang->berat }} kg</span>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="p-3 rounded-3 bg-light">
                            <small class="text-muted d-block mb-1">Mitra Penitip</small>
                            <span class="fw-bold text-dark">T{{ $barang->penitip->id_penitip }} - {{ $barang->penitip->nama_penitip ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="p-3 rounded-3 bg-light">
                            <small class="text-muted d-block mb-1">Petugas QC Penerima</small>
                            <span class="fw-bold text-dark">P{{ $barang->pegawai->id_pegawai ?? '-' }} - {{ $barang->pegawai->nama_pegawai ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="p-3 rounded-3 bg-light">
                            <small class="text-muted d-block mb-1">Tanggal Masuk</small>
                            <span class="fw-semibold text-dark">{{ \Carbon\Carbon::parse($barang->tanggal_masuk)->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="p-3 rounded-3 bg-light">
                            <small class="text-muted d-block mb-1">Batas Akhir Konsinyasi</small>
                            <span class="fw-semibold text-dark">{{ \Carbon\Carbon::parse($barang->tanggal_akhir)->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="p-3 rounded-3 bg-light">
                            <small class="text-muted d-block mb-1">Status Garansi</small>
                            <span class="fw-semibold text-dark">
                                @if($barang->garansi && $barang->tanggal_garansi)
                                    <i class="bi bi-shield-check text-success me-1"></i> Garansi ON s.d {{ \Carbon\Carbon::parse($barang->tanggal_garansi)->format('d/m/Y') }}
                                @else
                                    <span class="text-muted">Tidak Ada Garansi</span>
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="p-3 rounded-3 bg-light">
                            <small class="text-muted d-block mb-1">Petugas Hunter</small>
                            <span class="fw-semibold text-dark">
                                {{ $barang->hunter ? 'P' . $barang->hunter->id_pegawai . ' - ' . $barang->hunter->nama_pegawai : 'Tidak Ada' }}
                            </span>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="p-3 rounded-3 bg-light">
                            <small class="text-muted d-block mb-1">Deskripsi & Kondisi Produk</small>
                            <p class="mb-0 text-dark">{{ $barang->deskripsi ?: 'Tidak ada catatan deskripsi tambahan.' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Galeri Foto Barang --}}
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm p-4 h-100" style="border: 1px solid var(--border-color) !important; border-radius: var(--radius-md);">
                <h6 class="fw-bold mb-3" style="color: var(--text-heading);">
                    <i class="bi bi-images me-2" style="color: var(--brand-primary);"></i>
                    Foto Dokumentasi QC
                </h6>
                <div class="d-flex flex-column gap-3">
                    @forelse ($barang->fotoBarang as $index => $foto)
                        <div class="p-2 border rounded-3 bg-white text-center">
                            <img src="{{ asset('images/barang/' . $foto->nama_file) }}"
                                class="rounded-2 img-fluid"
                                style="max-height: 180px; width: 100%; object-fit: contain;"
                                alt="Foto {{ $index + 1 }}">
                            <small class="text-muted d-block mt-2 font-monospace">Foto {{ $index + 1 }}</small>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-image fs-1 d-block mb-2 text-muted opacity-50"></i>
                            Belum ada foto terlampir.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-start pb-4">
        <a href="{{ route('pegawai_gudang.barangTitipan.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Barang
        </a>
    </div>
</div>
@endsection
