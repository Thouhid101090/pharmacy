@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Investors List</h2>
    <a href="{{ route('investors.create') }}" class="btn btn-primary mb-3">Add Investor</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Investor Name</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($investors as $investor)
            <tr>
                <td>{{ $investor->investor_name }}</td>
                <td>{{ $investor->amount }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
