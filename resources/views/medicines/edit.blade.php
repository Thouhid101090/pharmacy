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

        {{-- <div class="form-group mb-2">
            <label>Generic Name</label>
            <input type="text" name="generic_name" class="form-control" value="{{ $medicine->generic_name }}" >
        </div> --}}

        <div class="form-group mb-2">
            <label>Company Name</label>
            <input type="text" name="company_name" class="form-control" value="{{ $medicine->company_name }}" required>
        </div>

        {{-- <div class="form-group mb-2">
            <label>Use For</label>
            <input type="text" name="use_for" class="form-control" value="{{ $medicine->use_for }}">
        </div> --}}

        <button type="submit" class="btn btn-success mt-3">Update</button>
        <a href="{{ route('medicines.index') }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>
</div>
@endsection
