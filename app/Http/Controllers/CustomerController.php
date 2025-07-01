<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->paginate(15);
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateProduct($request);
        Customer::create($data);
        return redirect()->route('customers.index')->with('success', 'Customer added.');
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function show($id)
    {
        return Customer::findOrFail($id);
    }

    public function update(Request $request, Customer $customer)
    {
        $data = $this->validateProduct($request, $customer->id);
        $customer->update($data);
        return redirect()->route('customers.index')->with('success', 'Customer updated.');
    }


    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted.');
    }

    private function validateProduct(Request $request, $productId = null)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'phone' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('customers')->ignore($productId),
            ],
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('customers')->ignore($productId),
            ],
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->get('q', '');

        $customers = Customer::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'LIKE', "%{$search}%");
            })
            ->limit(10)
            ->get();

        return response()->json($customers);
    }
}
