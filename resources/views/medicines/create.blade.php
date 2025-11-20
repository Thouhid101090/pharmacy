@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add Medicine</h2>

    {{-- <form action="{{ route('medicines.store') }}" method="POST">
        @csrf

        <div class="form-group mb-2">
            <label>Medicine Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="form-group mb-2">
            <label>Generic Name</label>
            <input type="text" name="generic_name" class="form-control" required>
        </div>

        <div class="form-group mb-2">
            <label>Company Name</label>
            <input type="text" name="company_name" class="form-control" required>
        </div>

        <div class="form-group mb-2">
            <label>Use For</label>
            <input type="text" name="use_for" class="form-control">
        </div>











        <button type="submit" class="btn btn-success mt-3">Save</button>
        <a href="{{ route('medicines.index') }}" class="btn btn-secondary mt-3">Cancel</a>
    </form> --}}

    <form action="{{ route('medicines.storeMultiple') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Company Name:</label>
            <input type="text" name="company_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Medicine Names (one per line):</label>
            <textarea name="names" class="form-control" rows="6" placeholder="Enter one medicine per line" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Save All</button>
    </form>

</div>
@endsection
