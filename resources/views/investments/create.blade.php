@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add Investment</h2>

    <form action="{{ route('investments.store') }}" method="POST">
        @csrf


        <div class="form-group">
            <label>Cost For</label>
            <input type="text" name="cost_for" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Amount</label>
            <input type="number" name="amount" step="0.01" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success mt-2">Save</button>
    </form>
</div>
@endsection
