@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Reports</h2>
    <ul>
        <li><a href="{{ route('reports.sales') }}">Sales Report</a></li>
        <li><a href="{{ route('reports.purchases') }}">Purchase Report</a></li>
        {{-- <li><a href="{{ route('reports.stock') }}">Stock Report</a></li> --}}
        <li><a href="{{ route('reports.profitLoss') }}">Profit / Loss Report</a></li>
    </ul>
</div>
@endsection
