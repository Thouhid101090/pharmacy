@extends('layouts.app')

@section('content')
<h2>All Sales</h2>
<a href="{{ route('sales.create') }}" class="btn btn-primary mb-3">New Sale</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<table class="table table-responsive table-bordered mt-4">
    <tr>
        <th>Daily Sale ({{ now()->format('d-m-Y') }})</th>
        <th>Daily Profit ({{ now()->format('d-m-Y') }})</th>
        <th>Monthly Sale ({{ now()->format('F Y') }})</th>
        <th>Monthly Profit ({{ now()->format('F Y') }})</th>
    </tr>

    <tr>
        <td style="color: blue; font-weight:bold;">
            {{ number_format($dailySale, 2) }}
        </td>

        <td style="color: green; font-weight:bold;">
            {{ number_format($dailyProfit, 2) }}
        </td>

        <td style="color: green; font-weight:bold;">
            {{ number_format($monthlySale, 2) }}
        </td>

        <td style="color: green; font-weight:bold;">
            {{ number_format($monthlyProfit, 2) }}
        </td>
    </tr>
</table>
<table class="table table-responsive table-bordered mt-3">
    <thead>
        <tr>
            <th>ID</th>
            <th>Medicine</th>
            <th>Quantity</th>
            <th>Selling Price</th>
            <th>Total Price</th>
            <th>Profit</th>
            <th>Date</th>

        </tr>
    </thead>
    <tbody>
        @foreach($sales as $sale)
        <tr>
            <td>{{ $sale->id }}</td>
            <td>{{ $sale->medicine->name }}</td>
            <td>{{ $sale->quantity }}</td>
            <td>{{ $sale->selling_price }}</td>
            <td>{{ $sale->total_price }}</td>
            <td><strong>{{ number_format($sale->profit, 2) }}</strong></td>
            <td>{{ $sale->created_at->format('d-m-Y') }}</td>
            {{-- <td>
                <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-sm btn-warning">Edit</a>
            </td> --}}
        </tr>

        @endforeach






    </tbody>
</table>
@endsection
