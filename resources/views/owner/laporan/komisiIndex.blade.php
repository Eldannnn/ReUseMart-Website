@extends('owner.dashboard')
@section('isi')
<div class="container-fluid px-2">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1" style="color: var(--text-heading);">Laporan Komisi Bulanan per Produk</h3>
            <p class="text-muted small mb-0">Rincian pembagian pendapatan komisi hunter, komisi platform ReUseMart, dan komisi penitip</p>
        </div>

        <div class="d-flex flex-wrap align-items-center gap-2">
            <form class="d-flex align-items-center gap-2" method="GET" action="{{ route('owner.laporan.komisi') }}" novalidate>
                <select name="month" class="form-select" style="width: 140px;">
                    @foreach(range(1,12) as $m)
                        @php
                            $name = \Carbon\Carbon::createFromDate($year, $m, 1)->locale('id')->isoFormat('MMMM');
                        @endphp
                        <option value="{{ $m }}" {{ request('month', date('n')) == $m ? 'selected' : '' }}>
                            {{ ucfirst($name) }}
                        </option>
                    @endforeach
                </select>

                <input type="number" name="year" class="form-control" style="width: 100px;" 
                       value="{{ request('year', date('Y')) }}" min="2000" max="2099">

                <button class="btn btn-outline-primary" type="submit">Filter</button>
            </form>

            <a href="{{ route('owner.laporan.komisi.download', ['month' => request('month'), 'year' => request('year')]) }}" class="btn btn-outline-danger">
                <i class="bi bi-file-earmark-pdf me-1"></i> Unduh PDF
            </a>
        </div>
    </div>

    <div class="table-card">
        <div class="table-responsive">
            <table class="table align-middle mb-0 text-center">
                <thead>
                    <tr>
                        <th style="width: 110px;">Kode Produk</th>
                        <th class="text-start">Nama Produk</th>
                        <th class="text-end">Harga Jual</th>
                        <th class="text-center" style="width: 110px;">Tgl Masuk</th>
                        <th class="text-center" style="width: 110px;">Tgl Laku</th>
                        <th class="text-end">Komisi Hunter</th>
                        <th class="text-end">Komisi ReUseMart</th>
                        <th class="text-end">Komisi Penitip</th>
                        <th class="text-end">Bonus Penitip</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $row)
                        <tr>
                            <td class="fw-semibold text-muted font-monospace">
                                {{ strtoupper(substr($row['nama'], 0, 1)) . $row['kode'] }}
                            </td>
                            <td class="text-start fw-bold" style="color: var(--text-heading);">{{ $row['nama'] }}</td>
                            <td class="text-end fw-semibold">Rp {{ number_format($row['harga'], 0, ',', '.') }}</td>
                            <td class="text-muted small">{{ $row['tanggal_masuk'] }}</td>
                            <td class="text-muted small">{{ $row['tanggal_laku'] }}</td>
                            <td class="text-end text-muted">Rp {{ number_format($row['komisi_hunter'], 0, ',', '.') }}</td>
                            <td class="text-end text-success fw-semibold">Rp {{ number_format($row['komisi_reuse'], 0, ',', '.') }}</td>
                            <td class="text-end fw-semibold">Rp {{ number_format($row['komisi_penitip'], 0, ',', '.') }}</td>
                            <td class="text-end text-warning fw-semibold">Rp {{ number_format($row['bonus_penitip'], 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-5 text-center text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-muted opacity-50"></i>
                                Tidak ada transaksi penjualan di bulan ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if(count($data))
                <tfoot>
                    <tr class="fw-bold bg-light">
                        <td colspan="2" class="text-start">Total</td>
                        <td class="text-end">Rp {{ number_format(collect($data)->sum('harga'), 0, ',', '.') }}</td>
                        <td colspan="2"></td>
                        <td class="text-end">Rp {{ number_format(collect($data)->sum('komisi_hunter'), 0, ',', '.') }}</td>
                        <td class="text-end text-success">Rp {{ number_format(collect($data)->sum('komisi_reuse'), 0, ',', '.') }}</td>
                        <td class="text-end">Rp {{ number_format(collect($data)->sum('komisi_penitip'), 0, ',', '.') }}</td>
                        <td class="text-end text-warning">Rp {{ number_format(collect($data)->sum('bonus_penitip'), 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection
