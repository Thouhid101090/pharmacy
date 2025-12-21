@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h4 mb-0 fw-bold">All Sales</h2>
        <a href="{{ route('sales.create') }}" class="btn btn-primary shadow-sm">+ New Sale</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    {{-- SUMMARY SECTION - Responsive Cards --}}
    <div class="row g-2 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm bg-primary text-white text-center p-2 h-100">
                <small class="d-block opacity-75">Today's Sale</small>
                <h5 class="mb-0 fw-bold">{{ number_format($dailySale, 2) }}</h5>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm bg-success text-white text-center p-2 h-100">
                <small class="d-block opacity-75">Daily Profit</small>
                <h5 class="mb-0 fw-bold">{{ number_format($dailyProfit, 2) }}</h5>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm bg-info text-white text-center p-2 h-100">
                <small class="d-block opacity-75">Monthly Sale</small>
                <h5 class="mb-0 fw-bold">{{ number_format($monthlySale, 2) }}</h5>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm bg-dark text-white text-center p-2 h-100">
                <small class="d-block opacity-75">Monthly Profit</small>
                <h5 class="mb-0 fw-bold">{{ number_format($monthlyProfit, 2) }}</h5>
            </div>
        </div>
    </div>

    {{-- SALES TABLE - Responsive Data Layout --}}
    <div class="card border-0 shadow-sm overflow-hidden">
        {{-- Table view for Desktop --}}
        <div class="table-responsive d-none d-md-block">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-center">
                    <tr class="text-secondary small text-uppercase">
                        <th>Medicine</th>
                        <th>Qty</th>
                        <th>Sell Price</th>
                        <th>Total</th>
                        <th>Profit</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach($sales as $sale)
                    <tr>
                        <td class="text-start fw-bold">{{ $sale->medicine->name }}</td>
                        <td><span class="badge bg-light text-dark border">{{ $sale->quantity }}</span></td>
                        <td>{{ number_format($sale->selling_price, 2) }}</td>
                        <td class="fw-bold">{{ number_format($sale->total_price, 2) }}</td>
                        <td class="text-success fw-bold">{{ number_format($sale->profit, 2) }}</td>
                        <td class="small">{{ $sale->created_at->format('d-m-Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- List view for Mobile --}}
        <div class="d-md-none">
            @foreach($sales as $sale)
            <div class="p-3 border-bottom">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <h6 class="mb-0 fw-bold text-primary">{{ $sale->medicine->name }}</h6>
                        <small class="text-muted">{{ $sale->created_at->format('d M, Y') }}</small>
                    </div>
                    <div class="text-end">
                        <div class="fw-bold">TK {{ number_format($sale->total_price, 2) }}</div>
                        <small class="text-success fw-bold">Profit: {{ number_format($sale->profit, 2) }}</small>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center bg-light p-2 rounded small">
                    <span>Qty: <strong>{{ $sale->quantity }}</strong></span>
                    <span>Unit: <strong>{{ number_format($sale->selling_price, 2) }}</strong></span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $sales->links() }}
    </div>
</div>

<style>
    @media (max-width: 767.98px) {
        .container { padding-left: 10px; padding-right: 10px; }
        h5 { font-size: 1.1rem; }
    }
</style>
@endsection
