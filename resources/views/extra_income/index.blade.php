@extends('layouts.app')

@section('content')


<div class="container">
    <h2>Extra Income</h2>
    <a href="{{ route('extra_income.create') }}" class="btn btn-primary mb-2">Add New Income</a>

    <form method="GET" action="{{ route('extra_income.index') }}" class="mb-3">
        <label>From:</label>
        <input type="date" name="from_date" value="{{ request('from_date') }}" required>

        <label>To:</label>
        <input type="date" name="to_date" value="{{ request('to_date') }}" required>

        <button type="submit" class="btn btn-primary">Calculate</button>
    </form>


    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Description</th>
                <th>Amount (TK)</th>
                {{-- <th>Action</th> --}}
            </tr>
            <h4>Monthly Extra Income: {{ number_format($monthlyIncome, 2) }} Tk</h4>

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

@if(!is_null($filteredIncome))
    <div class="alert alert-info mt-3">
        <strong>Total Extra Income ({{ request('from_date') }} to {{ request('to_date') }}):</strong>
        {{ number_format($filteredIncome, 2) }} Tk
    </div>
@endif

@endsection
