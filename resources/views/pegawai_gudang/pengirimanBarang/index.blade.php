@extends('pegawai_gudang.dashboard')

@section('isi')

<div class="container-fluid px-2">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1" style="color: var(--text-heading);">Pengiriman & Pengambilan Barang</h3>
            <p class="text-muted small mb-0">Kelola jadwal kurir pengiriman pesanan pembeli atau penyiapan paket pengambilan mandiri</p>
        </div>

        <div class="d-flex flex-wrap align-items-center gap-2">
            <form class="d-flex align-items-center gap-2" action="{{ route('pegawai_gudang.pengiriman.index') }}" method="GET" novalidate>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0" style="border-color: var(--border-color);">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input class="form-control border-start-0 ps-0" 
                        type="search" 
                        name="search" 
                        placeholder="Cari transaksi..." 
                        value="{{ request('search') }}"
                        style="width: 180px; border-color: var(--border-color);">
                </div>

                <input class="form-control" type="date" name="date" value="{{ request('date') }}" style="width: 140px;">

                <select name="status_pengiriman" class="form-select" style="width: 160px;">
                    <option value="" disabled selected>Status Pengiriman</option>
                    <option value="Diterima" {{ request('status_pengiriman') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="Dibatalkan" {{ request('status_pengiriman') == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    <option value="Sampai" {{ request('status_pengiriman') == 'Sampai' ? 'selected' : '' }}>Sampai</option>
                    <option value="Disiapkan" {{ request('status_pengiriman') == 'Disiapkan' ? 'selected' : '' }}>Disiapkan</option>
                    <option value="Diantar" {{ request('status_pengiriman') == 'Diantar' ? 'selected' : '' }}>Diantar</option>
                    <option value="Belum Disiapkan" {{ request('status_pengiriman') == 'Belum Disiapkan' ? 'selected' : '' }}>Belum Disiapkan</option>
                </select>

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
                        <th style="width: 130px;">No Transaksi</th>
                        <th class="text-start">Nama Pembeli</th>
                        <th class="text-center">Tanggal Transaksi</th>
                        <th class="text-center">Tanggal Jadwal</th>
                        <th class="text-center">Metode</th>
                        <th class="text-center">Status Pengiriman</th>
                        <th class="text-center" style="width: 190px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksi as $item)
                        <tr>
                            <td class="fw-semibold text-muted font-monospace">{{ $item->nomor_transaksi }}</td>
                            <td class="text-start fw-bold" style="color: var(--text-heading);">
                                {{ $item->pembeli->nama_pembeli ?? '-' }}
                            </td>
                            <td class="text-muted small">
                                @if ($item->tanggal_transaksi)
                                    <i class="bi bi-calendar3 me-1"></i>
                                    {{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d/m/Y H:i') }}
                                @else
                                    -
                                @endif
                            </td>
                            @php
                                $jadwal = $item->penjadwalan->firstWhere('jenis_jadwal', 'Pengiriman') 
                                    ?? $item->penjadwalan->firstWhere('jenis_jadwal', 'Diambil');
                            @endphp
                            <td class="text-muted small">
                                @if ($jadwal && $jadwal->tanggal_jadwal)
                                    <i class="bi bi-clock me-1"></i>
                                    {{ \Carbon\Carbon::parse($jadwal->tanggal_jadwal)->format('d/m/Y H:i') }}
                                @else
                                    <span class="text-muted fst-italic">Belum ditentukan</span>
                                @endif
                            </td>
                            <td>
                                @if($jadwal && $jadwal->jenis_jadwal === 'Pengiriman')
                                    <span class="badge bg-light text-primary border">
                                        <i class="bi bi-truck me-1"></i> Kurir
                                    </span>
                                @elseif($jadwal && $jadwal->jenis_jadwal === 'Diambil')
                                    <span class="badge bg-light text-dark border">
                                        <i class="bi bi-bag-check me-1"></i> Ambil Mandiri
                                    </span>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                            <td>
                                @if ($jadwal && $jadwal->pengiriman && $jadwal->pengiriman->status_pengiriman)
                                    @php
                                        $status = $jadwal->pengiriman->status_pengiriman;
                                    @endphp
                                    @if($status === 'Diterima' || $status === 'Sampai')
                                        <span class="badge-status badge-tersedia">
                                            <i class="bi bi-check-circle-fill me-1"></i> {{ $status }}
                                        </span>
                                    @elseif($status === 'Dibatalkan')
                                        <span class="badge-status badge-terjual">
                                            <i class="bi bi-x-circle-fill me-1"></i> Dibatalkan
                                        </span>
                                    @elseif($status === 'Disiapkan' || $status === 'Diantar')
                                        <span class="badge-status badge-didonasikan">
                                            <i class="bi bi-hourglass-split me-1"></i> {{ $status }}
                                        </span>
                                    @else
                                        <span class="badge bg-light text-muted border">{{ $status }}</span>
                                    @endif
                                @else
                                    <span class="badge bg-light text-muted border">Belum Disiapkan</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-inline-flex gap-1 align-items-center">
                                    @if (!$jadwal || !$jadwal->tanggal_jadwal)
                                        @if ($jadwal && $jadwal->jenis_jadwal === 'Pengiriman')
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#jadwalModal{{$item->id_transaksi}}">
                                                <i class="bi bi-calendar-plus me-1"></i> Pilih Jadwal
                                            </button>

                                            <div class="modal fade" id="jadwalModal{{$item->id_transaksi}}" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <form action="{{ route('pegawai_gudang.pengiriman.tambahJadwal') }}" method="POST" novalidate>
                                                            @csrf
                                                            <input type="hidden" name="id_transaksi" value="{{ $item->id_transaksi }}">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Pilih Jadwal & Kurir Pengiriman</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body p-4 text-start">
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-semibold">Tanggal & Jam Jadwal</label>
                                                                    <input type="datetime-local" name="tanggal_jadwal" class="form-control" min="{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('Y-m-d') }}T00:00">
                                                                    <small class="text-muted d-block mt-1">Jika transaksi setelah jam 16:00, jadwal dianjurkan hari berikutnya.</small>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-semibold">Pilih Staf Kurir</label>
                                                                    <select name="id_kurir" class="form-select">
                                                                        <option value="" disabled selected>-- Pilih Kurir Bertugas --</option>
                                                                        @foreach ($kurir as $k)
                                                                            <option value="{{ $k->id_pegawai }}">{{ $k->nama_pegawai }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer bg-light px-4 py-3">
                                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-primary">
                                                                    <i class="bi bi-check2 me-1"></i> Simpan Jadwal
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif ($jadwal && $jadwal->jenis_jadwal === 'Diambil')
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#jadwalModal{{$item->id_transaksi}}">
                                                <i class="bi bi-calendar-plus me-1"></i> Jadwal Ambil
                                            </button>

                                            <div class="modal fade" id="jadwalModal{{$item->id_transaksi}}" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <form action="{{ route('pegawai_gudang.pengiriman.tambahJadwal') }}" method="POST" novalidate>
                                                            @csrf
                                                            <input type="hidden" name="id_transaksi" value="{{ $item->id_transaksi }}">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Pilih Jadwal Penyiapan Paket</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body p-4 text-start">
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-semibold">Tanggal & Jam Penyiapan</label>
                                                                    <input type="datetime-local" name="tanggal_jadwal" class="form-control" min="{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('Y-m-d') }}T00:00">
                                                                    <small class="text-muted d-block mt-1">Estimasi paket siap diambil oleh pembeli di gudang.</small>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer bg-light px-4 py-3">
                                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-primary">
                                                                    <i class="bi bi-check2 me-1"></i> Simpan Jadwal
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @else
                                        @if ($jadwal && $jadwal->pengiriman && $jadwal->pengiriman->status_pengiriman)
                                            @php
                                                $status = $jadwal->pengiriman->status_pengiriman;
                                                $showConfirmButton = 
                                                    ($jadwal->jenis_jadwal === 'Pengiriman' && $status === 'Diantar') ||
                                                    ($jadwal->jenis_jadwal === 'Diambil' && $status === 'Disiapkan');
                                            @endphp

                                            <div class="modal fade" id="modalKonfirmasi{{ $jadwal->id_jadwal }}" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
                                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <form action="{{ route('pegawai_gudang.pengiriman.konfirmasi', ['id_jadwal' => $jadwal->id_jadwal]) }}" method="POST" novalidate>
                                                            @csrf
                                                            @method('PUT')

                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Rincian Komisi Transaksi #{{ $jadwal->transaksi->nomor_transaksi }}</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>

                                                            <div class="modal-body p-4 text-start">
                                                                <div class="table-card mb-3">
                                                                    <table class="table align-middle mb-0 text-center">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="text-start">Nama Barang</th>
                                                                                <th class="text-start">Penitip</th>
                                                                                <th class="text-end">Harga Jual</th>
                                                                                <th class="text-end">Komisi ReUseMart</th>
                                                                                <th class="text-end">Komisi Hunter</th>
                                                                                <th class="text-end">Komisi Penitip</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach($jadwal->transaksi->detailTransaksi as $detail)
                                                                                @php
                                                                                    $barang = $detail->barang;
                                                                                    $hargaBarang = $barang->harga_jual;
                                                                                    $barangHunter = $barang->barang_hunter;
                                                                                    $statusPerpanjangan = $barang->status_perpanjangan;

                                                                                    $periodeTopSeller = date('Y-m-01', strtotime($jadwal->tanggal_jadwal));
                                                                                    $isTopSeller = \DB::table('badge')
                                                                                        ->where('id_penitip', $barang->id_penitip)
                                                                                        ->where('periode_pemberian', $periodeTopSeller)
                                                                                        ->exists();

                                                                                    $komisiPersen = $statusPerpanjangan ? 0.30 : 0.20;
                                                                                    if ($isTopSeller) {
                                                                                        $komisiPersen -= 0.01;
                                                                                    }

                                                                                    $komisiHunterPersen = 0;
                                                                                    $komisiHunterRp = 0;
                                                                                    if ($barangHunter) {
                                                                                        $komisiHunterPersen = 0.05;
                                                                                        $komisiPersen -= $komisiHunterPersen;
                                                                                        $komisiHunterRp = 0.05 * $hargaBarang;
                                                                                    }

                                                                                    $komisiReusemart = $komisiPersen * $hargaBarang;

                                                                                    $tanggalMasuk = \Carbon\Carbon::parse($barang->tanggal_masuk);
                                                                                    $tanggalTransaksi = \Carbon\Carbon::parse($jadwal->transaksi->tanggal_transaksi);
                                                                                    $selisihHari = $tanggalMasuk->diffInDays($tanggalTransaksi);

                                                                                    $bonusDiskonPenitip = 0;
                                                                                    if ($selisihHari < 7) {
                                                                                        $bonusDiskonPenitip = 0.10 * $komisiReusemart;
                                                                                        $komisiReusemart -= $bonusDiskonPenitip;
                                                                                    }

                                                                                    $komisiPenitip = $hargaBarang - ($komisiReusemart + $komisiHunterRp);
                                                                                @endphp
                                                                                <tr>
                                                                                    <td class="text-start fw-bold" style="color: var(--text-heading);">{{ $barang->nama_barang }}</td>
                                                                                    <td class="text-start text-muted">{{ $barang->penitip->nama_penitip ?? '-' }}</td>
                                                                                    <td class="text-end fw-semibold">Rp{{ number_format($hargaBarang, 0, ',', '.') }}</td>
                                                                                    <td class="text-end text-success">Rp{{ number_format($komisiReusemart, 0, ',', '.') }}</td>
                                                                                    <td class="text-end text-muted">
                                                                                        @if($barangHunter)
                                                                                            Rp{{ number_format($komisiHunterRp, 0, ',', '.') }}
                                                                                        @else
                                                                                            -
                                                                                        @endif
                                                                                    </td>
                                                                                    <td class="text-end fw-semibold">
                                                                                        Rp{{ number_format($komisiPenitip, 0, ',', '.') }}
                                                                                        @if($bonusDiskonPenitip > 0)
                                                                                            <br><small class="text-success">(Bonus: 10%)</small>
                                                                                        @endif
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer bg-light px-4 py-3">
                                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-primary">
                                                                    <i class="bi bi-check2 me-1"></i> Konfirmasi Selesai
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            @if ($showConfirmButton)
                                                @if ($jadwal->jenis_jadwal === 'Diambil')
                                                    <a href="{{ route('pegawai_gudang.cetakNotaPdf', ['id' => $item->id_transaksi]) }}"
                                                        target="_blank"
                                                        class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-printer"></i> PDF
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalKonfirmasi{{ $jadwal->id_jadwal }}">
                                                        <i class="bi bi-check-circle"></i> Konfirmasi
                                                    </button>
                                                @else
                                                    <a href="{{ route('pegawai_gudang.cetakNotaPdf', ['id' => $item->id_transaksi]) }}"
                                                    target="_blank"
                                                    class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-printer"></i> PDF
                                                    </a>
                                                @endif
                                            @else
                                                @if(strtolower($item->status_transaksi) !== 'menunggu pembayaran' && strtolower($jadwal->pengiriman->status_pengiriman) !== 'dibatalkan')
                                                    <a href="{{ route('pegawai_gudang.cetakNotaPdf', ['id' => $item->id_transaksi]) }}"
                                                    target="_blank"
                                                    class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-printer"></i> PDF
                                                    </a>
                                                @else
                                                    <span class="text-muted small">-</span>
                                                @endif
                                            @endif
                                        @else
                                            <span class="badge bg-light text-muted border">Belum Disiapkan</span>
                                        @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-5 text-center text-muted">
                                <i class="bi bi-truck fs-1 d-block mb-2 text-muted opacity-50"></i>
                                Tidak ada transaksi pengiriman atau pengambilan saat ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $transaksi->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
