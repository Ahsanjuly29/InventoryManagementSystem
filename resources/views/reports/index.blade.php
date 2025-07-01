@extends('layouts.app')

@section('content')
    <style>
        @media print {
            #filter-form {
                display: none !important;
            }
        }
    </style>

    <h2>Financial Report</h2>
    <form method="GET" action="{{ route('reports.index') }}" class="form-inline mb-4" id="filter-form">
        <div class="form-group mr-2">
            <label for="from" class="mr-2">From:</label>
            <input type="date" name="from" id="from" value="{{ $from ?? '' }}" class="form-control" />
        </div>
        <div class="form-group mr-2">
            <label for="to" class="mr-2">To:</label>
            <input type="date" name="to" id="to" value="{{ $to ?? '' }}" class="form-control" />
        </div>
        <button type="submit" class="btn btn-primary mr-2">Filter</button>
        <button type="button" class="btn btn-secondary" id="print-btn">Print</button>
    </form>

    <ul class="list-group">
        <li class="list-group-item">Total Sales: <strong>{{ number_format($totalSales, 2) }}</strong></li>
        <li class="list-group-item">Total Discount: <strong>{{ number_format($totalDiscount, 2) }}</strong></li>
        <li class="list-group-item">Total VAT: <strong>{{ number_format($totalVAT, 2) }}</strong></li>
        <li class="list-group-item">Total Paid: <strong>{{ number_format($totalPaid, 2) }}</strong></li>
        <li class="list-group-item">Total Due: <strong>{{ number_format($totalDue, 2) }}</strong></li>
        <li class="list-group-item">Total Profit: <strong>{{ number_format($totalProfit, 2) }}</strong></li>
    </ul>

    <hr>

    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Date</th>
                <th>Product</th>
                <th>Customer</th>
                <th>Qty</th>
                <th>Total</th>
                <th>Paid</th>
                <th>Due</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
                <tr>
                    <td>{{ $sale->created_at->format('Y-m-d') }}</td>
                    <td>{{ $sale->product->name ?? '-' }}</td>
                    <td>{{ $sale->customer->name ?? '-' }}</td>
                    <td>{{ $sale->quantity }}</td>
                    <td>{{ number_format($sale->total, 2) }}</td>
                    <td>{{ number_format($sale->customer_paid_amount, 2) }}</td>
                    <td>{{ number_format($sale->due, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection


@section('scripts')
    <script>
        document.getElementById('print-btn').addEventListener('click', function() {
            window.print();
        });
    </script>
@endsection
