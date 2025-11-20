@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Purchase</h2>

    <form action="{{ route('purchases.update', $purchase->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-2">
            <label>Invoice No</label>
            <input type="text" name="invoice_no" class="form-control" value="{{ $purchase->invoice_no }}" readonly>
        </div>

        <div class="mb-2">
            <label>Medicine</label>
            <select name="medicine_id" class="form-control" required>
                @foreach($medicines as $medicine)
                    <option value="{{ $medicine->id }}" {{ $purchase->medicine_id == $medicine->id ? 'selected' : '' }}>
                        {{ $medicine->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-2">
            <label>Supplier Name</label>
            <input type="text" name="supplier_name" class="form-control" value="{{ $purchase->supplier_name }}" required>
        </div>

        <div class="mb-2">
            <label>Purchase Date</label>
            <input type="date" name="purchase_date" class="form-control" value="{{ $purchase->purchase_date }}" required>
        </div>

        <div class="mb-2">
            <label>Quantity</label>
            <input type="number" name="quantity" class="form-control" value="{{ $purchase->quantity }}" required>
        </div>

        <div class="mb-2">
            <label>Price</label>
            <input type="number" step="0.01" name="price" class="form-control" value="{{ $purchase->price }}" required>
        </div>

        <div class="mb-2">
            <label>Expiry Date</label>
            <input type="date" name="expiry_date" class="form-control" value="{{ $purchase->expiry_date }}">
        </div>

        <button type="submit" class="btn btn-success mt-3">Update</button>
        <a href="{{ route('purchases.index') }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>
</div>
@endsection
