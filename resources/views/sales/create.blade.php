@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 fw-bold text-primary">Create Sale (Bulk)</h5>
            <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-list"></i> List
            </a>
        </div>

        <div class="card-body p-3">
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('sales.store') }}" method="POST" id="saleForm">
                @csrf

                <div class="row d-none d-md-flex mb-2 fw-bold text-secondary text-uppercase" style="font-size: 0.85rem;">
                    <div class="col-md-5">Medicine</div>
                    <div class="col-md-3">Quantity</div>
                    <div class="col-md-3">Total Price</div>
                    <div class="col-md-1 text-center">Action</div>
                </div>

                <div id="sale-rows">
                    <div class="sale-item-row border rounded p-3 mb-3 bg-light shadow-sm position-relative">
                        <div class="row g-3">
                            <div class="col-12 col-md-5">
                                <label class="d-md-none fw-bold small mb-1">Medicine</label>
                                <input type="text" class="form-control medicine-input" list="medicineList" placeholder="Search medicine..." autocomplete="off" required>
                                <input type="hidden" name="medicine_id[]" class="medicine-id-hidden">
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="d-md-none fw-bold small mb-1">Quantity</label>
                                <input type="number" name="quantity[]" class="form-control qty-input" min="1" value="1" required>
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="d-md-none fw-bold small mb-1">Total Price</label>
                                <input type="number" step="0.01" name="total_price[]" class="form-control row-total-input" placeholder="0.00" required>
                            </div>
                            <div class="col-12 col-md-1 d-flex align-items-end justify-content-md-center">
                                <button type="button" class="btn btn-outline-danger remove-row w-100 w-md-auto">
                                    <span class="d-md-none">Remove Item</span>
                                    <i class="bi bi-trash d-none d-md-inline"></i> ×
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4 align-items-center">
                    <div class="col-12 col-md-6 mb-3 mb-md-0 text-center text-md-start">
                        <button type="button" class="btn btn-success px-4" id="addMore">
                            + Add Another Medicine
                        </button>
                    </div>
                    <div class="col-12 col-md-6 text-center text-md-end">
                        <div class="p-2 border rounded bg-white d-inline-block w-100 w-md-auto shadow-sm">
                            <span class="text-secondary small text-uppercase">Grand Total:</span>
                            <h3 class="mb-0 fw-bold text-success">
                                <span id="grandTotalDisplay">0.00</span>
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" id="submitBtn" class="btn btn-primary btn-lg w-100 py-3 fw-bold shadow">
                        Confirm & Save Sale
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
    const saleForm = document.getElementById('saleForm');
    const submitBtn = document.getElementById('submitBtn');
    const saleRows = document.getElementById('sale-rows');
    const addMoreBtn = document.getElementById('addMore');
    const grandTotalDisplay = document.getElementById('grandTotalDisplay');

    // Handle Form Submission - Disable button to prevent double clicks
    saleForm.addEventListener('submit', function () {
        // Only disable if the form passes browser validation
        if (saleForm.checkValidity()) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...`;
        }
    });

    function calculateGrandTotal() {
        let grandTotal = 0;
        document.querySelectorAll('.row-total-input').forEach(input => {
            grandTotal += parseFloat(input.value) || 0;
        });
        grandTotalDisplay.innerText = grandTotal.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
    }

    addMoreBtn.addEventListener('click', function () {
        const newRow = `
            <div class="sale-item-row border rounded p-3 mb-3 bg-light shadow-sm position-relative">
                <div class="row g-3">
                    <div class="col-12 col-md-5">
                        <label class="d-md-none fw-bold small mb-1">Medicine</label>
                        <input type="text" class="form-control medicine-input" list="medicineList" placeholder="Search medicine..." autocomplete="off" required>
                        <input type="hidden" name="medicine_id[]" class="medicine-id-hidden">
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="d-md-none fw-bold small mb-1">Quantity</label>
                        <input type="number" name="quantity[]" class="form-control qty-input" min="1" value="1" required>
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="d-md-none fw-bold small mb-1">Total Price</label>
                        <input type="number" step="0.01" name="total_price[]" class="form-control row-total-input" placeholder="0.00" required>
                    </div>
                    <div class="col-12 col-md-1 d-flex align-items-end justify-content-md-center">
                        <button type="button" class="btn btn-outline-danger remove-row w-100 w-md-auto">
                            <span class="d-md-none">Remove Item</span>
                             ×
                        </button>
                    </div>
                </div>
            </div>`;
        saleRows.insertAdjacentHTML('beforeend', newRow);
    });

    saleRows.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-row') || e.target.parentElement.classList.contains('remove-row')) {
            if (saleRows.children.length > 1) {
                e.target.closest('.sale-item-row').remove();
                calculateGrandTotal();
            }
        }
    });

    saleRows.addEventListener('input', function (e) {
        if (e.target.classList.contains('medicine-input')) {
            const val = e.target.value;
            const options = document.getElementById('medicineList').options;
            const hiddenInput = e.target.closest('.sale-item-row').querySelector('.medicine-id-hidden');
            hiddenInput.value = "";
            for (let i = 0; i < options.length; i++) {
                if (options[i].value === val) {
                    hiddenInput.value = options[i].getAttribute('data-id');
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
        .sale-item-row {
            border-left: 4px solid #0d6efd !important;
        }
    }
</style>
@endsection
