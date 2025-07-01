@extends('layouts.app')

@section('content')
<h2>Sales List</h2>

<a href="{{ route('sales.create') }}" class="btn btn-primary mb-3">Add New Sale</a>

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Product</th>
                <th>Customer</th>
                <th>Quantity</th>
                <th>Selling Price</th>
                <th>Discount</th>
                <th>VAT</th>
                <th>Final Amount</th>
                <th>Paid</th>
                <th>Due</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sales as $sale)
                <tr>
                    <td>{{ $sale->product->name }}</td>
                    <td>{{ $sale->customer->name }}</td>
                    <td>{{ $sale->quantity }}</td>
                    <td>{{ $sale->sell_price }}</td>
                    <td>{{ $sale->discount }}</td>
                    <td>{{ number_format($sale->vat, 2) }}</td>
                    <td>{{ number_format($sale->final, 2) }}</td>
                    <td>{{ number_format($sale->customer_paid_amount, 2) }}</td>
                    <td>{{ number_format($sale->due, 2) }}</td>
                    <td>{{ $sale->created_at->format('Y-m-d') }}</td>
                </tr>
            @empty
                <tr><td colspan="10">No sales recorded yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $sales->links() }}

@endsection
