@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Purchase Report</h2>

    <form method="POST" action="{{ route('reports.purchases.report') }}">
        @csrf
        <label>From:</label>
        <input type="date" name="from_date" required>
        <label>To:</label>
        <input type="date" name="to_date" required>
        <button type="submit">Generate</button>
    </form>

    @isset($purchases)
        <h3>Report Result:</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Invoice No</th>
                    <th>Medicine</th>
                    <th>Supplier</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchases as $purchase)
                <tr>
                    <td>{{ $purchase->invoice_no }}</td>
                    <td>{{ $purchase->medicine->name ?? '-' }}</td>
                    <td>{{ $purchase->supplier_name ?? '-' }}</td>
                    <td>{{ $purchase->quantity }}</td>
                    <td>{{ $purchase->price }}</td>
                    <td>{{ $purchase->quantity * $purchase->price }}</td>
                    <td>{{ $purchase->created_at->format('d-m-Y') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" class="text-end">Grand Total:</th>
                    <th>
                        {{ $purchases->sum(function($p){
                            return $p->quantity * $p->price;
                        }) }}
                    </th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    @endisset
</div>
@endsection
