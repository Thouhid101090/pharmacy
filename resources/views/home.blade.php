@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">📊 Dashboard Summary</h2>

    {{-- Summary Cards --}}
    <div class="row text-center mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <h5>Total Sales</h5>
                <h3 class="text-success">{{ number_format($totalSales) }}Tk</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <h5>Total Purchases</h5>
                <h3 class="text-danger">{{ number_format($totalPurchases) }}Tk</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <h5>Total Profit</h5>
                <h3 class="text-primary">{{ number_format($profit) }}Tk</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <h5>Total Stock Value</h5>
                <h3 class="text-primary">{{ number_format($totalStockValue) }} Tk</h3>
            </div>
        </div>
    </div>



    {{-- Graph --}}
    <div class="card p-4 shadow-sm">
        <h4 class="mb-3 text-center">Sales & Purchases (Last 7 Days)</h4>
        <canvas id="salesChart" height="100"></canvas>
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
                    borderColor: 'green',
                    tension: 0.4,
                    fill: false
                },
                {
                    label: 'Purchases',
                    data: purchases,
                    borderColor: 'red',
                    tension: 0.4,
                    fill: false
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection
