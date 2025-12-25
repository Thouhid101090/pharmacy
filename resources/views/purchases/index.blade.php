@extends('layouts.app')

@section('content')
<div class="container mt-3">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h4 mb-0 fw-bold">Purchases</h2>
        <a href="{{ route('purchases.create') }}" class="btn btn-primary shadow-sm">+ New Purchase</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-2">
            <form action="{{ route('purchases.index') }}" method="GET">
                <div class="input-group">
                    <input type="text"
                           name="search"
                           class="form-control border-0 shadow-none"
                           placeholder="Search by medicine or supplier..."
                           value="{{ request('search') }}">
                    <button class="btn btn-primary px-4" type="submit">
                        <i class="bi bi-search"></i> Search
                    </button>
                    @if(request('search'))
                        <a href="{{ route('purchases.index') }}" class="btn btn-outline-secondary">Clear</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- SUMMARY SECTION - Responsive Cards --}}
    <div class="row g-2 mb-4">
        <div class="col-6 col-md-6">
            <div class="card border-0 shadow-sm bg-primary text-white text-center p-2">
                <small class="d-block opacity-75">Today ({{ now()->format('d M') }})</small>
                <h4 class="mb-0 fw-bold">{{ number_format($dailyPurchase, 2) }}</h4>
            </div>
        </div>
        <div class="col-6 col-md-6">
            <div class="card border-0 shadow-sm bg-success text-white text-center p-2">
                <small class="d-block opacity-75">{{ now()->format('F') }}</small>
                <h4 class="mb-0 fw-bold">{{ number_format($monthlyPurchase, 2) }}</h4>
            </div>
        </div>
    </div>

    {{-- PURCHASE TABLE - Responsive Data Layout --}}
    <div class="card border-0 shadow-sm">
        <div class="table-responsive d-none d-md-block">
            {{-- Table view for Desktop --}}
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr class="text-secondary small text-uppercase">
                        <th>Invoice</th>
                        <th>Medicine</th>
                        <th>Supplier</th>
                        <th>Date</th>
                        <th class="text-center">Qty</th>
                        <th>Total</th>
                        <th>Expiry</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purchases as $purchase)
                    <tr>
                        <td class="fw-bold text-primary">{{ $purchase->invoice_no }}</td>
                        <td>
                            <div class="fw-bold">{{ $purchase->medicine->name ?? 'Deleted Medicine' }}</div>
                            <small class="text-muted">Price: {{ number_format($purchase->price, 2) }}</small>
                        </td>
                        <td>{{ $purchase->supplier_name }}</td>
                        <td class="small">{{ $purchase->created_at->format('d-m-Y') }}</td>
                        <td class="text-center"><span class="badge bg-light text-dark border">{{ $purchase->quantity }}</span></td>
                        <td class="fw-bold">{{ number_format($purchase->total_amount, 2) }}</td>
                        <td>
                            @if($purchase->expiry_date)
                                <span class="small {{ \Carbon\Carbon::parse($purchase->expiry_date)->isPast() ? 'text-danger fw-bold' : '' }}">
                                    {{ $purchase->expiry_date }}
                                </span>
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('purchases.edit', $purchase->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Card view for Mobile --}}
        <div class="d-md-none">
            @foreach ($purchases as $purchase)
            <div class="p-3 border-bottom">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <span class="badge bg-soft-primary text-primary mb-1" style="background-color: #e7f1ff;">{{ $purchase->invoice_no }}</span>
                        <h6 class="mb-0 fw-bold">{{ $purchase->medicine->name ?? 'Deleted Medicine' }}</h6>
                        <small class="text-muted">{{ $purchase->supplier_name }}</small>
                    </div>
                    <div class="text-end">
                        <div class="fw-bold text-success">{{ number_format($purchase->total_amount, 2) }}</div>
                        <small class="text-muted">{{ $purchase->created_at->format('d M, Y') }}</small>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center bg-light p-2 rounded small">
                    <span>Qty: <strong>{{ $purchase->quantity }}</strong></span>
                    <span>Price: <strong>{{ number_format($purchase->price, 2) }}</strong></span>
                    <span>Exp: <strong class="{{ \Carbon\Carbon::parse($purchase->expiry_date)->isPast() ? 'text-danger' : '' }}">{{ $purchase->expiry_date ?? 'N/A' }}</strong></span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $purchases->links() }}
    </div>

</div>

<style>
    /* Pagination adjustments for mobile */
    .pagination {
        flex-wrap: wrap;
        justify-content: center;
    }

    @media (max-width: 767.98px) {
        .container { padding-left: 10px; padding-right: 10px; }
        h2 { font-size: 1.25rem; }
    }
</style>
@endsection
