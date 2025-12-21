@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h4 mb-0 fw-bold">Investors List</h2>
        <a href="{{ route('investors.create') }}" class="btn btn-primary shadow-sm">+ Add Investment</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm bg-primary text-white mb-4">
        <div class="card-body p-3">
            <div class="row align-items-center text-center text-md-start">
                <div class="col-12 col-md-6">
                    <small class="opacity-75 text-uppercase fw-bold">Total Business Capital</small>
                    <h2 class="fw-bold mb-0">TK {{ number_format($investors->sum('amount'), 2) }}</h2>
                </div>
                <div class="col-12 col-md-6 text-md-end mt-2 mt-md-0">
                    <span class="badge bg-white text-primary">Active Investors: {{ $investors->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="table-responsive d-none d-md-block">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr class="text-secondary small text-uppercase">
                        <th class="ps-3">Investor Name</th>
                        <th class="text-end pe-3">Investment Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($investors as $investor)
                    <tr>
                        <td class="ps-3 fw-bold">
                            <i class="bi bi-person-circle me-2 text-primary"></i>{{ $investor->investor_name }}
                        </td>
                        <td class="text-end pe-3 fw-bold text-dark">
                            {{ number_format($investor->amount, 2) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="text-center py-4 text-muted">No investments recorded yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-md-none">
            @forelse($investors as $investor)
                <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0 fw-bold">{{ $investor->investor_name }}</h6>
                        <small class="text-muted">Capital Share</small>
                    </div>
                    <div class="text-end">
                        <span class="h6 mb-0 fw-bold text-primary">TK {{ number_format($investor->amount, 2) }}</span>
                    </div>
                </div>
            @empty
                <div class="p-4 text-center text-muted">No investments found.</div>
            @endforelse
        </div>
    </div>
</div>

<style>
    @media (max-width: 767.98px) {
        .container { padding-left: 12px; padding-right: 12px; }
        h2 { font-size: 1.5rem; }
    }
</style>
@endsection
