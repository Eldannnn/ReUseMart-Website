@extends('pegawai_gudang.dashboard')
@section('isi')

@php
    $pegawai = auth()->guard('pegawai')->user();
@endphp

<div class="container-fluid px-2">
    <div class="row justify-content-center py-3">
        <div class="col-12 col-xl-10">
            <div class="card border-0 shadow-sm" style="border: 1px solid var(--border-color) !important; border-radius: var(--radius-lg);">
                <div class="card-header bg-white border-bottom p-4">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div>
                            <h4 class="fw-bold mb-1" style="color: var(--text-heading);">Tambah Barang Titipan</h4>
                            <p class="text-muted small mb-0">
                                <strong>Staf Gudang:</strong> P{{ $pegawai->id_pegawai }} - {{ $pegawai->nama_pegawai }} • 
                                <strong>Nota:</strong> #{{ $nota->no_nota }}
                            </p>
                        </div>
                        <span class="badge-status badge-tersedia">
                            <i class="bi bi-person-check-fill me-1"></i> T{{ $penitip->id_penitip }} - {{ $penitip->nama_penitip }}
                        </span>
                    </div>
                </div>

                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm mb-4">
                            <strong class="d-block mb-1">Ada data yang belum sesuai:</strong>
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('pegawai_gudang.barangTitipan.store') }}" method="POST" enctype="multipart/form-data" novalidate id="createBarangForm">
                        @csrf
                        <input type="hidden" name="id_nota" value="{{ $nota->id_nota }}">
                        <input type="hidden" name="id_penitip" value="{{ $penitip->id_penitip }}">

                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label for="no_nota" class="form-label fw-semibold">Nomor Nota Konsinyasi</label>
                                <input type="text" id="no_nota" class="form-control" readonly value="{{ $nota->no_nota }}">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Nama Mitra Penitip</label>
                                <input type="text" class="form-control" value="T{{ $penitip->id_penitip }} - {{ $penitip->nama_penitip }}" readonly>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="id_qc_pegawai" class="form-label fw-semibold">Petugas Quality Control (QC)</label>
                                <input type="hidden" name="id_qc_pegawai" value="{{ old('id_qc_pegawai', $nota->id_qc_pegawai ?? '') }}">
                                <input type="text" class="form-control" readonly
                                    value="{{ 
                                        ($pegawaiQCItem = $pegawaiQc->firstWhere('id_pegawai', old('id_qc_pegawai', $nota->id_qc_pegawai ?? '')))
                                            ? 'P' . $pegawaiQCItem->id_pegawai . ' - ' . $pegawaiQCItem->nama_pegawai 
                                            : '-' 
                                    }}">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Petugas Hunter</label>
                                <select name="id_hunter" class="form-select">
                                    <option value="">-- Tidak Ada Petugas Hunter --</option>
                                    @foreach ($pegawaiHunter as $hunter)
                                        <option value="{{ $hunter->id_pegawai }}">P{{ $hunter->id_pegawai }} - {{ $hunter->nama_pegawai }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="nama_barang" class="form-label fw-semibold">Nama Barang Titipan</label>
                                <input type="text" name="nama_barang" class="form-control" placeholder="Contoh: Kemeja Flanel Vintage" value="{{ old('nama_barang') }}">
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="id_kategori" class="form-label fw-semibold">Kategori Barang</label>
                                <select name="id_kategori" class="form-select">
                                    <option value="" disabled selected>-- Pilih Kategori --</option>
                                    @foreach ($kategori as $k)
                                        <option value="{{ $k->id_kategori }}" {{ old('id_kategori') == $k->id_kategori ? 'selected' : '' }}>
                                            {{ $k->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="berat" class="form-label fw-semibold">Estimasi Berat (kg)</label>
                                <input type="number" step="0.01" name="berat" class="form-control" placeholder="Contoh: 1.25" value="{{ old('berat') }}">
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="harga_jual" class="form-label fw-semibold">Harga Jual Yang Ditetapkan (Rp)</label>
                                <input type="number" name="harga_jual" class="form-control" placeholder="Contoh: 85000" value="{{ old('harga_jual') }}">
                            </div>

                            <div class="col-12">
                                <label for="deskripsi" class="form-label fw-semibold">Deskripsi & Kondisi Fisik Barang</label>
                                <textarea name="deskripsi" rows="3" class="form-control" placeholder="Tuliskan kelengkapan, minus, atau kondisi detail produk...">{{ old('deskripsi') }}</textarea>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Garansi Pembeli</label>
                                <select name="garansi" class="form-select">
                                    <option value="1">Tersedia Garansi</option>
                                    <option value="0">Tidak Ada Garansi</option>
                                </select>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="tanggal_garansi" class="form-label fw-semibold">Batas Masa Garansi</label>
                                <input type="date" name="tanggal_garansi" class="form-control" value="{{ old('tanggal_garansi') }}">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Status Awal Barang</label>
                                <input type="text" name="status_barang" class="form-control" value="{{ old('status_barang', 'Tersedia') }}">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Opsi Perpanjangan Otomatis</label>
                                <select name="status_perpanjangan" class="form-select">
                                    <option value="0">Tidak (Hanya 30 Hari)</option>
                                    <option value="1">Ya (Diperpanjang jika belum laku)</option>
                                </select>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Waktu Masuk Titipan</label>
                                <input type="datetime-local" id="tanggal_masuk" name="tanggal_masuk" class="form-control bg-light"
                                    value="{{ old('tanggal_masuk', now()->format('Y-m-d\TH:i')) }}" readonly>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Batas Akhir Titipan (30 Hari)</label>
                                <input type="datetime-local" id="tanggal_akhir" name="tanggal_akhir" class="form-control bg-light"
                                    value="{{ old('tanggal_akhir', now()->addDays(30)->format('Y-m-d\TH:i')) }}" readonly>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Unggah Foto Barang (Minimal 2 Foto)</label>
                                <input type="file" name="foto_barang[]" class="form-control" id="foto_barang" multiple>
                                <small class="text-muted">Pilih minimal 2 sudut foto (.jpg, .jpeg, .png) untuk verifikasi detail pembeli.</small>

                                <div id="preview-container" class="d-flex flex-wrap gap-2 mt-3"></div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <button type="submit" name="action" value="add" class="btn btn-primary px-4">
                                <i class="bi bi-plus-circle me-1"></i> Tambahkan Barang ke Nota
                            </button>
                        </div>
                    </form>

                    {{-- Daftar Barang dalam Nota Ini --}}
                    <div class="mt-5 pt-3 border-top">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="fw-bold mb-0" style="color: var(--text-heading);">
                                <i class="bi bi-box-seam me-2" style="color: var(--brand-primary);"></i>
                                Daftar Barang dalam Nota #{{ $nota->no_nota }}
                            </h5>
                            <span class="badge bg-light text-muted border">{{ $barangNota->count() }} item</span>
                        </div>

                        <div class="table-card">
                            <div class="table-responsive">
                                <table class="table align-middle mb-0 text-center">
                                    <thead>
                                        <tr>
                                            <th style="width: 120px;">Kode Barang</th>
                                            <th class="text-start">Nama Barang</th>
                                            <th class="text-center" style="width: 140px;">Status</th>
                                            <th class="text-center" style="width: 100px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($barangNota as $barang)
                                        <tr>
                                            <td class="fw-semibold text-muted font-monospace">
                                                {{ strtoupper(substr($barang->nama_barang, 0, 1)) . $barang->id_barang }}
                                            </td>
                                            <td class="text-start fw-bold" style="color: var(--text-heading);">{{ $barang->nama_barang }}</td>
                                            <td>
                                                <span class="badge-status badge-tersedia">
                                                    {{ $barang->status_barang }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('pegawai_gudang.barangTitipan.edit', [
                                                        'id'      => $barang->id_barang,
                                                        'context' => 'create',
                                                        'id_nota' => $nota->id_nota
                                                    ]) }}" class="btn btn-sm btn-outline-primary" title="Edit Item">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="py-4 text-center text-muted">Belum ada barang yang ditambahkan ke nota ini.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            {{ $barangNota->links('pagination::bootstrap-5') }}
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                            <a href="{{ route('pegawai_gudang.notaPenitipan.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Penitipan
                            </a>

                            <form action="{{ route('pegawai_gudang.barangTitipan.store') }}" method="POST" novalidate>
                                @csrf
                                <input type="hidden" name="id_nota" value="{{ $nota->id_nota }}">
                                <input type="hidden" name="action" value="finish">

                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-check2-circle me-1"></i> Selesai & Simpan Nota
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tglMasuk = document.getElementById('tanggal_masuk');
        const tglAkhir = document.getElementById('tanggal_akhir');

        function updateTanggalAkhir() {
            if (!tglMasuk || !tglAkhir) return;

            const masuk = new Date(tglMasuk.value);

            if (!isNaN(masuk.getTime())) {
                const akhir = new Date(masuk);
                akhir.setDate(masuk.getDate() + 30);
                akhir.setHours(masuk.getHours(), masuk.getMinutes(), 0, 0);

                const pad = n => n.toString().padStart(2, '0');
                const formatted = `${akhir.getFullYear()}-${pad(akhir.getMonth() + 1)}-${pad(akhir.getDate())}T${pad(akhir.getHours())}:${pad(akhir.getMinutes())}`;
                tglAkhir.value = formatted;
            }
        }

        updateTanggalAkhir();
        tglMasuk.addEventListener('input', updateTanggalAkhir);
        tglMasuk.addEventListener('change', updateTanggalAkhir);

        const inputFile = document.getElementById('foto_barang');
        const previewContainer = document.getElementById('preview-container');

        inputFile.addEventListener('change', function (event) {
            previewContainer.innerHTML = '';
            const files = event.target.files;
            if (files) {
                Array.from(files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.alt = file.name;
                        img.classList.add('img-thumbnail', 'rounded-3');
                        img.style.width = '120px';
                        img.style.height = '120px';
                        img.style.objectFit = 'cover';
                        previewContainer.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                });
            }
        });
    });
</script>
@endpush
