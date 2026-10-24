<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Riwayat Pembelian - ReUseMart</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/reusemart-theme.css') }}">
  <style>
    .order-card {
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      overflow: hidden;
      transition: var(--transition-smooth);
    }
    .order-card:hover {
      box-shadow: var(--shadow-card);
      border-color: var(--border-hover);
    }
    .order-card-header {
      background-color: var(--brand-primary-subtle);
      border-bottom: 1px solid var(--border-color);
      padding: 16px 20px;
    }
  </style>
</head>
<body class="bg-light">
  <div class="container py-5" style="max-width: 1000px;">
    {{-- Bungkus seluruh konten dalam sebuah card --}}
    <div class="card shadow-sm border-0">
      <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
        <div>
          <span class="badge bg-light text-muted border px-2 py-1 rounded-pill small mb-1">Transaksi</span>
          <h4 class="mb-0 fw-bold" style="color: var(--brand-primary-dark);">Riwayat Pembelian</h4>
        </div>
        <a href="{{ route('pembeli.profil') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
          ← Kembali ke Profil
        </a>
      </div>
      <div class="card-body p-4">
        <form method="GET" action="{{ route('pembeli.riwayatTransaksi') }}" class="mb-4" novalidate>
          <div class="input-group">
            <input 
              type="text" 
              name="search" 
              class="form-control" 
              placeholder="Cari berdasarkan ID transaksi atau produk..." 
              value="{{ request('search') }}"
            >
            <button type="submit" class="btn btn-primary px-4">Cari</button>
          </div>
        </form>

        @forelse ($transaksiList as $transaksi)
            @php
                $terdapatDiterima = false;
                $statusPengirimanText = 'Belum ada pengiriman';

                if ($transaksi->penjadwalans) {
                  foreach ($transaksi->penjadwalans as $penjadwalan) {
                      if ($penjadwalan && $penjadwalan->pengiriman) {
                          $statusPengirimanText = strtolower(trim($penjadwalan->pengiriman->status_pengiriman));
                          if (in_array($statusPengirimanText, ['diterima', 'sampai'])) {
                              $terdapatDiterima = true;
                              break;
                          }
                      }
                  }
              }
            @endphp
          <div class="order-card mb-4 bg-white">
            <div class="order-card-header">
              <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div>
                  <span class="small text-muted">ID Transaksi:</span> <strong>#{{ $transaksi->id_transaksi }}</strong>
                  <span class="mx-2 text-muted">•</span>
                  <span class="small text-muted">{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->locale('id')->isoFormat('D MMMM YYYY') }}</span>
                  <div class="mt-1 d-flex flex-wrap align-items-center gap-2">
                    <span class="badge-status badge-tersedia">
                      {{ ucfirst($transaksi->status_transaksi) }}
                    </span>
                    <span class="badge bg-white text-muted border small">
                      <i class="bi bi-truck me-1"></i> {{ ucfirst($statusPengirimanText) }}
                    </span>
                  </div>
                </div>
                <div class="text-end">
                  <span class="small text-muted d-block">Total Pembayaran</span>
                  <span class="fs-5 fw-bold" style="color: var(--brand-primary-dark);">
                    Rp{{ number_format($transaksi->total_pembayaran, 0, ',', '.') }}
                  </span>
                </div>
              </div>
            </div>
            <div class="p-0">
              <ul class="list-group list-group-flush">
                @foreach ($transaksi->detailTransaksi as $detail)
                  <li class="list-group-item p-3">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                      <div>
                        <span class="badge bg-light text-dark border me-1 small">
                          {{ strtoupper(substr($detail->barang->nama_barang ?? '-', 0, 1)) . ($detail->barang->id_barang ?? '') }}
                        </span>
                        <strong class="text-dark">{{ $detail->barang->nama_barang ?? 'Barang sudah dihapus' }}</strong>
                      </div>
                      <div class="d-flex align-items-center gap-3">
                        <span class="fw-bold" style="color: var(--brand-primary);">
                          Rp{{ number_format(($detail->barang->harga_jual ?? $detail->sub_total), 0, ',', '.') }}
                        </span>

                        @if($terdapatDiterima)
                          @php
                            $existingRating = $detail->barang->ratingDetail ?? null;
                          @endphp

                          @if(!$existingRating)
                            <a href="{{ route('pembeli.tambahRating', ['id_barang' => $detail->barang->id_barang]) }}" class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-star me-1"></i> Beri Rating
                            </a>
                          @else
                            <span class="badge bg-warning-subtle text-warning-emphasis fw-bold">
                                Rating: {{ number_format($existingRating->rating, 1) }} / 5 <i class="bi bi-star-fill text-warning ms-1"></i>
                            </span>
                          @endif
                        @endif
                      </div>
                    </div>
                  </li>
                @endforeach
              </ul>
            </div>
          </div>
        @empty
          <div class="p-5 text-center text-muted border rounded-3 bg-light">
            <div class="fs-1 mb-2 text-muted"><i class="bi bi-bag-x"></i></div>
            <h6 class="fw-bold text-dark">Belum Ada Transaksi</h6>
            <p class="small mb-0">Anda belum memiliki riwayat pembelian barang di ReUseMart.</p>
          </div>
        @endforelse

        <div class="d-flex justify-content-center mt-4">
          {{ $transaksiList->appends(['search' => request('search')])->links() }}
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
