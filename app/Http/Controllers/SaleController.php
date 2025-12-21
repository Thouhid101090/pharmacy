<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\Stock;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function create()
    {
        $medicines = Medicine::all();
        return view('sales.create', compact('medicines'));
    }

    public function index()
{
    $sales = Sale::latest()->paginate(10);
    // Daily Total Sale
    $dailySale = Sale::whereDate('created_at', today())
        ->sum('total_price');

    // Monthly Total Sale
    $monthlySale = Sale::whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->sum('total_price');

    // Daily Profit
    $dailyProfit = Sale::whereDate('created_at', today())
        ->get()
        ->sum(function ($sale) {
            return $sale->profit;
        });

    // Monthly Profit
    $monthlyProfit = Sale::whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->get()
        ->sum(function ($sale) {
            return $sale->profit;
        });

    return view('sales.index', compact('sales', 'monthlyProfit', 'dailySale', 'dailyProfit', 'monthlySale'));
}


    /**
     * Generate Invoice Number
     */
    private function generateInvoiceNo()
    {
        $today = Carbon::today()->format('Ymd'); // YYYYMMDD
        $prefix = "INV-{$today}-";

        // Find last invoice of today
        $lastSale = Sale::whereDate('created_at', Carbon::today())
            ->orderBy('id', 'desc')
            ->first();

        if ($lastSale) {
            // Extract last counter
            $lastCounter = (int)substr($lastSale->invoice_no, -3);
            $newCounter = str_pad($lastCounter + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newCounter = "001";
        }

        return $prefix . $newCounter;
    }

    /**
     * Store Sale via API (JSON Response)
     */
    public function storeSale(Request $request)
    {
        $stock = Stock::where('medicine_id', $request->medicine_id)->first();

        if (!$stock || $stock->quantity < $request->quantity) {
            return response()->json(['error' => 'Insufficient stock'], 400);
        }

        $invoiceNo = $this->generateInvoiceNo();

        $sale = Sale::create([
            'invoice_no'    => $invoiceNo,
            'medicine_id'   => $request->medicine_id,
            'quantity'      => $request->quantity,

            'total_price'   => $request->total_price,
            'selling_price' => $request->total_price / $request->quantity,
        ]);

        $stock->decrease($request->quantity);

        return response()->json(['success' => 'Sale recorded', 'invoice_no' => $invoiceNo]);
    }

    /**
     * Store Sale (Form Submission)
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'medicine_id'   => 'required|exists:medicines,id',
    //         'quantity'      => 'required|integer|min:1',
    //         'total_price'   => 'required|numeric|min:0',
    //     ]);


    //     $stock = Stock::where('medicine_id', $request->medicine_id)->first();
    //     if (!$stock || $stock->quantity < $request->quantity) {
    //         return back()->with('error', 'Insufficient stock');
    //     }

    //     $invoiceNo = $this->generateInvoiceNo();

    //     $sale = Sale::create([
    //         'invoice_no'    => $invoiceNo,
    //         'medicine_id'   => $request->medicine_id,
    //         'quantity'      => $request->quantity,

    //         'total_price'   => $request->total_price,
    //         'selling_price' => $request->total_price / $request->quantity,
    //     ]);

    //     // Update stock
    //     $stock->quantity -= $request->quantity;
    //     $stock->save();

    //     return back()->with('success', "Sale recorded successfully. Invoice: {$invoiceNo}");
    // }

    public function store(Request $request)
    {
        $request->validate([
            'medicine_id'   => 'required|array',
            'medicine_id.*' => 'required|exists:medicines,id',
            'quantity'      => 'required|array',
            'quantity.*'    => 'required|integer|min:1',
            'total_price'   => 'required|array',
            'total_price.*' => 'required|numeric|min:0',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                $invoiceNo = $this->generateInvoiceNo();

                foreach ($request->medicine_id as $index => $medicineId) {
                    $qtyRequested = $request->quantity[$index];
                    $totalPrice = $request->total_price[$index];

                    // 1. Check Stock for this specific medicine
                    $stock = Stock::where('medicine_id', $medicineId)->first();

                    if (!$stock || $stock->quantity < $qtyRequested) {
                        $medicine = Medicine::find($medicineId);
                        // Using a manual exception to trigger a rollback
                        throw new \Exception("Insufficient stock for: " . ($medicine->name ?? 'Unknown Medicine'));
                    }

                    // 2. Create the Sale
                    Sale::create([
                        'invoice_no'    => $invoiceNo,
                        'medicine_id'   => $medicineId,
                        'quantity'      => $qtyRequested,
                        'total_price'   => $totalPrice,
                        'selling_price' => $totalPrice / $qtyRequested, // Auto-calculation
                    ]);

                    // 3. Update stock
                    $stock->quantity -= $qtyRequested;
                    $stock->save();
                }

                return redirect()->route('sales.index')
                    ->with('success', "Sale recorded successfully. Invoice: {$invoiceNo}");
            });

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }
}
