@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add Extra Income</h2>

    <form action="{{ route('extra_income.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Description</label>
            <input type="text" name="description" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Amount (TK)</label>
            <input type="number" step="0.01" name="amount" class="form-control" required>
        </div>

      <br>

        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
