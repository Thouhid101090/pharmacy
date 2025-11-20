@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add Investor</h2>

    <form action="{{ route('investors.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Select Investor</label>
            <select name="investor_name" class="form-control" required>
                <option value="">-- Choose Investor --</option>
                <option value="SEC">SEC</option>
                <option value="Thouhid">Thouhid</option>
            </select>
        </div>

        <div class="form-group">
            <label>Amount</label>
            <input type="number" name="amount" class="form-control" step="0.01" required>
        </div>

        <button type="submit" class="btn btn-success mt-2">Add Investment</button>
    </form>
</div>
@endsection
