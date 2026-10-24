@extends('pegawai_gudang.dashboard')

@section('isi')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2 fs-5"></i>
        <div>{{ session('success') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="container-fluid px-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1" style="color: var(--brand-dark);">Daftar Nota Transaksi</h4>
            <p class="text-muted small mb-0">Cetak dan tinjau dokumen nota penjualan transaksi pelanggan</p>
        </div>
    </div>

    <!-- Toolbar Pencarian & Filter -->
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-body p-3">
            <form class="row g-2 align-items-center" action="{{ route('pegawai_gudang.cetakNotaIndex') }}" method="GET" novalidate>
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                        <input class="form-control border-start-0" 
                               type="text" 
                               name="search" 
                               placeholder="Cari transaksi atau nama pembeli..." 
                               value="{{ request('search') }}"
                               aria-label="Cari transaksi">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted">
                            <i class="bi bi-calendar-date"></i>
                        </span>
                        <input class="form-control border-start-0" type="date" name="date" value="{{ request('date') }}">
                    </div>
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button class="btn btn-brand flex-grow-1" type="submit">
                        <i class="bi bi-funnel me-1"></i> Filter
                    </button>
                    @if(request('search') || request('date'))
                        <a href="{{ route('pegawai_gudang.cetakNotaIndex') }}" class="btn btn-outline-secondary" title="Reset Filter">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Daftar Nota -->
    <div class="table-card">
        <div class="table-responsive">
            <table class="reusemart-table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 140px;">No. Transaksi</th>
                        <th>Pembeli</th>
                        <th>Tanggal Transaksi</th>
                        <th>Total Pembayaran</th>
                        <th>Pengiriman</th>
                        <th class="text-center">Status</th>
                        <th>Kurir</th>
                        <th class="text-center" style="width: 130px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $hasRows = false; @endphp
                    @foreach ($transaksi as $item)
                        @php
                            $jadwalPengiriman = $item->penjadwalan->firstWhere('jenis_jadwal', 'Pengiriman') 
                                                ?? $item->penjadwalan->firstWhere('jenis_jadwal', 'Diambil');
                            $statusJadwal = $jadwalPengiriman && $jadwalPengiriman->status_jadwal ? strtolower($jadwalPengiriman->status_jadwal) : '';
                        @endphp
                        @if($statusJadwal !== 'diproses')
                            @php $hasRows = true; @endphp
                            <tr>
                                <td class="text-center">
                                    <span class="fw-bold font-monospace" style="color: var(--brand-primary);">{{ $item->nomor_transaksi }}</span>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $item->pembeli->nama_pembeli ?? '-' }}</div>
                                    <small class="text-muted">{{ $item->pembeli->email ?? '' }}</small>
                                </td>
                                <td>
                                    @if ($item->tanggal_transaksi)
                                        <div class="small fw-medium">{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d/m/Y') }}</div>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('H:i') }} WIB</small>
                                    @else
                                        <em class="text-muted small">-</em>
                                    @endif
                                </td>
                                <td>
                                    <span class="fw-bold text-dark">Rp{{ number_format($item->total_pembayaran, 0, ',', '.') }}</span>
                                </td>
                                <td>
                                    @php
                                        $jenisJadwal = $jadwalPengiriman ? $jadwalPengiriman->jenis_jadwal : '-';
                                    @endphp
                                    <span class="badge {{ $jenisJadwal === 'Pengiriman' ? 'bg-primary-subtle text-primary border border-primary-subtle' : 'bg-secondary-subtle text-secondary border border-secondary-subtle' }} px-2 py-1 rounded-pill">
                                        <i class="bi {{ $jenisJadwal === 'Pengiriman' ? 'bi-truck' : 'bi-shop' }} me-1"></i>
                                        {{ $jenisJadwal }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @php
                                        $st = strtolower($item->status_transaksi);
                                        $badgeClass = 'badge-diproses';
                                        if (str_contains($st, 'selesai') || str_contains($st, 'lunas')) {
                                            $badgeClass = 'badge-sukses';
                                        } elseif (str_contains($st, 'batal') || str_contains($st, 'tolak')) {
                                            $badgeClass = 'badge-batal';
                                        }
                                    @endphp
                                    <span class="badge-status {{ $badgeClass }}">
                                        {{ $item->status_transaksi }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $namaKurir = $jadwalPengiriman && $jadwalPengiriman->pengiriman && $jadwalPengiriman->pengiriman->id_pegawai
                                            ? optional($jadwalPengiriman->pengiriman->pegawai)->nama_pegawai
                                            : '-';
                                    @endphp
                                    <span class="small {{ $namaKurir !== '-' ? 'fw-medium text-dark' : 'text-muted' }}">{{ $namaKurir }}</span>
                                </td>
                                <td class="text-center">
                                    @if(strtolower($item->status_transaksi) !== 'menunggu pembayaran' && strtolower($item->status_transaksi) !== 'batal')
                                        <a href="{{ route('pegawai_gudang.cetakNotaPdf', ['id' => $item->id_transaksi]) }}"
                                           target="_blank"
                                           class="btn btn-sm btn-outline-brand d-inline-flex align-items-center gap-1 shadow-sm"
                                           title="Cetak Nota PDF">
                                            <i class="bi bi-printer"></i>
                                            <span>PDF</span>
                                        </a>
                                    @else
                                        <span class="text-muted small fst-italic">Belum siap</span>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endforeach

                    @if(!$hasRows)
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="bi bi-receipt-cutoff fs-1 text-muted d-block mb-2"></i>
                                <span class="text-muted">Tidak ada transaksi yang dapat dicetak notanya.</span>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $transaksi->links('pagination::bootstrap-5') }}
    </div>
</div>

@endsection
