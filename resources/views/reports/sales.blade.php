@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Sales Report</h2>
    <form method="POST" action="{{ route('reports.sales.report') }}">
        @csrf
        <label>From:</label>
        <input type="date" name="from_date" required>
        <label>To:</label>
        <input type="date" name="to_date" required>
        <button type="submit">Generate</button>
    </form>

    @isset($sales)
        <h3>Report Result:</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Invoice No</th>
                    <th>Medicine</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sales as $sale)
                <tr>
                    <td>{{ $sale->invoice_no }}</td>
                    <td>{{ $sale->medicine->name }}</td>
                    <td>{{ $sale->quantity }}</td>
                    <td>{{ $sale->total_price }}</td>
                    <td>{{ $sale->created_at->format('d-m-Y') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Grand Total:</th>
                    <th>
                        {{ $sales->sum(function($p){
                            return  $p->total_price;
                        }) }}
                    </th>

                </tr>
            </tfoot>
        </table>
    @endisset
</div>
@endsection
