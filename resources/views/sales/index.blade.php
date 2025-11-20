@extends('layouts.app')

@section('content')
<h2>All Sales</h2>
<a href="{{ route('sales.create') }}" class="btn btn-primary mb-3">New Sale</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered mt-3">
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
        <tr>
            <h4 class="text-right mb-3">
                Daily Total Sale ({{ now()->format('d-m-Y') }}):
                <span style="color: blue; font-weight:bold;">
                    {{ number_format($dailySale, 2) }}
                </span>
            </h4>
        </tr>

        <tr>
            <h4 class="text-right mb-3">
                Daily Profit ({{ now()->format('d-m-Y') }}):
                <span style="color: green; font-weight:bold;">
                    {{ number_format($dailyProfit, 2) }}
                </span>
            </h4>

        </tr>



        <tr>
            <h4 class="text-right">
                Total Profit ({{ now()->format('F Y') }}):
                <span style="color: green; font-weight:bold;">
                    {{ number_format($monthlyProfit, 2) }}
                </span>
            </h4>
        </tr>

    </tbody>
</table>
@endsection
