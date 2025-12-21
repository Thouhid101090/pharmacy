@extends('layouts.app')

@section('content')
<div class="container mt-3 pb-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="mb-0 fw-bold">➕ Add Account Entry</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('accounts.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="fw-bold text-secondary mb-1">Type</label>
                            <select name="type" class="form-select form-select-lg" id="type" required>
                                <option value="">Select Type</option>
                                <option value="saving">Saving (Add Money)</option>
                                <option value="expense">Expense (Spend Money)</option>
                            </select>
                        </div>

                        <div class="mb-3 animate__animated animate__fadeIn" id="sourceDiv" style="display:none;">
                            <label class="fw-bold text-danger mb-1">Source (Deduct From)</label>
                            <select name="source" class="form-select">
                                <option value="">Select Source</option>
                                <option value="cash" selected>Cash (Daily Sale)</option>
                                <option value="saving">Savings Account</option>
                            </select>
                            <small class="text-muted">Where is this money being taken from?</small>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold text-secondary mb-1">Description</label>
                            <input type="text" name="description" class="form-control" placeholder="e.g. Electricity Bill or Personal Savings">
                        </div>

                        <div class="mb-4">
                            <label class="fw-bold text-secondary mb-1">Amount (TK)</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-light">TK</span>
                                <input type="number" step="0.01" name="amount" class="form-control fw-bold" placeholder="0.00" required>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg fw-bold shadow-sm">
                                Save Entry
                            </button>
                            <a href="{{ route('accounts.index') }}" class="btn btn-light btn-sm text-secondary">
                                Cancel & Go Back
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('type').addEventListener('change', function() {
        const sourceDiv = document.getElementById('sourceDiv');
        if (this.value === 'expense') {
            sourceDiv.style.display = 'block';
            // Optional: Make source required if it's an expense
            sourceDiv.querySelector('select').setAttribute('required', 'required');
        } else {
            sourceDiv.style.display = 'none';
            sourceDiv.querySelector('select').removeAttribute('required');
        }
    });
</script>

<style>
    /* Mobile optimization */
    @media (max-width: 767.98px) {
        .card-body { padding: 1.5rem; }
        .form-select-lg, .input-group-lg .form-control {
            font-size: 1rem;
        }
    }
</style>
@endsection
