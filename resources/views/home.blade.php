@extends('layouts.app')

@section('content')
<div class="container mt-3 pb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 mb-0 fw-bold">📊 Dashboard Summary</h2>
        <span class="badge bg-light text-dark border">{{ now()->format('d M, Y') }}</span>
    </div>

    {{-- Summary Cards - Optimized for 2x2 on Mobile --}}
    <div class="row g-2 mb-4">
        <div class="col-6 col-md-3">
            <div class="card h-100 border-0 shadow-sm p-3">
                <small class="text-muted d-block mb-1 fw-bold">Sales</small>
                <h4 class="text-success fw-bold mb-0">{{ number_format($totalSales) }}<span class="small h6">Tk</span></h4>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card h-100 border-0 shadow-sm p-3">
                <small class="text-muted d-block mb-1 fw-bold">Purchases</small>
                <h4 class="text-danger fw-bold mb-0">{{ number_format($totalPurchases) }}<span class="small h6">Tk</span></h4>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card h-100 border-0 shadow-sm p-3">
                <small class="text-muted d-block mb-1 fw-bold">Net Profit</small>
                <h4 class="text-primary fw-bold mb-0">{{ number_format($profit) }}<span class="small h6">Tk</span></h4>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card h-100 border-0 shadow-sm p-3">
                <small class="text-muted d-block mb-1 fw-bold">Stock Value</small>
                <h4 class="text-dark fw-bold mb-0">{{ number_format($totalStockValue) }}<span class="small h6">Tk</span></h4>
            </div>
        </div>
    </div>

    {{-- Chart Section --}}
    <div class="card border-0 shadow-sm p-3 p-md-4">
        <h5 class="mb-3 fw-bold text-center text-md-start">
            <i class="bi bi-graph-up text-primary"></i> Trend (Last 7 Days)
        </h5>
        <div class="chart-container" style="position: relative; height:30vh; width:100%">
            <canvas id="salesChart"></canvas>
        </div>
    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('salesChart');

    const salesData = @json($salesData);
    const purchaseData = @json($purchaseData);

    const labels = salesData.map(s => s.date);
    const sales = salesData.map(s => s.total);
    const purchases = purchaseData.map(p => p.total);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Sales',
                    data: sales,
                    borderColor: '#198754', // Bootstrap Success Green
                    backgroundColor: 'rgba(25, 135, 84, 0.1)',
                    tension: 0.3,
                    fill: true,
                    pointRadius: 4
                },
                {
                    label: 'Purchases',
                    data: purchases,
                    borderColor: '#dc3545', // Bootstrap Danger Red
                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                    tension: 0.3,
                    fill: true,
                    pointRadius: 4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // Allows the height to be controlled by CSS
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { boxWidth: 12, padding: 20 }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) { return value.toLocaleString() + ' Tk'; }
                    }
                },
                x: {
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45,
                        font: { size: 10 }
                    }
                }
            }
        }
    });
</script>

<style>
    @media (max-width: 767.98px) {
        .container { padding-left: 10px; padding-right: 10px; }
        h4 { font-size: 1.15rem; }
        .chart-container { height: 40vh !important; } /* Taller chart on mobile */
    }
</style>
@endsection
