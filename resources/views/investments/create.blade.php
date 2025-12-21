@extends('layouts.app')

@section('content')
<div class="container mt-3 pb-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h4 mb-0 fw-bold text-dark">Investment Cost</h2>
                <a href="{{ route('investments.index') }}" class="btn btn-outline-primary btn-sm shadow-sm">
                    <i class="bi bi-list"></i> View List
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white py-3">
                    <h5 class="mb-0 fw-bold">➕ Record New Investment</h5>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('investments.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="fw-bold text-secondary mb-1">Cost For (Purpose)</label>
                            <input type="text" name="cost_for" class="form-control form-control-lg"
                                   placeholder="e.g. Shop Decoration, New Shelves" required>
                            <small class="text-muted">What is this investment being used for?</small>
                        </div>

                        <div class="mb-4">
                            <label class="fw-bold text-secondary mb-1">Amount (TK)</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-light fw-bold text-success">TK</span>
                                <input type="number" name="amount" step="0.01" class="form-control fw-bold"
                                       placeholder="0.00" required>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg fw-bold shadow-sm py-3">
                                Save Investment
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-3 p-3 bg-light rounded border">
                <small class="text-muted d-block">
                    <i class="bi bi-info-circle"></i>
                    This record will track business setup or expansion costs (capital expenditure).
                </small>
            </div>
        </div>
    </div>
</div>

<style>
    /* Mobile-first adjustments */
    @media (max-width: 767.98px) {
        .card-body { padding: 1.25rem; }
        .form-control-lg { font-size: 1rem; }
        h2 { font-size: 1.25rem; }
    }
</style>
@endsection
