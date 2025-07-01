@extends('layouts.app')

@section('content')
    <h2>Edit Product</h2>

    <form method="POST" action="{{ route('products.update', $product) }}" id="productForm">
        @csrf @method('PUT')

        <div class="form-group">
            <label>Name</label>
            <input name="name" class="form-control" required value="{{ old('name', $product->name) }}">
        </div>

        <div class="form-group">
            <label>Buying Price</label>
            <input name="buying_price" type="number" step="0.01" class="form-control" required
                value="{{ old('buying_price', $product->buying_price) }}">
        </div>

        <div class="form-group">
            <label>Selling Price</label>
            <input name="sell_price" type="number" step="0.01" class="form-control" required
                value="{{ old('sell_price', $product->sell_price) }}">
        </div>

        <div class="form-group">
            <label>Quantity</label>
            <input name="quantity" type="number" class="form-control" required
                value="{{ old('quantity', $product->quantity) }}">
        </div>

        <button class="btn btn-primary">Update</button>
    </form>
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {
            $('#productForm').on('submit', function(e) {
                $('.frontend-error').remove();

                let $name = $('input[name="name"]');
                let $buyingPrice = $('input[name="buying_price"]');
                let $sellingPrice = $('input[name="sell_price"]');
                let $quantity = $('input[name="quantity"]');

                let name = $name.val().trim();
                let buyingPrice = parseFloat($buyingPrice.val());
                let sellingPrice = parseFloat($sellingPrice.val());
                let quantity = parseInt($quantity.val());

                let hasError = false;
                let errorMessage = '';

                if (!name || isNaN(buyingPrice) || isNaN(sellingPrice) || isNaN(quantity)) {
                    hasError = true;
                    errorMessage = 'All fields are required and must be valid.';
                } else if (sellingPrice <= buyingPrice) {
                    hasError = true;
                    errorMessage = 'Selling price should be more than buying price.';
                }

                if (hasError) {
                    e.preventDefault();

                    $sellingPrice.val(buyingPrice + 1);

                    const alertBox = `
                <div class="alert alert-danger frontend-error mt-3">
                    ${errorMessage}
                </div>
            `;
                    $('#productForm').before(alertBox);
                }
            });
        });
    </script>
@endsection
