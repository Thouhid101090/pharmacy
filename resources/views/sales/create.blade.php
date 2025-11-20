@extends('layouts.app')

@section('content')
<h2>Create Sale</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<form action="{{ route('sales.store') }}" method="POST">
    @csrf
    {{-- <div class="form-group">
        <label for="medicine_id">Medicine</label>
        <select name="medicine_id" id="medicine_id" class="form-control" required>
            <option value="">-- Select Medicine --</option>
            @foreach($medicines as $medicine)
                <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
            @endforeach
        </select>
    </div> --}}

    <div class="mb-2">
        <label>Medicine</label>
        <input type="text" id="medicine_name" class="form-control" list="medicineList"
            placeholder="Type medicine name" autocomplete="off" required>

        <datalist id="medicineList">
            @foreach ($medicines as $medicine)
                <option data-id="{{ $medicine->id }}" value="{{ $medicine->name }}"></option>
            @endforeach
        </datalist>

        <!-- Hidden input to store ID -->
        <input type="hidden" name="medicine_id" id="medicine_id" required>
    </div>

    <div class="form-group">
        <label for="quantity">Quantity</label>
        <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
    </div>

    {{-- <div class="form-group">
        <label for="selling_price">Selling Price</label>
        <input type="number" name="selling_price" id="selling_price" class="form-control" step="0.01" required>
    </div> --}}
    <div class="mb-3">
        <label>Total Price</label>
        <input type="number" step="0.01" id="total_price" name="total_price" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary mt-2">Save Sale</button>
</form>

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
