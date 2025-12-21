@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 fw-bold">Add Extra Income (Bulk)</h5>
            <a href="{{ route('extra_income.index') }}" class="btn btn-sm btn-light">
                Back to List
            </a>
        </div>

        <div class="card-body p-3">
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('extra_income.store') }}" method="POST">
                @csrf

                <div class="row d-none d-md-flex mb-2 fw-bold text-secondary small text-uppercase">
                    <div class="col-md-8">Description</div>
                    <div class="col-md-3">Amount (TK)</div>
                    <div class="col-md-1 text-center">Action</div>
                </div>

                <div id="income-rows">
                    <div class="income-item-row border rounded p-3 mb-3 bg-light shadow-sm">
                        <div class="row g-3">
                            <div class="col-12 col-md-8">
                                <label class="d-md-none fw-bold small text-success mb-1">Description</label>
                                <input type="text" name="description[]" class="form-control" placeholder="e.g. Consultation Fee" required>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="d-md-none fw-bold small text-success mb-1">Amount (TK)</label>
                                <input type="number" step="0.01" name="amount[]" class="form-control income-amount" placeholder="0.00" required>
                            </div>
                            <div class="col-12 col-md-1 d-flex align-items-end justify-content-md-center">
                                <button type="button" class="btn btn-outline-danger remove-row w-100 w-md-auto">
                                    <span class="d-md-none">Remove</span> ×
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4 align-items-center">
                    <div class="col-12 col-md-6 mb-3 mb-md-0">
                        <button type="button" class="btn btn-outline-success fw-bold" id="addMore">
                            + Add Another Income
                        </button>
                    </div>
                    <div class="col-12 col-md-6 text-md-end">
                        <div class="p-2 border rounded bg-white d-inline-block w-100 w-md-auto shadow-sm">
                            <span class="text-muted small text-uppercase">Total Income:</span>
                            <h3 class="mb-0 fw-bold text-success">
                                TK <span id="grandTotalDisplay">0.00</span>
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success btn-lg w-100 py-3 fw-bold shadow">
                        Save All Income
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const incomeRows = document.getElementById('income-rows');
    const addMoreBtn = document.getElementById('addMore');
    const grandTotalDisplay = document.getElementById('grandTotalDisplay');

    function calculateTotal() {
        let total = 0;
        document.querySelectorAll('.income-amount').forEach(input => {
            total += parseFloat(input.value) || 0;
        });
        grandTotalDisplay.innerText = total.toFixed(2);
    }

    addMoreBtn.addEventListener('click', function () {
        const newRow = `
            <div class="income-item-row border rounded p-3 mb-3 bg-light shadow-sm">
                <div class="row g-3">
                    <div class="col-12 col-md-8">
                        <label class="d-md-none fw-bold small text-success mb-1">Description</label>
                        <input type="text" name="description[]" class="form-control" placeholder="Description" required>
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="d-md-none fw-bold small text-success mb-1">Amount (TK)</label>
                        <input type="number" step="0.01" name="amount[]" class="form-control income-amount" placeholder="0.00" required>
                    </div>
                    <div class="col-12 col-md-1 d-flex align-items-end justify-content-md-center">
                        <button type="button" class="btn btn-outline-danger remove-row w-100 w-md-auto">×</button>
                    </div>
                </div>
            </div>`;
        incomeRows.insertAdjacentHTML('beforeend', newRow);
    });

    incomeRows.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-row')) {
            if (incomeRows.children.length > 1) {
                e.target.closest('.income-item-row').remove();
                calculateTotal();
            }
        }
    });

    incomeRows.addEventListener('input', calculateTotal);
});
</script>
@endsection
