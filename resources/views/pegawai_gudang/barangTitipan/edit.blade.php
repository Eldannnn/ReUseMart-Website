@extends('pegawai_gudang.dashboard')
@section('isi')

@php
    $pegawai = auth()->guard('pegawai')->user();
@endphp

<div class="container-fluid px-2">
    <div class="row justify-content-center py-3">
        <div class="col-12 col-xl-9">
            <div class="card border-0 shadow-sm" style="border: 1px solid var(--border-color) !important; border-radius: var(--radius-lg);">
                <div class="card-header bg-white border-bottom p-4">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div>
                            <h4 class="fw-bold mb-1" style="color: var(--text-heading);">Edit Barang: {{ $barang->nama_barang }}</h4>
                            <p class="text-muted small mb-0">
                                <strong>Staf Gudang:</strong> P{{ $pegawai->id_pegawai }} - {{ $pegawai->nama_pegawai }}
                            </p>
                        </div>
                        <span class="badge-status badge-tersedia">
                            <i class="bi bi-person-check-fill me-1"></i> T{{ $barang->penitip->id_penitip }} - {{ $barang->penitip->nama_penitip }}
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

                    <form action="{{ route('pegawai_gudang.barangTitipan.update', $barang->id_barang) }}" method="POST" enctype="multipart/form-data" novalidate id="editBarangForm">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="context" value="{{ $context }}">
                        @if($context === 'create')
                            <input type="hidden" name="id_nota" value="{{ $idNota }}">
                        @endif
                        <input type="hidden" name="id_penitip" value="{{ $barang->id_penitip }}">
                        <input type="hidden" name="id_pegawai" value="{{ $barang->id_pegawai }}">

                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Nama Penitip</label>
                                <input type="text" class="form-control bg-light"
                                    value="T{{ $barang->penitip->id_penitip }} - {{ $barang->penitip->nama_penitip }}" readonly>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Petugas QC</label>
                                <input type="text" class="form-control bg-light"
                                    value="P{{ $barang->pegawai->id_pegawai }} - {{ $barang->pegawai->nama_pegawai }}" readonly>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Petugas Hunter</label>
                                <select name="id_hunter" class="form-select">
                                    <option value="">-- Tidak Ada --</option>
                                    @foreach ($pegawaiHunter as $hunter)
                                        <option value="{{ $hunter->id_pegawai }}" {{ $barang->id_hunter == $hunter->id_pegawai ? 'selected' : '' }}>
                                            P{{ $hunter->id_pegawai }} - {{ $hunter->nama_pegawai }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="nama_barang" class="form-label fw-semibold">Nama Barang Titipan</label>
                                <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang', $barang->nama_barang) }}">
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="id_kategori" class="form-label fw-semibold">Kategori Barang</label>
                                <select name="id_kategori" class="form-select">
                                    @foreach ($kategori as $k)
                                        <option value="{{ $k->id_kategori }}" {{ old('id_kategori', $barang->id_kategori) == $k->id_kategori ? 'selected' : '' }}>
                                            {{ $k->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="berat" class="form-label fw-semibold">Berat (kg)</label>
                                <input type="number" step="0.01" name="berat" class="form-control" value="{{ old('berat', $barang->berat) }}">
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="harga_jual" class="form-label fw-semibold">Harga Jual (Rp)</label>
                                <input type="number" name="harga_jual" class="form-control" value="{{ old('harga_jual', $barang->harga_jual) }}">
                            </div>

                            <div class="col-12">
                                <label for="deskripsi" class="form-label fw-semibold">Deskripsi & Kondisi Barang</label>
                                <textarea name="deskripsi" rows="3" class="form-control">{{ old('deskripsi', $barang->deskripsi) }}</textarea>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Garansi</label>
                                <select name="garansi" class="form-select">
                                    <option value="1" {{ old('garansi', $barang->garansi) == '1' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="0" {{ old('garansi', $barang->garansi) == '0' ? 'selected' : '' }}>Tidak Tersedia</option>
                                </select>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="tanggal_garansi" class="form-label fw-semibold">Tanggal Garansi</label>
                                <input type="date" name="tanggal_garansi" class="form-control" value="{{ old('tanggal_garansi', $barang->tanggal_garansi) }}">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Status Barang</label>
                                <input type="text" name="status_barang" class="form-control" value="{{ old('status_barang', $barang->status_barang) }}">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Status Perpanjangan</label>
                                <select name="status_perpanjangan" class="form-select">
                                    <option value="0" {{ old('status_perpanjangan', $barang->status_perpanjangan) == '0' ? 'selected' : '' }}>Tidak</option>
                                    <option value="1" {{ old('status_perpanjangan', $barang->status_perpanjangan) == '1' ? 'selected' : '' }}>Ya</option>
                                </select>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Tanggal Masuk</label>
                                <input type="datetime-local" name="tanggal_masuk" class="form-control bg-light"
                                    value="{{ old('tanggal_masuk', \Carbon\Carbon::parse($barang->tanggal_masuk)->format('Y-m-d\TH:i')) }}" readonly>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Tanggal Akhir (30 Hari)</label>
                                <input type="datetime-local" name="tanggal_akhir" class="form-control bg-light"
                                    value="{{ old('tanggal_akhir', \Carbon\Carbon::parse($barang->tanggal_akhir)->format('Y-m-d\TH:i')) }}" readonly>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Foto Barang Saat Ini</label>
                                <div class="d-flex flex-wrap gap-3 mb-3">
                                    @foreach ($barang->fotoBarang as $foto)
                                        <div class="text-center p-2 border rounded-3 bg-white">
                                            <img src="{{ asset('images/barang/' . $foto->nama_file) }}"
                                                 class="rounded-2"
                                                 style="width: 110px; height: 110px; object-fit: cover;"
                                                 alt="Foto Barang">
                                        </div>
                                    @endforeach
                                </div>

                                <label class="form-label fw-semibold">Tambah Foto Baru (Opsional)</label>
                                <input type="file" name="foto_barang[]" class="form-control" id="inputFotoBaru" multiple>
                                <div id="previewFotoBaru" class="d-flex flex-wrap gap-2 mt-3"></div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            @if($context === 'create')
                                <a href="{{ route('pegawai_gudang.barangTitipan.create', ['id_nota' => $idNota]) }}" class="btn btn-outline-secondary">
                                    Batal
                                </a>
                            @else
                                <a href="{{ route('pegawai_gudang.barangTitipan.showDetail', $barang->id_barang) }}" class="btn btn-outline-secondary">
                                    Batal
                                </a>
                            @endif

                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check2 me-1"></i> Simpan Perubahan Barang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Toast Container --}}
<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1090;">
  <div id="editBarangToast" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body d-flex align-items-center gap-2" id="editBarangToastMsg">
        <i class="bi bi-exclamation-octagon-fill fs-5"></i>
        <span>Pesan validasi</span>
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tglMasuk = document.querySelector('input[name="tanggal_masuk"]');
    const tglAkhir = document.querySelector('input[name="tanggal_akhir"]');

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

    const form = document.getElementById('editBarangForm');
    const inputFoto = document.getElementById('inputFotoBaru');
    const previewDiv = document.getElementById('previewFotoBaru');
    const totalFotoLama = {{ $barang->fotoBarang->count() }};

    function showToastEdit(msg) {
        document.getElementById('editBarangToastMsg').innerHTML = `<i class="bi bi-exclamation-octagon-fill fs-5"></i> <span>${msg}</span>`;
        const toast = new bootstrap.Toast(document.getElementById('editBarangToast'), { delay: 3500 });
        toast.show();
    }

    form.addEventListener('submit', function (e) {
        const totalFotoBaru = inputFoto?.files?.length || 0;
        const totalSetelahSubmit = totalFotoLama + totalFotoBaru;

        if (totalSetelahSubmit < 2) {
            e.preventDefault();
            showToastEdit("Total foto barang minimal 2 gambar.");
        }
    });

    if (inputFoto) {
        inputFoto.addEventListener('change', function () {
            previewDiv.innerHTML = '';
            Array.from(this.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = e => {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('rounded-2', 'border');
                    img.style.width = '100px';
                    img.style.height = '100px';
                    img.style.objectFit = 'cover';
                    previewDiv.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        });
    }
});
</script>
@endpush