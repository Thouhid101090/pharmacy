@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Medicine Stock</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Medicine Name</th>
                <th>Quantity</th>
                
                <th>Expiry Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($stocks as $stock)
                <tr @if($stock->quantity <= 5) style="background-color: #f8d7da;" @endif>
                    <td>{{ $stock->id }}</td>
                    <td>{{ $stock->medicine->name }}</td>
                    <td>{{ $stock->quantity }}</td>
                    <td>
                        @if($stock->expiry_date && \Carbon\Carbon::parse($stock->expiry_date)->isPast())
                            <span class="badge bg-danger">Expired</span>
                        @else
                            {{ $stock->expiry_date ?? '-' }}
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No stock available</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
