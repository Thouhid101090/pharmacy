@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Purchases</h2>
        <a href="{{ route('purchases.create') }}" class="btn btn-primary mb-3">New Purchase</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Medicine</th>
                    <th>Supplier</th>
                    <th>Purchase Date</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Expiry</th>
                    {{-- <th>Action</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($purchases as $purchase)
                    <tr>
                        <td>{{ $purchase->invoice_no }}</td>
                        <td>{{ $purchase->medicine->name }}</td>
                        <td>{{ $purchase->supplier_name }}</td>
                        <td>{{ $purchase->created_at }}</td>
                        <td>{{ $purchase->quantity }}</td>
                        <td>{{ $purchase->price }}</td>
                        <td>{{ $purchase->total_amount }}</td>
                        <td>{{ $purchase->expiry_date }}</td>
                        {{-- <td>
                    <a href="{{ route('purchases.edit', $purchase->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('purchases.destroy', $purchase->id) }}" method="POST" style="display:inline-block;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this purchase?')">Delete</button>
                    </form>
                </td> --}}
                    </tr>

                @endforeach
                <tr>
                    <h4>Today’s Purchase: <strong>{{ number_format($dailyPurchase, 2) }}</strong></h4>
                    <h4>Monthly Purchase: <strong>{{ number_format($monthlyPurchase, 2) }}</strong></h4>

                </tr>
            </tbody>
        </table>


        <div class="d-flex justify-content-center mt-3">
            {{ $purchases->links() }}
        </div>

    </div>
@endsection
