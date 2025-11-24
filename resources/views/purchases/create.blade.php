@extends('layouts.app')

@section('content')
<div class="container-sm mt-3">

    <h3 class="mb-3">New Purchase</h3>

    <form action="{{ route('purchases.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="fw-bold">Supplier Name</label>
            <input type="text" name="supplier_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="fw-bold">Medicine</label>
            <input type="text" id="medicine_name" name="medicine_name"
                   class="form-control"
                   list="medicineList"
                   placeholder="Type medicine name"
                   autocomplete="off" required>

            <datalist id="medicineList">
                @foreach ($medicines as $medicine)
                    <option data-id="{{ $medicine->id }}" value="{{ $medicine->name }}"></option>
                @endforeach
            </datalist>

            <input type="hidden" name="medicine_id" id="medicine_id" required>
        </div>

        <div class="mb-3">
            <label class="fw-bold">Quantity</label>
            <input type="number" name="quantity" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="fw-bold">Total Price</label>
            <input type="number" step="0.01" id="total_amount" name="total_amount" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="fw-bold">Expiry Date</label>
            <input type="date" name="expiry_date" class="form-control">
        </div>

        <div class="d-grid gap-2 mt-4">
            <button type="submit" class="btn btn-success btn-block">Save</button>
            <a href="{{ route('purchases.index') }}" class="btn btn-secondary btn-block">Cancel</a>
        </div>

    </form>
</div>

<script>
    document.getElementById('medicine_name').addEventListener('change', function () {
        var input = this.value;
        var list = document.getElementById('medicineList').childNodes;

        for (var i = 0; i < list.length; i++) {
            if (list[i].value === input) {
                document.getElementById('medicine_id').value = list[i].dataset.id;
                break;
            }
        }
    });
</script>

@endsection
