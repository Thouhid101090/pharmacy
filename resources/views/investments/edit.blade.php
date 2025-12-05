@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Investments</h2>

    <form action="{{ route('investments.update', $medicine->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Cost For</label>
            <input type="text" name="cost_for" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Amount</label>
            <input type="number" name="amount" step="0.01" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success mt-3">Update</button>
        <a href="{{ route('investments.index') }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>
</div>
@endsection
