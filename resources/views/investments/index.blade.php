@extends('layouts.app')

@section('content')
<div class="container mt-3 pb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 mb-0 fw-bold">Investments & Equity</h2>
        <a href="{{ route('investments.create') }}" class="btn btn-primary shadow-sm">+ Add New</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    {{-- TOTAL INVESTMENT SUMMARY CARD --}}
    <div class="card border-0 shadow-sm bg-dark text-white mb-4">
        <div class="card-body p-4 text-center">
            <small class="text-uppercase opacity-75 fw-bold">Total Capital Invested</small>
            <h1 class="display-6 fw-bold mb-0">TK {{ number_format($totalInvestment, 2) }}</h1>
        </div>
    </div>

    <div class="row">
        {{-- LEFT COLUMN: INVESTMENT RECORDS --}}
        <div class="col-12 col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light py-3">
                    <h6 class="mb-0 fw-bold text-secondary">Asset / Cost Records</h6>
                </div>

                {{-- Desktop Table --}}
                <div class="table-responsive d-none d-md-block">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr class="small text-muted text-uppercase">
                                <th class="ps-3">Cost For</th>
                                <th class="text-end pe-3">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($investments as $investment)
                            <tr>
                                <td class="ps-3 fw-bold text-dark">{{ $investment->cost_for }}</td>
                                <td class="text-end pe-3">{{ number_format($investment->amount, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Mobile List --}}
                <div class="d-md-none">
                    @foreach($investments as $investment)
                    <div class="p-3 border-bottom d-flex justify-content-between">
                        <span class="text-secondary">{{ $investment->cost_for }}</span>
                        <span class="fw-bold">TK {{ number_format($investment->amount, 2) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: OWNERSHIP PERCENTAGE --}}
        <div class="col-12 col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light py-3">
                    <h6 class="mb-0 fw-bold text-secondary">Investor Ownership</h6>
                </div>
                <div class="card-body p-0">
                    @foreach($ownerships as $owner)
                    <div class="p-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <h6 class="mb-0 fw-bold text-primary">{{ $owner['name'] }}</h6>
                                <small class="text-muted">Total: {{ number_format($owner['amount'], 2) }}</small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-soft-primary text-primary px-3 py-2" style="background-color: #eef2ff;">
                                    {{ $owner['percentage'] }}%
                                </span>
                            </div>
                        </div>
                        {{-- Visual Ownership Bar --}}
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-primary" role="progressbar"
                                 style="width: {{ $owner['percentage'] }}%"
                                 aria-valuenow="{{ $owner['percentage'] }}" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media (max-width: 767.98px) {
        .container { padding-left: 10px; padding-right: 10px; }
        .display-6 { font-size: 1.75rem; }
    }
</style>
@endsection
