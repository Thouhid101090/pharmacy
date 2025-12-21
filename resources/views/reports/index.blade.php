@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <div class="mb-4">
        <h2 class="fw-bold h4">Business Reports</h2>
        <p class="text-muted">Select a report to view detailed performance and analytics.</p>
    </div>

    <div class="row g-3">
        <div class="col-12 col-md-4">
            <a href="{{ route('reports.sales') }}" class="text-decoration-none">
                <div class="card h-100 shadow-sm border-0 report-card bg-primary text-white">
                    <div class="card-body d-flex align-items-center p-4">
                        <div class="report-icon me-3">
                            <i class="bi bi-cart-check fs-1"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Sales Report</h5>
                            <small class="opacity-75">Revenue and itemized sales</small>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-12 col-md-4">
            <a href="{{ route('reports.purchases') }}" class="text-decoration-none">
                <div class="card h-100 shadow-sm border-0 report-card bg-info text-white">
                    <div class="card-body d-flex align-items-center p-4">
                        <div class="report-icon me-3">
                            <i class="bi bi-bag-plus fs-1"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Purchase Report</h5>
                            <small class="opacity-75">Stock intake and expenses</small>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-12 col-md-4">
            <a href="{{ route('reports.profitLoss') }}" class="text-decoration-none">
                <div class="card h-100 shadow-sm border-0 report-card bg-dark text-white">
                    <div class="card-body d-flex align-items-center p-4">
                        <div class="report-icon me-3">
                            <i class="bi bi-graph-up-arrow fs-1 text-success"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Profit / Loss</h5>
                            <small class="opacity-75">Net income and margin analysis</small>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<style>
    /* Add a subtle hover effect for better UI */
    .report-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .report-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important;
    }
    .report-icon i {
        /* This assumes you are using Bootstrap Icons.
           If not, you can use simple emoji or FontAwesome */
        line-height: 1;
    }

    @media (max-width: 767.98px) {
        .container { padding-left: 15px; padding-right: 15px; }
        .report-card { margin-bottom: 5px; }
    }
</style>
@endsection
