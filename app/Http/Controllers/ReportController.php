<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->query('from');
        $to = $request->query('to');

        $query = Sale::query();
        
        if ($from) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to) {
            $query->whereDate('created_at', '<=', $to);
        }


        $sales = $query->with(['product', 'customer'])->get();

        $totalSales = $sales->sum('total');
        $totalDiscount = $sales->sum('discount');

        $totalVAT = $sales->sum(function ($sale) {
            $base = ($sale->sell_price * $sale->quantity) - $sale->discount;
            return ($base * $sale->vat) / 100;
        });

        $totalPaid = $sales->sum('customer_paid_amount');
        $totalDue = $sales->sum('due');

        $totalProfit = $sales->sum(function ($sale) {
            $purchasePrice = $sale->product->purchase_price ?? 0;
            $cost = $purchasePrice * $sale->quantity;

            $base = ($sale->sell_price * $sale->quantity) - $sale->discount;
            $vatAmount = ($base * $sale->vat) / 100;
            $revenue = $base + $vatAmount;

            return $revenue - $cost;
        });

        return view('reports.index', compact(
            'totalSales',
            'totalDiscount',
            'totalVAT',
            'totalPaid',
            'totalDue',
            'totalProfit',
            'sales',
            'from',
            'to'
        ));
    }
}
