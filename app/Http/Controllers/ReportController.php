<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Stock;
use Carbon\Carbon;
use DB;



class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    // Sales Report
    public function sales()
    {
        return view('reports.sales');
    }

    public function salesReport(Request $request)
    {

        $from = Carbon::parse($request->from_date)->setTime(5, 0, 0);   // 5:00 AM
        $to   = Carbon::parse($request->to_date)->setTime(23, 59, 59); // 11:59 PM

        $sales = Sale::with('medicine')
        ->whereBetween('created_at', [$from, $to])
            ->get();
            // dd($sales);

        return view('reports.sales', compact('sales'));
    }

    // Purchase Report
    public function purchases()
    {
        return view('reports.purchases');
    }

    public function purchaseReport(Request $request)
    {


$from = Carbon::parse($request->from_date)->setTime(5, 0, 0);   // 5:00 AM
$to   = Carbon::parse($request->to_date)->setTime(23, 59, 59); // 11:59 PM

$purchases = Purchase::with('medicine')
    ->whereBetween('created_at', [$from, $to])
    ->get();

        // $purchases = Purchase::with('medicine')
        //     ->whereBetween('created_at', [$request->from_date, $request->to_date])
        //     ->get();

        return view('reports.purchases', compact('purchases'));
    }



    // Stock Report
    public function stock()
    {
        $stocks = Stock::with('medicine')->get();
        return view('reports.stock', compact('stocks'));
    }

    // Profit / Loss Report
    public function profitLoss()
    {
        return view('reports.profitLoss');
    }

    public function profitLossReport(Request $request)
    {

        $from = Carbon::parse($request->from_date)->setTime(5, 0, 0);   // 5:00 AM
        $to   = Carbon::parse($request->to_date)->setTime(23, 59, 59); // 11:59 PM

        $sales = Sale::with('medicine')
        ->whereBetween('created_at', [$from, $to])
            ->get();

        $totalSales = 0;
        $totalPurchases = 0;
        $profit = 0;

        foreach ($sales as $sale) {
            // latest purchase price for this medicine
            $purchase = \App\Models\Purchase::where('medicine_id', $sale->medicine_id)
                        ->whereDate('created_at', '<=', $sale->created_at)
                        ->orderBy('created_at', 'desc')
                        ->first();

            $buyingPrice = $purchase ? $purchase->price : 0;

            $saleAmount     = $sale->quantity * $sale->selling_price;
            $purchaseAmount = $sale->quantity * $buyingPrice;
            $itemProfit     = $saleAmount - $purchaseAmount;

            $totalSales     += $saleAmount;
            $totalPurchases += $purchaseAmount;
            $profit         += $itemProfit;
        }

        return view('reports.profitLoss', compact('sales', 'totalSales', 'totalPurchases', 'profit'));
    }


}
