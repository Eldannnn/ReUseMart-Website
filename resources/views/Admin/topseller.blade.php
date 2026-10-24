@extends('Admin.dashboard')

@section('isi')

<div class="container-fluid px-2">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1" style="color: var(--text-heading);">Top Seller & Peringkat Penitip</h3>
            <p class="text-muted small mb-0">Pemantauan performa penjualan dan penetapan apresiasi top seller bulanan</p>
        </div>

        <form id="topSellerForm" novalidate class="mb-0">
            @csrf
            <button type="submit" class="btn btn-primary" id="btnSetTopSeller">
                <i class="bi bi-award-fill me-1"></i> Tentukan Top Seller Bulan Lalu
            </button>
        </form>
    </div>

    {{-- Alert Messages --}}
    @if(session('error'))
    <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center gap-2 mb-4" role="alert">
        <i class="bi bi-exclamation-triangle-fill fs-5"></i>
        <div>{{ session('error') }}</div>
    </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
            <div class="d-flex align-items-start gap-2">
                <i class="bi bi-check-circle-fill fs-5 text-success"></i>
                <div>
                    <strong>{{ session('success') }}</strong>
                    @if(session('bonus_added') && session('penitip'))
                        <div class="mt-1 small">
                            Mitra <strong>{{ session('penitip') }}</strong> mendapat tambahan saldo sebesar 
                            <span class="text-success fw-bold">Rp {{ number_format(session('bonus_added'), 0, ',', '.') }}</span>!
                        </div>
                    @endif
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4 mb-4">
        {{-- Card Highlight: Top Seller Bulan Berjalan --}}
        <div class="col-12 col-md-5">
            <div class="card h-100 border-0 shadow-sm" style="background: linear-gradient(135deg, #ffffff 0%, #f8faf5 100%); border: 1px solid var(--border-color) !important;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="badge-status badge-tersedia">
                            <i class="bi bi-fire me-1"></i> Bulan Berjalan
                        </span>
                        <div class="stat-icon" style="background: rgba(111, 143, 70, 0.15);">
                            <i class="bi bi-trophy-fill text-warning fs-4"></i>
                        </div>
                    </div>

                    <h6 class="text-muted text-uppercase fw-bold small mb-2">Top Seller Teratas Saat Ini</h6>
                    
                    @if($topSeller)
                        <h4 class="fw-bold mb-2" style="color: var(--brand-primary-dark);">
                            {{ $topSeller->nama_penitip ?? 'Tidak ada' }}
                        </h4>
                        <div class="p-3 rounded-3 mt-3" style="background-color: var(--brand-primary-subtle); border: 1px solid rgba(111, 143, 70, 0.2);">
                            <div class="text-muted small">Akumulasi Penjualan</div>
                            <div class="fs-4 fw-extrabold text-success">
                                Rp {{ number_format($topSeller->total_penjualan, 0, ',', '.') }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-info-circle fs-2 text-muted opacity-50 mb-2 d-block"></i>
                            <p class="text-muted small mb-0">Belum ada transaksi penjualan di bulan ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Table Card: Ranking Penitip Bulan Ini --}}
        <div class="col-12 col-md-7">
            <div class="table-card h-100">
                <div class="p-3 border-bottom d-flex align-items-center justify-content-between">
                    <h6 class="fw-bold mb-0" style="color: var(--text-heading);">
                        <i class="bi bi-bar-chart-line-fill me-2" style="color: var(--brand-primary);"></i>
                        Peringkat Penjualan Bulan Ini
                    </h6>
                    <span class="badge bg-light text-muted border">Bulan Ini</span>
                </div>
                <div class="table-responsive" style="max-height: 280px; overflow-y: auto;">
                    @if($rankingThisMonth->count())
                        <table class="table align-middle mb-0 text-center">
                            <thead>
                                <tr>
                                    <th style="width: 70px;">Rank</th>
                                    <th class="text-start">Nama Penitip</th>
                                    <th class="text-end">Total Penjualan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rankingThisMonth as $index => $seller)
                                    <tr @if($topSeller && $topSeller->id_penitip == $seller->id_penitip) style="background-color: rgba(111, 143, 70, 0.08);" @endif>
                                        <td class="fw-bold">
                                            @if($index == 0)
                                                <span class="badge rounded-pill bg-warning text-dark"><i class="bi bi-award-fill"></i> #1</span>
                                            @elseif($index == 1)
                                                <span class="badge rounded-pill bg-secondary text-white">#2</span>
                                            @elseif($index == 2)
                                                <span class="badge rounded-pill bg-light text-dark border">#3</span>
                                            @else
                                                <span class="text-muted">#{{ $index + 1 }}</span>
                                            @endif
                                        </td>
                                        <td class="text-start fw-semibold" style="color: var(--text-heading);">
                                            {{ $seller->nama_penitip }}
                                        </td>
                                        <td class="text-end fw-bold text-success">
                                            Rp {{ number_format($seller->total_penjualan, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="p-4 text-center text-muted small">
                            Belum ada catatan penjualan di bulan ini.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Riwayat Top Seller --}}
    <div class="table-card mt-4">
        <div class="p-3 border-bottom d-flex align-items-center justify-content-between">
            <h6 class="fw-bold mb-0" style="color: var(--text-heading);">
                <i class="bi bi-clock-history me-2" style="color: var(--brand-primary);"></i>
                Riwayat Top Seller Tiap Periode
            </h6>
        </div>
        <div class="table-responsive">
            @if($historyTopSellers->count())
                <table class="table align-middle mb-0 text-center">
                    <thead>
                        <tr>
                            <th class="text-start" style="width: 220px;">Periode Bulan</th>
                            <th class="text-start">Nama Penitip</th>
                            <th class="text-end">Total Penjualan</th>
                            <th class="text-center" style="width: 140px;">Status Apresiasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($historyTopSellers as $badge)
                        <tr>
                            <td class="text-start fw-semibold text-muted">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ \Carbon\Carbon::parse($badge->periode_pemberian)->locale('id')->subMonth()->translatedFormat('F Y') }}
                            </td>
                            <td class="text-start fw-bold" style="color: var(--text-heading);">
                                {{ $badge->penitip->nama_penitip ?? 'Tidak Diketahui' }}
                            </td>
                            <td class="text-end fw-bold text-success">
                                Rp {{ number_format($badge->total_penjualan ?? 0, 0, ',', '.') }}
                            </td>
                            <td>
                                <span class="badge-status badge-tersedia">
                                    <i class="bi bi-patch-check-fill me-1"></i> Top Seller
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="p-4 text-center text-muted small">
                    Belum ada riwayat top seller sebelumnya.
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Result Modal --}}
<div class="modal fade" id="topSellerResultModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="bi bi-trophy-fill text-warning me-2"></i> Hasil Penentuan Top Seller
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4 text-center">
        <div class="mb-3 text-warning">
          <i class="bi bi-award-fill" style="font-size: 3.5rem;"></i>
        </div>
        <h4 class="fw-bold mb-2" id="modalTopSellerNama" style="color: var(--brand-primary-dark);">-</h4>
        <p class="text-muted small mb-4" id="modalTopSellerMsg">-</p>

        <div class="card p-3 border-0 rounded-3 text-start mb-3" style="background-color: var(--bg-muted);">
          <div class="d-flex justify-content-between mb-2">
            <span class="text-muted small">Total Penjualan:</span>
            <span class="fw-bold" id="modalTopSellerSales">Rp 0</span>
          </div>
          <div class="d-flex justify-content-between">
            <span class="text-muted small">Bonus Apresiasi Ditambahkan:</span>
            <span class="fw-bold text-success" id="modalTopSellerBonus">Rp 0</span>
          </div>
        </div>
      </div>
      <div class="modal-footer bg-light justify-content-center">
        <button type="button" class="btn btn-primary px-4" data-bs-dismiss="modal" onclick="location.reload()">
          Selesai & Muat Ulang
        </button>
      </div>
    </div>
  </div>
</div>

{{-- Toast Container for Errors --}}
<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1090;">
  <div id="topSellerToast" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body d-flex align-items-center gap-2" id="topSellerToastMsg">
        <i class="bi bi-exclamation-octagon-fill fs-5"></i>
        <span>Pesan aksi</span>
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>

<script>
document.getElementById('topSellerForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const btn = document.getElementById('btnSetTopSeller');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Memproses...';

    function showToastErr(msg) {
        document.getElementById('topSellerToastMsg').innerHTML = `<i class="bi bi-exclamation-octagon-fill fs-5"></i> <span>${msg}</span>`;
        const toast = new bootstrap.Toast(document.getElementById('topSellerToast'), { delay: 3500 });
        toast.show();
    }

    try {
        const response = await fetch("{{ route('admin.setTopSellerLastMonth') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({})
        });

        const data = await response.json();

        if (response.ok && data.top_seller) {
            document.getElementById('modalTopSellerNama').textContent = data.top_seller.nama || 'Mitra ReUseMart';
            document.getElementById('modalTopSellerMsg').textContent = data.message || 'Top seller bulan lalu berhasil ditentukan.';
            document.getElementById('modalTopSellerSales').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(data.top_seller.total_penjualan || 0);
            document.getElementById('modalTopSellerBonus').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(data.top_seller.bonus || 0);

            const resultModal = new bootstrap.Modal(document.getElementById('topSellerResultModal'));
            resultModal.show();
        } else {
            showToastErr(data.message || 'Gagal menentukan top seller bulan lalu.');
        }
    } catch (error) {
        console.error('Error saat submit:', error);
        showToastErr('Terjadi kendala jaringan saat memproses permintaan.');
    } finally {
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-award-fill me-1"></i> Tentukan Top Seller Bulan Lalu';
    }
});
</script>

@endsection
