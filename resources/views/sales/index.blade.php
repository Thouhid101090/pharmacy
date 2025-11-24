@extends('layouts.app')

@section('content')
<h2>All Sales</h2>
<a href="{{ route('sales.create') }}" class="btn btn-primary mb-3">New Sale</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<div class="table-responsive">
    <table class="table table-bordered mt-4">
        <thead class="text-center">
            <tr>
                <th>Daily Sale ({{ now()->format('d-m-Y') }})</th>
                <th>Daily Profit</th>
                <th>Monthly Sale ({{ now()->format('F Y') }})</th>
                <th>Monthly Profit</th>
            </tr>
        </thead>
        <tbody class="text-center">
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
        </tbody>
    </table>
</div>


<div class="table-responsive mt-3">
    <table class="table table-bordered">
        <thead class="text-center">
            <tr>
                <th>ID</th>
                <th>Medicine</th>
                <th>Qty</th>
                <th>Sell Price</th>
                <th>Total</th>
                <th>Profit</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach($sales as $sale)
            <tr>
                <td>{{ $sale->id }}</td>
                <td>{{ $sale->medicine->name }}</td>
                <td>{{ $sale->quantity }}</td>
                <td>{{ $sale->selling_price }}</td>
                <td>{{ $sale->total_price }}</td>
                <td><strong>{{ number_format($sale->profit, 2) }}</strong></td>
                <td>{{ $sale->created_at->format('d-m-Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
