@extends('pegawai_gudang.dashboard')
@section('isi')
<div class="container-fluid px-2">
    <div class="row justify-content-center py-4">
        <div class="col-12 col-md-8 col-lg-7">
            <div class="card border-0 shadow-sm" style="border: 1px solid var(--border-color) !important; border-radius: var(--radius-lg);">
                <div class="card-header bg-white border-bottom p-4">
                    <div class="d-flex align-items-center gap-3">
                        <a href="{{ route('pegawai_gudang.barangTitipan.cariPenitip') }}" class="btn btn-sm btn-outline-secondary rounded-circle" style="width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        <div>
                            <h4 class="fw-bold mb-0" style="color: var(--text-heading);">Buat Nota Penitipan Baru</h4>
                            <p class="text-muted small mb-0">Langkah 1: Konfirmasi mitra penitip, pilih petugas QC, dan tentukan masa konsinyasi</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm mb-4">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-sm mb-4">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('pegawai_gudang.notaPenitipan.store') }}" method="POST" novalidate id="createNotaForm">
                        @csrf

                        {{-- Penitip --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Mitra Penitip Terpilih</label>
                            <input type="hidden" name="id_penitip" value="{{ $terpilih->id_penitip }}">
                            <div class="p-3 rounded-3 bg-light border d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="badge bg-white text-muted border font-monospace me-2">T{{ $terpilih->id_penitip }}</span>
                                    <strong class="text-dark">{{ $terpilih->nama_penitip }}</strong>
                                </div>
                                <span class="badge-status badge-tersedia">Aktif</span>
                            </div>
                        </div>

                        {{-- Pegawai QC --}}
                        <div class="mb-3">
                            <label for="id_qc_pegawai" class="form-label fw-semibold">Petugas Quality Control (QC)</label>
                            <select name="id_qc_pegawai" id="id_qc_pegawai" class="form-select">
                                <option value="" disabled selected>-- Pilih Petugas QC Pemeriksa --</option>
                                @foreach($pegawaiQc as $peg)
                                    <option value="{{ $peg->id_pegawai }}" {{ old('id_qc_pegawai') == $peg->id_pegawai ? 'selected' : '' }}>
                                        P{{ $peg->id_pegawai }} - {{ $peg->nama_pegawai }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_qc_pegawai')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3">
                            {{-- Tanggal Penitipan --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Waktu Masuk Penitipan</label>
                                <input type="datetime-local" id="tanggal_penitipan" name="tanggal_penitipan" class="form-control"
                                    value="{{ old('tanggal_penitipan', now()->format('Y-m-d\TH:i')) }}">
                            </div>

                            {{-- Masa Berakhir --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Batas Akhir Masa Titip (+30 Hari)</label>
                                <input type="datetime-local" id="masa_berakhir" name="masa_berakhir" class="form-control bg-light"
                                    value="{{ old('masa_berakhir', now()->addDays(30)->format('Y-m-d\TH:i')) }}" readonly>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('pegawai_gudang.barangTitipan.cariPenitip') }}" class="btn btn-outline-secondary">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                Selanjutnya: Input Barang <i class="bi bi-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tglMasuk = document.getElementById('tanggal_penitipan');
        const tglAkhir = document.getElementById('masa_berakhir');

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
    });
</script>
@endpush
