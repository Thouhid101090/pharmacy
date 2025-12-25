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

    {{-- Search Form (unchanged) --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-2">
            <form action="{{ route('sales.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control border-0 shadow-none" placeholder="Search medicine or customer..." value="{{ request('search') }}">
                    <button class="btn btn-primary px-4" type="submit"><i class="bi bi-search"></i> Search</button>
                    @if(request('search'))
                        <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary d-flex align-items-center">Clear</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Summary Section (unchanged) --}}
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
                        <th>Action</th> {{-- New Column --}}
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
                        <td>
                            <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                        </td>
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
                        {{-- Added Edit Icon for Mobile --}}
                        <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-sm btn-light border py-0 px-2 mt-1">
                            <i class="bi bi-pencil text-primary"></i> Edit
                        </a>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center bg-light p-2 rounded small">
                    <span>Qty: <strong>{{ $sale->quantity }}</strong></span>
                    <span class="text-success fw-bold">Profit: {{ number_format($sale->profit, 2) }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $sales->links() }}
    </div>
</div>
@endsection
