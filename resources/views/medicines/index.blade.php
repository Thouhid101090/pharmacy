@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between">
        <h2 class="mb-4">Medicines</h2>
        <a href="{{ route('medicines.create') }}" class="btn btn-primary mb-3">+</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Generic</th>
                <th>Company</th>
                <th>Use For</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($medicines as $medicine)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $medicine->name }}</td>
                <td>{{ $medicine->generic_name }}</td>
                <td>{{ $medicine->company_name }}</td>
                <td>{{ $medicine->use_for }}</td>

                <td>
                    <a href="{{ route('medicines.edit', $medicine->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('medicines.destroy', $medicine->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this medicine?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $medicines->links() }}
</div>
@endsection
