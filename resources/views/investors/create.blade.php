@extends('layouts.app')

@section('content')
<div class="container mt-3 pb-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold">🤝 Add Investment</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('investors.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="fw-bold text-secondary mb-1">Select Investor</label>
                            <select name="investor_name" class="form-select form-select-lg" required>
                                <option value="">-- Choose Investor --</option>
                                <option value="SEC">SEC</option>
                                <option value="Thouhid">Thouhid</option>
                            </select>
                            <small class="text-muted">Choose the name of the person/entity providing funds.</small>
                        </div>

                        <div class="mb-4">
                            <label class="fw-bold text-secondary mb-1">Investment Amount</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-light text-success fw-bold">TK</span>
                                <input type="number" name="amount" class="form-control fw-bold" step="0.01" placeholder="0.00" required>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg fw-bold shadow-sm">
                                Confirm Investment
                            </button>
                            <a href="{{ route('investors.index') }}" class="btn btn-light btn-sm text-secondary">
                                Cancel & View All
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Ensure the form looks great on small mobile screens */
    @media (max-width: 767.98px) {
        .card-body { padding: 1.5rem; }
        .form-select-lg, .input-group-lg .form-control {
            font-size: 1.1rem;
        }
    }
</style>
@endsection
