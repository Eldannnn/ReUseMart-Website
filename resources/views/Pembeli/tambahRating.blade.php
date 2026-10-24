<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Beri Rating Produk - ReUseMart</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/reusemart-theme.css') }}">

  <style>
    .rating-card {
      background-color: #ffffff;
      border: 1px solid var(--border-color);
      border-radius: var(--radius-lg);
      box-shadow: var(--shadow-card);
    }

    .detail-barang {
      background-color: var(--bg-muted);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      padding: 1.25rem;
    }

    /* Styling bintang rating */
    .rating {
      direction: rtl;
      unicode-bidi: bidi-override;
      font-size: 2.5rem;
      display: inline-flex;
    }
    .rating input[type="radio"] {
      display: none;
    }
    .rating label {
      color: #cbd5e1;
      cursor: pointer;
      padding: 0 8px;
      transition: var(--transition-smooth);
    }
    .rating label:hover,
    .rating label:hover ~ label,
    .rating input[type="radio"]:checked ~ label {
      color: #f59e0b;
      transform: scale(1.1);
    }

    /* Foto barang */
    .foto-barang img {
      max-width: 100px; 
      max-height: 100px; 
      object-fit: cover; 
      border-radius: var(--radius-sm); 
      border: 1px solid var(--border-color);
      box-shadow: var(--shadow-subtle);
    }
  </style>
</head>
<body class="bg-light">
  <div class="container py-5" style="max-width: 640px;">
    <div class="rating-card p-4 p-md-5 mx-auto">
      <div class="text-center mb-4">
        <span class="badge bg-white text-muted border px-3 py-1 rounded-pill small mb-2">Ulasan Pembeli</span>
        <h3 class="fw-bold mb-1" style="color: var(--brand-primary-dark);">Beri Rating Produk</h3>
        <p class="text-muted small">Bagikan pengalaman dan kepuasan Anda terhadap kondisi barang</p>
      </div>

      {{-- Foto Barang --}}
      <div class="d-flex flex-wrap gap-2 mb-3 justify-content-center foto-barang">
        @foreach ($barang->fotoBarang as $foto)
            <img 
                src="{{ asset('images/barang/' . $foto->nama_file) }}" 
                alt="Foto {{ $barang->nama_barang }}" 
            >
        @endforeach
      </div>

      {{-- Detail Barang --}}
      <div class="detail-barang mb-4">
        <h5 class="fw-bold text-dark mb-2">{{ $barang->nama_barang }}</h5>
        <div class="small text-muted mb-1">
          <strong>Kode:</strong> <span class="badge bg-light text-dark border">B{{ $barang->id_barang }}</span>
          <span class="mx-2">•</span>
          <strong>Penitip:</strong> {{ $barang->penitip->nama_penitip ?? '-' }}
        </div>
        <div class="fw-bold fs-6 mb-2" style="color: var(--brand-primary);">
          Rp{{ number_format($barang->harga_jual, 0, ',', '.') }}
        </div>
        <p class="text-muted small mb-0">{{ $barang->deskripsi }}</p>
      </div>

      {{-- Form Rating --}}
      <form id="ratingForm" action="{{ route('pembeli.storeRating') }}" method="POST" novalidate>
        @csrf
        <input type="hidden" name="id_barang" value="{{ $barang->id_barang }}">

        <div class="mb-4 text-center">
          <label class="form-label small fw-semibold text-muted d-block mb-1">Pilih Tingkat Kepuasan (1–5 Bintang):</label>
          <div class="rating mx-auto">
            @for ($i = 5; $i >= 1; $i--)
              <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}"
                {{ (old('rating', $existing->rating ?? '') == $i) ? 'checked' : '' }} />
              <label for="star{{ $i }}" title="{{ $i }} bintang">&#9733;</label>
            @endfor
          </div>
          @error('rating')
            <div class="text-danger small mt-1">{{ $message }}</div>
          @enderror
        </div>
        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('pembeli.riwayatTransaksi') }}" class="btn btn-outline-secondary px-4 py-2">Batal</a>
            <button type="submit" class="btn btn-primary px-5 py-2">Kirim Rating</button>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
