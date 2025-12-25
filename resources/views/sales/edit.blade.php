@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Edit Sale</h5>
                    <small class="opacity-75">Inv: {{ $sale->invoice_no }}</small>
                </div>

                <div class="card-body p-4">
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('sales.update', $sale->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="fw-bold small text-secondary">Medicine</label>
                            <select name="medicine_id" class="form-select form-select-lg" required>
                                @foreach($medicines as $medicine)
                                    <option value="{{ $medicine->id }}" {{ $sale->medicine_id == $medicine->id ? 'selected' : '' }}>
                                        {{ $medicine->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="fw-bold small text-secondary">Quantity</label>
                                <input type="number" name="quantity" id="quantity" class="form-control form-control-lg"
                                       value="{{ $sale->quantity }}" min="1" required>
                            </div>

                            <div class="col-6 mb-3">
                                <label class="fw-bold small text-secondary">Total Price (TK)</label>
                                <input type="number" step="0.01" name="total_price" id="total_price"
                                       class="form-control form-control-lg" value="{{ $sale->total_price }}" required>
                            </div>
                        </div>

                        <div class="bg-light p-3 rounded border mb-4 text-center">
                            <small class="text-muted d-block">Unit Selling Price</small>
                            <h4 class="mb-0 fw-bold text-primary">
                                TK <span id="unitPriceDisplay">{{ number_format($sale->selling_price, 2) }}</span>
                            </h4>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold shadow-sm">
                                Update Sale
                            </button>
                            <a href="{{ route('sales.index') }}" class="btn btn-link text-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const qtyInput = document.getElementById('quantity');
    const totalInput = document.getElementById('total_price');
    const unitPriceDisplay = document.getElementById('unitPriceDisplay');

    function updateUnitPrice() {
        const qty = parseFloat(qtyInput.value) || 0;
        const total = parseFloat(totalInput.value) || 0;

        if (qty > 0) {
            const unitPrice = total / qty;
            unitPriceDisplay.innerText = unitPrice.toFixed(2);
        } else {
            unitPriceDisplay.innerText = "0.00";
        }
    }

    qtyInput.addEventListener('input', updateUnitPrice);
    totalInput.addEventListener('input', updateUnitPrice);
</script>
@endsection
