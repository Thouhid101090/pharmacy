<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Stock;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1️⃣ Total Sale and Purchase
        $totalSales = Sale::sum('total_price');
        $totalPurchases = Purchase::sum('total_amount');

        // 2️⃣ Profit (based on actual sales)
        $profit = 0;

        $sales = Sale::with('medicine')->get();

        foreach ($sales as $sale) {
            $purchase = Purchase::where('medicine_id', $sale->medicine_id)
                ->whereDate('created_at', '<=', $sale->created_at)
                ->orderBy('created_at', 'desc')
                ->first();

            $buyingPrice = $purchase ? $purchase->price : 0;

            $saleAmount     = $sale->quantity * $sale->selling_price;
            $purchaseAmount = $sale->quantity * $buyingPrice;
            $itemProfit     = $saleAmount - $purchaseAmount;

            $profit += $itemProfit;
        }

        // 3️⃣ Total Stock Value (from stock table × latest purchase price)
        $totalStockValue = 0;

        $stocks = Stock::all();

        foreach ($stocks as $stock) {
            $latestPurchase = Purchase::where('medicine_id', $stock->medicine_id)
                ->orderBy('created_at', 'desc')
                ->first();

            $buyPrice = $latestPurchase ? $latestPurchase->price : 0;
            $totalStockValue += $stock->quantity * $buyPrice;

        }

        // 4️⃣ Graph Data (last 7 days)
        $salesData = Sale::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_price) as total'))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->take(7)
            ->get();

        $purchaseData = Purchase::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_amount) as total'))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->take(7)
            ->get();

        return view('home', compact(
            'totalSales',
            'totalPurchases',
            'profit',
            'totalStockValue',
            'salesData',
            'purchaseData'
        ));
    }
}
