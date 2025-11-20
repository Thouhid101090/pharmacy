@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Investments</h2>
    <a href="{{ route('investments.create') }}" class="btn btn-primary mb-3">Add Investment</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Amount (Tk)</th>
                <th>Cost For</th>
            </tr>
        </thead>
        <tbody>
            @foreach($investments as $investment)
            <tr>
                <td>{{ number_format($investment->amount, 2) }}</td>
                <td>{{ $investment->cost_for }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Total Investment: <strong>{{ number_format($totalInvestment, 2) }} Tk</strong></h4>

    <hr>

    <h3>Investor Ownership Percentage</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Investor Name</th>
                <th>Invested Amount (Tk)</th>
                <th>Ownership (%)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ownerships as $owner)
            <tr>
                <td>{{ $owner['name'] }}</td>
                <td>{{ number_format($owner['amount'], 2) }}</td>
                <td>{{ $owner['percentage'] }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
