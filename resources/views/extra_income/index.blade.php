@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Extra Income</h2>
    <a href="{{ route('extra_income.create') }}" class="btn btn-primary mb-2">Add New Income</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Description</th>
                <th>Amount (TK)</th>
                {{-- <th>Action</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach($extraIncomes as $income)
            <tr>
                <td>{{ $income->created_at->format('d-m-Y') }}</td>
                <td>{{ $income->description }}</td>
                <td>{{ number_format($income->amount,2) }}</td>
                {{-- <td>
                    <form action="{{ route('extra_income.destroy', $income->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td> --}}
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
