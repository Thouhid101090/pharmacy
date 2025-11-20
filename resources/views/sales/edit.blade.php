@extends('layouts.app')

@section('content')
<h2>Edit Sale</h2>

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<form action="{{ route('sales.update', $sale->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="medicine_id">Medicine</label>
        <select name="medicine_id" id="medicine_id" class="form-control" required>
            @foreach($medicines as $medicine)
                <option value="{{ $medicine->id }}"
                    {{ $sale->medicine_id == $medicine->id ? 'selected' : '' }}>
                    {{ $medicine->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="quantity">Quantity</label>
        <input type="number" name="quantity" id="quantity" class="form-control" value="{{ $sale->quantity }}" min="1" required>
    </div>

    <div class="form-group">
        <label for="selling_price">Selling Price</label>
        <input type="number" name="selling_price" id="selling_price" class="form-control" value="{{ $sale->selling_price }}" step="0.01" required>
    </div>

    <button type="submit" class="btn btn-primary mt-2">Update Sale</button>
</form>
@endsection
