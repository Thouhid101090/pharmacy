@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">💰 Accounts Summary</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row mb-4 text-center">
        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h6>Total Savings</h6>
                <h4 class="text-success">{{ number_format($totalSavings, 2) }}</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h6>Expense (Cash)</h6>
                <h4 class="text-danger">{{ number_format($expenseFromCash, 2) }}</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h6>Expense (From Saving)</h6>
                <h4 class="text-danger">{{ number_format($expenseFromSaving, 2) }}</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h6>Remaining Savings</h6>
                <h4 class="text-primary">{{ number_format($remainingSavings, 2) }}</h4>
            </div>
        </div>
    </div>

    <a href="{{ route('accounts.create') }}" class="btn btn-primary mb-3">+ Add Entry</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Type</th>
                <th>Source</th>
                <th>Description</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($accounts as $acc)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ ucfirst($acc->type) }}</td>
                    <td>{{ $acc->source ? ucfirst($acc->source) : '-' }}</td>
                    <td>{{ $acc->description }}</td>
                    <td>{{ number_format($acc->amount, 2) }}</td>
                    <td>{{ $acc->created_at->format('d M Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
