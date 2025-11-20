@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Medicine</h2>

    <form action="{{ route('medicines.update', $medicine->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-2">
            <label>Medicine Name</label>
            <input type="text" name="name" class="form-control" value="{{ $medicine->name }}" required>
        </div>

        <div class="form-group mb-2">
            <label>Generic Name</label>
            <input type="text" name="generic_name" class="form-control" value="{{ $medicine->generic_name }}" required>
        </div>

        <div class="form-group mb-2">
            <label>Company Name</label>
            <input type="text" name="company_name" class="form-control" value="{{ $medicine->company_name }}" required>
        </div>

        <div class="form-group mb-2">
            <label>Use For</label>
            <input type="text" name="use_for" class="form-control" value="{{ $medicine->use_for }}">
        </div>

        <div class="form-group mb-2">
            <label>Strength</label>
            <input type="text" name="strength" class="form-control" value="{{ $medicine->strength }}">
        </div>

        <div class="form-group mb-2">
            <label>Form</label>
            <input type="text" name="form" class="form-control" value="{{ $medicine->form }}">
        </div>

        <div class="form-group mb-2">
            <label>Price</label>
            <input type="number" step="0.01" name="price" class="form-control" value="{{ $medicine->price }}" required>
        </div>

        <div class="form-group mb-2">
            <label>Stock</label>
            <input type="number" name="stock" class="form-control" value="{{ $medicine->stock }}" required>
        </div>

        <div class="form-group mb-2">
            <label>Expiry Date</label>
            <input type="date" name="expiry_date" class="form-control" value="{{ $medicine->expiry_date }}">
        </div>

        <div class="form-group mb-2">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="active" {{ $medicine->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $medicine->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success mt-3">Update</button>
        <a href="{{ route('medicines.index') }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>
</div>
@endsection
