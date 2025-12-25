@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-12 col-md-7">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-white">Edit Purchase Record</h5>
                    <a href="{{ route('purchases.index') }}" class="btn btn-sm btn-light">Back</a>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('purchases.update', $purchase->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="fw-bold text-secondary small">Supplier Name</label>
                            <input type="text" name="supplier_name" class="form-control form-control-lg"
                                   value="{{ $purchase->supplier_name }}" required>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <label class="fw-bold text-secondary small">Medicine</label>
                            <select name="medicine_id" class="form-select form-select-lg" required>
                                @foreach($medicines as $medicine)
                                    <option value="{{ $medicine->id }}" {{ $purchase->medicine_id == $medicine->id ? 'selected' : '' }}>
                                        {{ $medicine->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="fw-bold text-secondary small">Quantity</label>
                                <input type="number" name="quantity" id="qty" class="form-control"
                                       value="{{ $purchase->quantity }}" min="1" required>
                            </div>
                            <div class="col-6">
                                <label class="fw-bold text-secondary small">Total Price (Item)</label>
                                <input type="number" step="0.01" name="total_amount" id="total"
                                       class="form-control" value="{{ $purchase->total_amount }}" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="fw-bold text-secondary small">Expiry Date</label>
                            <input type="date" name="expiry_date" class="form-control"
                            value="{{ $purchase->expiry_date ? \Carbon\Carbon::parse($purchase->expiry_date)->format('Y-m-d') : '' }}">
                        </div>

                        <div class="bg-light p-3 rounded text-center border mb-4">
                            <span class="text-muted small d-block">Cost per Unit</span>
                            <h3 class="mb-0 fw-bold text-dark">
                                TK <span id="unitPriceDisplay">{{ number_format($purchase->total_amount / $purchase->quantity, 2) }}</span>
                            </h3>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg fw-bold shadow-sm">
                                Save Changes
                            </button>
                            <a href="{{ route('purchases.index') }}" class="btn btn-link text-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const qtyInput = document.getElementById('qty');
    const totalInput = document.getElementById('total');
    const unitPriceDisplay = document.getElementById('unitPriceDisplay');

    function updateUnitPrice() {
        const qty = parseFloat(qtyInput.value) || 0;
        const total = parseFloat(totalInput.value) || 0;
        if (qty > 0) {
            unitPriceDisplay.innerText = (total / qty).toFixed(2);
        } else {
            unitPriceDisplay.innerText = "0.00";
        }
    }

    qtyInput.addEventListener('input', updateUnitPrice);
    totalInput.addEventListener('input', updateUnitPrice);
</script>
@endsection
