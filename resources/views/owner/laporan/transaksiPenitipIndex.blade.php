@extends('owner.dashboard')
@section('isi')
<div class="container-fluid px-2">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1" style="color: var(--text-heading);">Laporan Transaksi Semua Penitip</h3>
            <p class="text-muted small mb-0">Rincian omzet, bonus terjual cepat, dan total pendapatan bersih mitra penitip</p>
        </div>

        <div class="d-flex flex-wrap align-items-center gap-2">
            <form class="d-flex align-items-center gap-2" method="GET" action="{{ route('owner.laporan.transaksipenitip') }}" novalidate>
                <select name="month" class="form-select" style="width: 140px;">
                    @foreach(range(1,12) as $m)
                        @php
                            $monthName = \Carbon\Carbon::create()->month($m)->locale('id')->isoFormat('MMMM');
                        @endphp
                        <option value="{{ $m }}" {{ request('month', date('n')) == $m ? 'selected' : '' }}>
                            {{ ucfirst($monthName) }}
                        </option>
                    @endforeach
                </select>

                <input type="number" name="year" class="form-control" style="width: 100px;" 
                    value="{{ request('year', date('Y')) }}" min="2000" max="2099">

                <button class="btn btn-outline-primary" type="submit">Filter</button>
            </form>
        </div>
    </div>

    <div class="table-card">
        <div class="table-responsive">
            <table class="table align-middle mb-0 text-center">
                <thead>
                    <tr>
                        <th style="width: 100px;">ID Penitip</th>
                        <th class="text-start">Nama Penitip</th>
                        <th class="text-end">Harga Jual Bersih</th>
                        <th class="text-end">Bonus Terjual Cepat</th>
                        <th class="text-end">Total Pendapatan</th>
                        <th class="text-center" style="width: 160px;">Dokumen</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rekap as $row)
                        <tr>
                            <td class="fw-semibold text-muted font-monospace">T{{ $row['id_penitip'] }}</td>
                            <td class="text-start fw-bold" style="color: var(--text-heading);">{{ $row['nama_penitip'] }}</td>
                            <td class="text-end fw-semibold">Rp {{ number_format($row['harga_jual_bersih'], 0, ',', '.') }}</td>
                            <td class="text-end text-warning fw-semibold">Rp {{ number_format($row['bonus_terjual_cepat'], 0, ',', '.') }}</td>
                            <td class="text-end text-success fw-bold">Rp {{ number_format($row['pendapatan'], 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('owner.laporan.transaksipenitip.download', [
                                    'id_penitip' => $row['id_penitip'],
                                    'month' => request('month', now()->month),
                                    'year' => request('year', now()->year)
                                ]) }}" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-file-earmark-pdf me-1"></i> Unduh PDF
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-5 text-center text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-muted opacity-50"></i>
                                Tidak ada data transaksi di bulan ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $penitips->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
