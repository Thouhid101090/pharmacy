@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 fw-bold">New Bulk Purchase</h5>
            <a href="{{ route('purchases.index') }}" class="btn btn-sm btn-light shadow-sm">
                Back to List
            </a>
        </div>

        <div class="card-body p-3">
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('purchases.store') }}" method="POST" id="purchaseForm">
                @csrf

                <div class="row mb-4">
                    <div class="col-12 col-md-6">
                        <label class="fw-bold text-secondary mb-1">Supplier Name</label>
                        <input type="text" name="supplier_name" class="form-control form-control-lg" placeholder="Enter supplier name" required>
                    </div>
                </div>

                <hr class="text-muted">

                <div class="row d-none d-md-flex mb-2 fw-bold text-secondary small text-uppercase">
                    <div class="col-md-4">Medicine</div>
                    <div class="col-md-2">Qty</div>
                    <div class="col-md-3">Total Price</div>
                    <div class="col-md-2">Expiry Date</div>
                    <div class="col-md-1 text-center">Action</div>
                </div>

                <div id="purchase-rows">
                    <div class="purchase-item-row border rounded p-3 mb-3 bg-white shadow-sm">
                        <div class="row g-3">
                            <div class="col-12 col-md-4">
                                <label class="d-md-none fw-bold small text-primary mb-1">Medicine Name</label>
                                <input type="text" class="form-control medicine-input" list="medicineList" placeholder="Search or Type New" autocomplete="off" required>
                                <input type="hidden" name="medicine_id[]" class="medicine-id-hidden">
                                <input type="hidden" name="medicine_name[]" class="medicine-name-hidden">
                            </div>
                            <div class="col-6 col-md-2">
                                <label class="d-md-none fw-bold small text-primary mb-1">Quantity</label>
                                <input type="number" name="quantity[]" class="form-control qty-input" min="1" value="1" required>
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="d-md-none fw-bold small text-primary mb-1">Total Price (Item)</label>
                                <input type="number" step="0.01" name="total_amount[]" class="form-control row-total-input" placeholder="0.00" required>
                            </div>
                            <div class="col-12 col-md-2">
                                <label class="d-md-none fw-bold small text-primary mb-1">Expiry Date</label>
                                <input type="date" name="expiry_date[]" class="form-control">
                            </div>
                            <div class="col-12 col-md-1 d-flex align-items-end justify-content-md-center">
                                <button type="button" class="btn btn-outline-danger remove-row w-100 w-md-auto">
                                    <span class="d-md-none">Remove Item</span>
                                    <i class="bi bi-trash"></i> ×
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4 align-items-center">
                    <div class="col-12 col-md-6 mb-3 mb-md-0">
                        <button type="button" class="btn btn-outline-success w-100 w-md-auto fw-bold" id="addMore">
                            + Add Another Item
                        </button>
                    </div>
                    <div class="col-12 col-md-6 text-md-end">
                        <div class="p-3 border rounded bg-light d-inline-block w-100 w-md-auto shadow-sm">
                            <span class="text-muted small text-uppercase d-block">Purchase Grand Total</span>
                            <h2 class="mb-0 fw-bold text-dark">
                                $<span id="grandTotalDisplay">0.00</span>
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success btn-lg w-100 py-3 fw-bold shadow">
                        Save Bulk Purchase Record
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<datalist id="medicineList">
    @foreach ($medicines as $medicine)
        <option data-id="{{ $medicine->id }}" value="{{ $medicine->name }}">
    @endforeach
</datalist>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const purchaseRows = document.getElementById('purchase-rows');
    const addMoreBtn = document.getElementById('addMore');
    const grandTotalDisplay = document.getElementById('grandTotalDisplay');

    function calculateGrandTotal() {
        let grandTotal = 0;
        document.querySelectorAll('.row-total-input').forEach(input => {
            grandTotal += parseFloat(input.value) || 0;
        });
        grandTotalDisplay.innerText = grandTotal.toFixed(2);
    }

    addMoreBtn.addEventListener('click', function () {
        const newRow = `
            <div class="purchase-item-row border rounded p-3 mb-3 bg-white shadow-sm">
                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <label class="d-md-none fw-bold small text-primary mb-1">Medicine Name</label>
                        <input type="text" class="form-control medicine-input" list="medicineList" placeholder="Search or Type New" autocomplete="off" required>
                        <input type="hidden" name="medicine_id[]" class="medicine-id-hidden">
                        <input type="hidden" name="medicine_name[]" class="medicine-name-hidden">
                    </div>
                    <div class="col-6 col-md-2">
                        <label class="d-md-none fw-bold small text-primary mb-1">Quantity</label>
                        <input type="number" name="quantity[]" class="form-control qty-input" min="1" value="1" required>
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="d-md-none fw-bold small text-primary mb-1">Total Price (Item)</label>
                        <input type="number" step="0.01" name="total_amount[]" class="form-control row-total-input" placeholder="0.00" required>
                    </div>
                    <div class="col-12 col-md-2">
                        <label class="d-md-none fw-bold small text-primary mb-1">Expiry Date</label>
                        <input type="date" name="expiry_date[]" class="form-control">
                    </div>
                    <div class="col-12 col-md-1 d-flex align-items-end justify-content-md-center">
                        <button type="button" class="btn btn-outline-danger remove-row w-100 w-md-auto">
                            <span class="d-md-none">Remove Item</span>
                             ×
                        </button>
                    </div>
                </div>
            </div>`;
        purchaseRows.insertAdjacentHTML('beforeend', newRow);
    });

    purchaseRows.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-row') || e.target.parentElement.classList.contains('remove-row')) {
            if (purchaseRows.children.length > 1) {
                e.target.closest('.purchase-item-row').remove();
                calculateGrandTotal();
            }
        }
    });

    purchaseRows.addEventListener('input', function (e) {
        if (e.target.classList.contains('medicine-input')) {
            const val = e.target.value;
            const options = document.getElementById('medicineList').options;
            const row = e.target.closest('.purchase-item-row');
            const hiddenId = row.querySelector('.medicine-id-hidden');
            const hiddenName = row.querySelector('.medicine-name-hidden');

            hiddenId.value = "";
            hiddenName.value = val;

            for (let i = 0; i < options.length; i++) {
                if (options[i].value === val) {
                    hiddenId.value = options[i].getAttribute('data-id');
                    break;
                }
            }
        }
        calculateGrandTotal();
    });
});
</script>

<style>
    @media (max-width: 767.98px) {
        .purchase-item-row {
            border-top: 3px solid #0d6efd !important;
            background-color: #f8f9fa !important;
        }
        .container { padding-left: 10px; padding-right: 10px; }
    }
</style>
@endsection
