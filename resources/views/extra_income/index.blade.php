@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h4 mb-0 fw-bold">Extra Income</h2>
        <a href="{{ route('extra_income.create') }}" class="btn btn-primary shadow-sm">+ Add New</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <div class="row align-items-center">
                <div class="col-12 col-md-4 mb-3 mb-md-0">
                    <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">Current Month Total</small>
                    <h3 class="text-success fw-bold mb-0">TK {{ number_format($monthlyIncome, 2) }}</h3>
                </div>
                <div class="col-12 col-md-8">
                    <form method="GET" action="{{ route('extra_income.index') }}" class="row g-2">
                        <div class="col-6 col-md-4">
                            <label class="small fw-bold text-muted">From</label>
                            <input type="date" name="from_date" class="form-control form-control-sm" value="{{ request('from_date') }}" required>
                        </div>
                        <div class="col-6 col-md-4">
                            <label class="small fw-bold text-muted">To</label>
                            <input type="date" name="to_date" class="form-control form-control-sm" value="{{ request('to_date') }}" required>
                        </div>
                        <div class="col-12 col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-dark btn-sm w-100">Calculate Range</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(!is_null($filteredIncome))
        <div class="alert alert-info border-0 shadow-sm d-flex justify-content-between align-items-center mb-4">
            <span>
                <i class="bi bi-calendar-range"></i>
                <strong>Range Total:</strong> {{ request('from_date') }} to {{ request('to_date') }}
            </span>
            <span class="h5 mb-0 fw-bold">TK {{ number_format($filteredIncome, 2) }}</span>
        </div>
    @endif

    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="table-responsive d-none d-md-block">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr class="text-secondary small text-uppercase">
                        <th class="ps-3">Date</th>
                        <th>Description</th>
                        <th class="text-end pe-3">Amount (TK)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($extraIncomes as $income)
                    <tr>
                        <td class="ps-3 text-muted">{{ $income->created_at->format('d-m-Y') }}</td>
                        <td class="fw-bold">{{ $income->description }}</td>
                        <td class="text-end pe-3 fw-bold text-success">{{ number_format($income->amount, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-4 text-muted">No income records found for this period.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-md-none">
            @forelse($extraIncomes as $income)
                <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-white">
                    <div>
                        <small class="text-muted d-block">{{ $income->created_at->format('d M, Y') }}</small>
                        <h6 class="mb-0 fw-bold">{{ $income->description }}</h6>
                    </div>
                    <div class="text-end">
                        <span class="h6 mb-0 fw-bold text-success">{{ number_format($income->amount, 2) }}</span>
                        <small class="text-muted d-block">TK</small>
                    </div>
                </div>
            @empty
                <div class="p-4 text-center text-muted">No records found.</div>
            @endforelse
        </div>
    </div>
</div>

<style>
    @media (max-width: 767.98px) {
        .container { padding-left: 12px; padding-right: 12px; }
        h3 { font-size: 1.4rem; }
    }
</style>
@endsection
