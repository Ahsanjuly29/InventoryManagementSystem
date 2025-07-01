@extends('layouts.app')

@section('content')
    <h2>Create Sale</h2>

    <form action="{{ route('sales.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="prod_id">Product</label>
            <select name="product_id" id="prod_id" class="form-control" required></select>
        </div>

        <div class="form-group">
            <label for="customer_id">Customer</label>
            <select name="customer_id" id="customer_id" class="form-control" required></select>
            <small>Existing Due: <span id="existing_due">0.00</span> TK</small>
        </div>

        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" id="quantity" min="1" class="form-control" required
                value="{{ old('quantity') }}">
        </div>

        <div class="form-group">
            <label for="sell_price">Selling Price per Unit</label>
            <input type="number" name="sell_price" id="sell_price" class="form-control" readonly>
        </div>

        <div class="form-group">
            <label for="discount">Discount (TK)</label>
            <input type="number" name="discount" id="discount" step="0.01" class="form-control"
                value="{{ old('discount', 0) }}">
        </div>

        <div class="form-group">
            <label for="vat">VAT (%)</label>
            <input type="number" name="vat" id="vat" step="0.01" class="form-control"
                value="{{ old('vat', 5) }}">
        </div>

        <div class="form-group">
            <label for="customer_paid_amount">Customer Paid Amount (TK)</label>
            <input type="number" name="customer_paid_amount" id="customer_paid_amount" step="0.01" class="form-control"
                value="{{ old('customer_paid_amount', 0) }}" required>
        </div>

        <div class="form-group">
            <label for="total">Total Amount (TK)</label>
            <input type="number" id="total" class="form-control" readonly>
        </div>

        <div class="form-group">
            <label for="grand_total">Grand Total (After Discount + VAT)</label>
            <input type="number" id="grand_total" class="form-control" readonly>
        </div>

        <div class="form-group">
            <label for="due">This Sale Due</label>
            <input type="number" id="due" name="due" class="form-control" readonly>
        </div>

        <div class="form-group">
            <label for="due_after_payment">This Customer's Due After This Sale (TK)</label>
            <input type="number" id="due_after_payment" class="form-control" readonly>
        </div>

        <button type="submit" class="btn btn-success">Submit Sale</button>
    </form>
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {

            const oldProductId = "{{ old('product_id') }}";
            const oldCustomerId = "{{ old('customer_id') }}";

            let productData = {};
            let customerData = {};

            function setup(selector, url, format) {
                const s = $(selector);

                s.select2({
                    placeholder: 'Search...',
                    minimumInputLength: 0,
                    ajax: {
                        url: url,
                        dataType: 'json',
                        delay: 250,
                        data: params => ({
                            q: params.term || ''
                        }),
                        processResults: data => ({
                            results: data.map(format)
                        }),
                        cache: true
                    }
                });

                s.on('select2:open', () => {
                    if (!s.data('loaded-default')) {
                        $.getJSON(url, {
                            q: ''
                        }, items => {
                            items.forEach(i => {
                                const opt = new Option(format(i).text, i.id, false, false);
                                s.append(opt);
                            });
                            s.data('loaded-default', true);
                            s.select2('open');
                        });
                    }
                });
            }

            setup('#prod_id', '{{ route('products.search') }}', p => ({
                id: p.id,
                text: `${p.name} (Stock: ${p.quantity})`
            }));

            setup('#customer_id', '{{ route('customers.search') }}', c => ({
                id: c.id,
                text: `${c.name} (${c.phone})`
            }));

            if (oldProductId) {
                $.ajax({
                    type: 'GET',
                    url: `/products/${oldProductId}`
                }).then(function(data) {
                    productData = data;
                    const option = new Option(`${data.name} (Stock: ${data.quantity})`, data.id, true,
                        true);
                    $('#prod_id').append(option).trigger('change');
                    $('#sell_price').val(data.sell_price);
                    calculateTotals();
                });
            }

            if (oldCustomerId) {
                $.ajax({
                    type: 'GET',
                    url: `/customers/${oldCustomerId}`
                }).then(function(data) {
                    customerData = data;
                    const option = new Option(`${data.name} (${data.phone})`, data.id, true, true);
                    $('#customer_id').append(option).trigger('change');
                    $('#existing_due').text(data.due ? data.due.toFixed(2) : '0.00');
                    calculateTotals();
                });
            }

            function calculateTotals() {
                const quantity = parseFloat($('#quantity').val()) || 0;
                const sell_price = parseFloat($('#sell_price').val()) || 0;
                const discount = parseFloat($('#discount').val()) || 0;
                const vat_percent = parseFloat($('#vat').val()) || 0;
                const paid = parseFloat($('#customer_paid_amount').val()) || 0;

                const subtotal = quantity * sell_price;
                const discounted_total = subtotal - discount;
                const vat_amount = (discounted_total * vat_percent) / 100;
                const grand_total = discounted_total + vat_amount;

                const this_due = grand_total - paid;
                const existing_due = parseFloat(customerData.due) || 0;
                const total_due = existing_due + this_due;

                $('#total').val(subtotal.toFixed(2));
                $('#grand_total').val(grand_total.toFixed(2));
                $('#due').val(this_due > 0 ? this_due.toFixed(2) : '0.00');
                $('#due_after_payment').val(total_due > 0 ? total_due.toFixed(2) : '0.00');
                $('#existing_due').text(existing_due.toFixed(2));
            }

            $('#prod_id').on('change', function() {
                const id = $(this).val();
                if (id) {
                    $.get(`/products/${id}`, function(data) {
                        productData = data;
                        $('#sell_price').val(data.sell_price);
                        calculateTotals();
                    });
                }
            });

            $('#customer_id').on('change', function() {
                const id = $(this).val();
                if (id) {
                    $.get(`/customers/${id}`, function(data) {
                        customerData = data;
                        calculateTotals();
                    });
                }
            });

            
            $('#quantity, #discount, #vat, #customer_paid_amount').on('input', calculateTotals);
        });
    </script>
@endsection
