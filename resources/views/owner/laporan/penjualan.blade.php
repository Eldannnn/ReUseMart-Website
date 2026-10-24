@extends('owner.dashboard')
@section('isi')
<div class="container-fluid px-2">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1" style="color: var(--text-heading);">Laporan Penjualan Bulanan</h3>
            <p class="text-muted small mb-0">Statistik performa penjualan kotor dan volume barang terjual per bulan periode {{ $year }}</p>
        </div>

        <div class="d-flex flex-wrap align-items-center gap-2">
            <form method="GET" action="{{ route('owner.laporan.penjualan') }}" class="d-flex align-items-center gap-2" novalidate>
                <div class="input-group">
                    <span class="input-group-text bg-white" style="border-color: var(--border-color); font-size: 13px;">Tahun</span>
                    <select id="year-select" name="year" class="form-select" onchange="this.form.submit()" style="border-color: var(--border-color);">
                        @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endfor
                    </select>
                </div>
            </form>

            <a href="{{ route('owner.laporan.penjualan.download', ['year' => $year]) }}" class="btn btn-outline-danger">
                <i class="bi bi-file-earmark-pdf me-1"></i> Unduh PDF
            </a>
        </div>
    </div>

    {{-- Tabel Data --}}
    <div class="table-card mb-4">
        <div class="p-3 border-bottom d-flex align-items-center justify-content-between">
            <h6 class="fw-bold mb-0" style="color: var(--text-heading);">
                <i class="bi bi-calendar3 me-2" style="color: var(--brand-primary);"></i>
                Rincian Rekap Penjualan {{ $year }}
            </h6>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0 text-center">
                <thead>
                    <tr>
                        <th class="text-start" style="width: 220px;">Bulan</th>
                        <th class="text-center" style="width: 240px;">Jumlah Barang Terjual</th>
                        <th class="text-end">Penjualan Kotor (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataByMonth as $monthData)
                        <tr>
                            <td class="text-start fw-bold" style="color: var(--text-heading);">
                                <i class="bi bi-calendar2-check me-2" style="color: var(--brand-primary);"></i>
                                {{ $monthData['month'] }}
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border px-3 py-1 fw-bold">
                                    {{ $monthData['count'] }} item
                                </span>
                            </td>
                            <td class="text-end fw-bold text-success">
                                Rp {{ number_format($monthData['gross'], 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="fw-bold bg-light">
                        <td class="text-start">Total Tahunan</td>
                        <td>{{ collect($dataByMonth)->sum('count') }} item</td>
                        <td class="text-end text-success">Rp {{ number_format(collect($dataByMonth)->sum('gross'), 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- Grafik Visual --}}
    <div class="card border-0 shadow-sm p-4" style="border: 1px solid var(--border-color) !important; border-radius: var(--radius-md);">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="fw-bold mb-0" style="color: var(--text-heading);">
                <i class="bi bi-bar-chart-fill me-2" style="color: var(--brand-primary);"></i>
                Grafik Tren Penjualan Bulanan
            </h6>
            <span class="badge bg-light text-muted border">Periode {{ $year }}</span>
        </div>
        <div>
            <canvas id="salesChart" width="100%" height="35"></canvas>
        </div>
    </div>
</div>

{{-- Sertakan Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('salesChart').getContext('2d');

        const labels = {!! json_encode(array_column($dataByMonth, 'month')) !!};
        const dataCount = {!! json_encode(array_column($dataByMonth, 'count')) !!};
        const dataGross = {!! json_encode(array_column($dataByMonth, 'gross')) !!};

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Penjualan Kotor (Rp)',
                        data: dataGross,
                        backgroundColor: 'rgba(111, 143, 70, 0.75)',
                        borderColor: '#6f8f46',
                        borderWidth: 1.5,
                        borderRadius: 6,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Jumlah Terjual (Item)',
                        data: dataCount,
                        type: 'line',
                        backgroundColor: 'rgba(217, 119, 6, 0.2)',
                        borderColor: '#d97706',
                        borderWidth: 2.5,
                        tension: 0.3,
                        pointRadius: 4,
                        pointBackgroundColor: '#d97706',
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        position: 'left',
                        title: { display: true, text: 'Rupiah (Rp)' }
                    },
                    y1: {
                        beginAtZero: true,
                        position: 'right',
                        grid: { drawOnChartArea: false },
                        title: { display: true, text: 'Jumlah Item' }
                    }
                }
            }
        });
    });
</script>
@endsection
