<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('products.index', [
            'products' => Product::latest()->paginate(15)
        ]);
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateProduct($request);
        $data['total'] = $data['buying_price'] * $data['quantity'];
        Product::create($data);
        return redirect()->route('products.index')->with('success', 'Product added.');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function show($id)
    {
        return Product::findOrFail($id);
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validateProduct($request);
        $data['total'] = $data['buying_price'] * $data['quantity'];
        $product->update($data);
        return redirect()->route('products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted.');
    }


    private function validateProduct(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'buying_price' => 'required|numeric',
            'quantity' => 'required|integer',
            'sell_price' => 'required|numeric|gt:buying_price',
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->get('q', '');

        $products = Product::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'LIKE', "%{$search}%");
            })
            ->limit(10)
            ->get();

        return response()->json($products);
    }
}
