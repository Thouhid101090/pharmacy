@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Profit & Loss Report</h2>

    <form method="POST" action="{{ route('reports.profitLoss.report') }}">
        @csrf
        <label>From:</label>
        <input type="date" name="from_date" required>
        <label>To:</label>
        <input type="date" name="to_date" required>
        <button type="submit">Generate</button>
    </form>

    @isset($totalSales)
        <h3>Report Result:</h3>
        <table class="table">
            <tr>
                <th>Total Sales</th>
                <td>{{ number_format($totalSales, 2) }}</td>
            </tr>
            <tr>
                <th>Total Purchases</th>
                <td>{{ number_format($totalPurchases, 2) }}</td>
            </tr>
            <tr>
                <th>Profit</th>
                <td>
                    @if($profit >= 0)
                        <span style="color:green;">+{{ number_format($profit, 2) }}</span>
                    @else
                        <span style="color:red;">{{ number_format($profit, 2) }}</span>
                    @endif
                </td>
            </tr>
        </table>
    @endisset
</div>
@endsection
