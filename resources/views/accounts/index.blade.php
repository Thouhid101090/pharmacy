@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="h4 mb-0 fw-bold">💰 Accounts Summary</h3>
        <a href="{{ route('accounts.create') }}" class="btn btn-primary shadow-sm">+ Add Entry</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    {{-- SUMMARY SECTION - Responsive Grid --}}
    <div class="row g-2 mb-4">
        <div class="col-6 col-md-3">
            <div class="card h-100 border-0 shadow-sm bg-white p-3 text-center">
                <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.7rem;">Total Savings</small>
                <h4 class="text-success fw-bold mb-0">{{ number_format($totalSavings, 2) }}</h4>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card h-100 border-0 shadow-sm bg-white p-3 text-center">
                <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.7rem;">Exp (Cash)</small>
                <h4 class="text-danger fw-bold mb-0">{{ number_format($expenseFromCash, 2) }}</h4>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card h-100 border-0 shadow-sm bg-white p-3 text-center">
                <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.7rem;">Exp (Savings)</small>
                <h4 class="text-danger fw-bold mb-0">{{ number_format($expenseFromSaving, 2) }}</h4>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card h-100 border-0 shadow-sm bg-primary text-white p-3 text-center">
                <small class="opacity-75 d-block text-uppercase fw-bold" style="font-size: 0.7rem;">Net Savings</small>
                <h4 class="fw-bold mb-0">{{ number_format($remainingSavings, 2) }}</h4>
            </div>
        </div>
    </div>

    {{-- TRANSACTIONS SECTION --}}
    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="card-header bg-light py-3">
            <h6 class="mb-0 fw-bold"><i class="bi bi-list-ul"></i> Recent Transactions</h6>
        </div>

        {{-- Desktop View --}}
        <div class="table-responsive d-none d-md-block">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr class="text-secondary small text-uppercase">
                        <th class="ps-3">Type</th>
                        <th>Source</th>
                        <th>Description</th>
                        <th class="text-end">Amount</th>
                        <th class="text-end pe-3">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($accounts as $acc)
                    <tr>
                        <td class="ps-3">
                            <span class="badge {{ $acc->type == 'saving' ? 'bg-success' : 'bg-danger' }}">
                                {{ ucfirst($acc->type) }}
                            </span>
                        </td>
                        <td>{{ $acc->source ? ucfirst($acc->source) : '-' }}</td>
                        <td>{{ $acc->description }}</td>
                        <td class="text-end fw-bold {{ $acc->type == 'saving' ? 'text-success' : 'text-danger' }}">
                            {{ $acc->type == 'expense' ? '-' : '+' }} {{ number_format($acc->amount, 2) }}
                        </td>
                        <td class="text-end pe-3 small text-muted">{{ $acc->created_at->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Mobile View --}}
        <div class="d-md-none">
            @forelse($accounts as $acc)
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                <div style="max-width: 70%;">
                    <div class="d-flex align-items-center mb-1">
                        <span class="badge {{ $acc->type == 'saving' ? 'bg-success' : 'bg-danger' }} me-2" style="font-size: 0.6rem;">
                            {{ strtoupper($acc->type) }}
                        </span>
                        <small class="text-muted">{{ $acc->created_at->format('d M Y') }}</small>
                    </div>
                    <h6 class="mb-0 fw-bold text-dark">{{ $acc->description ?: 'No description' }}</h6>
                    <small class="text-muted">Source: {{ $acc->source ? ucfirst($acc->source) : 'N/A' }}</small>
                </div>
                <div class="text-end">
                    <h6 class="fw-bold mb-0 {{ $acc->type == 'saving' ? 'text-success' : 'text-danger' }}">
                        {{ $acc->type == 'expense' ? '-' : '+' }}{{ number_format($acc->amount, 2) }}
                    </h6>
                </div>
            </div>
            @empty
            <div class="p-4 text-center text-muted">No transactions found</div>
            @endforelse
        </div>
    </div>
</div>

<style>
    @media (max-width: 767.98px) {
        .container { padding-left: 10px; padding-right: 10px; }
        h4 { font-size: 1.1rem; }
    }
</style>
@endsection
