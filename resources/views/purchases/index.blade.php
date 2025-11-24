@extends('layouts.app')

@section('content')
<div class="container mt-3">

    <h2>Purchases</h2>
    <a href="{{ route('purchases.create') }}" class="btn btn-primary mb-3">New Purchase</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- SUMMARY SECTION --}}
    <div class="table-responsive">
        <table class="table table-bordered text-center">
            <tr>
                <th>Today’s Purchase ({{ now()->format('d-m-Y') }})</th>
                <th>Monthly Purchase ({{ now()->format('F Y') }})</th>
            </tr>
            <tr>
                <td style="color: blue; font-weight:bold;">
                    {{ number_format($dailyPurchase, 2) }}
                </td>
                <td style="color: green; font-weight:bold;">
                    {{ number_format($monthlyPurchase, 2) }}
                </td>
            </tr>
        </table>
    </div>

    {{-- PURCHASE TABLE --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="text-center">
                <tr>
                    <th>Invoice</th>
                    <th>Medicine</th>
                    <th>Supplier</th>
                    <th>Date</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Expiry</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($purchases as $purchase)
                <tr>
                    <td>{{ $purchase->invoice_no }}</td>
                    <td>{{ $purchase->medicine->name }}</td>
                    <td>{{ $purchase->supplier_name }}</td>

                    {{-- Short Date Format for Mobile --}}
                    <td>{{ $purchase->created_at->format('d-m-Y') }}</td>

                    <td>{{ $purchase->quantity }}</td>
                    <td>{{ $purchase->price }}</td>
                    <td>{{ $purchase->total_amount }}</td>

                    {{-- Short expiry format --}}
                    <td>{{ \Carbon\Carbon::parse($purchase->expiry_date)->format('d-m-Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $purchases->links() }}
    </div>

</div>
@endsection
