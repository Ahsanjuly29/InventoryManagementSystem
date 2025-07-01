<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('product', 'customer')->latest()->paginate(15);
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        return view('sales.create');
    }


    public function store(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'customer_id' => 'required|exists:customers,id',
            'quantity' => 'required|integer|min:1|max:' . $product->quantity,
            'sell_price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'vat' => 'nullable|numeric|min:0',
            'customer_paid_amount' => 'required|numeric|min:0',
        ]);

        $quantity = $data['quantity'];
        $sell_price = $data['sell_price'];
        $discount = $data['discount'] ?? 0;
        $vatPercent = $data['vat'] ?? 0;
        $paid = $data['customer_paid_amount'];

        $subtotal = $quantity * $sell_price;
        $discounted_total = $subtotal - $discount;
        $vatAmount = ($discounted_total * $vatPercent) / 100;
        $grandTotal = $discounted_total + $vatAmount;

        $due = $grandTotal - $paid;
        $product->quantity -= $quantity;
        $product->save();

        $customer = Customer::findOrFail($data['customer_id']);
        $customer->due = ($customer->due ?? 0) + $due;
        $customer->save();

        Sale::create([
            'product_id' => $data['product_id'],
            'customer_id' => $data['customer_id'],
            'quantity' => $quantity,
            'sell_price' => $sell_price,
            'discount' => $discount,
            'vat' => $vatPercent,
            'total' => $grandTotal,
            'customer_paid_amount' => $paid,
            'due' => $due,
        ]);

        return redirect()->route('sales.index')->with('success', 'Sale recorded successfully.');
    }
}

