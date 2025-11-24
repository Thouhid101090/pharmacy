@extends('layouts.app')

@section('content')
<div class="container col-12 col-md-6 pb-5">

    <h3 class="mb-4">➕ Add Account Entry</h3>

    <form action="{{ route('accounts.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Type</label>
            <select name="type" class="form-control" id="type" required>
                <option value="">Select Type</option>
                <option value="saving">Saving</option>
                <option value="expense">Expense</option>
            </select>
        </div>

        <div class="mb-3" id="sourceDiv" style="display:none;">
            <label>Source (for Expense)</label>
            <select name="source" class="form-control">
                <option value="">Select Source</option>
                <option value="cash">Cash</option>
                <option value="saving">Saving</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <input type="text" name="description" class="form-control">
        </div>

        <div class="mb-3">
            <label>Amount</label>
            <input type="number" step="0.01" name="amount" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success w-100 mb-2">Save</button>
        <a href="{{ route('accounts.index') }}" class="btn btn-secondary w-100">Cancel</a>
    </form>
</div>

<script>
    document.getElementById('type').addEventListener('change', function() {
        document.getElementById('sourceDiv').style.display =
            (this.value === 'expense') ? 'block' : 'none';
    });
</script>
@endsection
