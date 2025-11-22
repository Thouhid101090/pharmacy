<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Medicine;
use App\Models\Stock;
use Exception;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::latest()->paginate(10);

        // Daily Purchase Total
        $dailyPurchase = Purchase::whereDate('created_at', today())
            ->sum('total_amount');

        // Monthly Purchase Total
        $monthlyPurchase = Purchase::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');

        return view('purchases.index', compact('purchases', 'dailyPurchase', 'monthlyPurchase'));
    }


    public function create()
    {
        $medicines = Medicine::all();
        $stocks = Stock::all();
        return view('purchases.create', compact('medicines', 'stocks'));
    }

    // public function store(Request $request)
    // {
    //     // dd($request->all());
    //     $request->validate([
    //         // 'medicine_id'   => 'required|exists:medicines,id',
    //         'supplier_name' => 'required',
    //         'quantity'      => 'required|integer|min:1',
    //         'total_amount'  => 'required|numeric|min:0',
    //         'expiry_date'   => 'nullable|date',
    //     ]);

    //     try {
    //         // Auto-generate invoice_no
    //         $today = now()->format('Ymd');
    //         $lastInvoice = Purchase::whereDate('created_at', now()->toDateString())->count() + 1;
    //         $invoice_no = 'INV-' . $today . '-' . str_pad($lastInvoice, 3, '0', STR_PAD_LEFT);

    //         $unit_price = $request->total_amount / $request->quantity;


    //         if (!$request->medicine_id) {
    //             //dd("test");
    //             if (!$request->medicine_name) {
    //                 return back()->with('error', 'Medicine name is required');
    //             }

    //             $medicine = Medicine::create([
    //                 'name' => $request->medicine_name
    //             ]);
    //         }

    //         $purchase = Purchase::create([
    //             'invoice_no'    => $invoice_no,
    //             'medicine_id'   => $request->medicine_id ?? $medicine->id,
    //             'supplier_name' => $request->supplier_name,
    //             'quantity'      => $request->quantity,
    //             'price'         => $unit_price,
    //             'total_amount'  => $request->total_amount,
    //             'expiry_date'   => $request->expiry_date,
    //         ]);

    //         // update stock
    //         Stock::increaseStock($request->medicine_id, $request->quantity);

    //         return redirect()->route('purchases.index')->with('success', 'Purchase added successfully. ');
    //     } catch (Exception $e) {
    //         dd($e->getMessage());
    //         return redirect()->back()->with('error', $e->getMessage());
    //     }
    // }
    public function store(Request $request)
{
    $request->validate([
        'supplier_name' => 'required',
        'quantity'      => 'required|integer|min:1',
        'total_amount'  => 'required|numeric|min:0',
        'expiry_date'   => 'nullable|date',
    ]);

    try {
        // Auto-generate invoice_no
        $today = now()->format('Ymd');
        $lastInvoice = Purchase::whereDate('created_at', now()->toDateString())->count() + 1;
        $invoice_no = 'INV-' . $today . '-' . str_pad($lastInvoice, 3, '0', STR_PAD_LEFT);

        $unit_price = $request->total_amount / $request->quantity;

        // Determine medicine_id (existing or new)
        if (empty($request->medicine_id)) {

            if (empty($request->medicine_name)) {
                return back()->with('error', 'Medicine name is required');
            }

            // Create new medicine
            $medicine = Medicine::create([
                'name' => $request->medicine_name
            ]);

            $medicine_id = $medicine->id;

        } else {
            // Use existing medicine
            $medicine_id = $request->medicine_id;
        }

        // Create purchase
        $purchase = Purchase::create([
            'invoice_no'    => $invoice_no,
            'medicine_id'   => $medicine_id,
            'supplier_name' => $request->supplier_name,
            'quantity'      => $request->quantity,
            'price'         => $unit_price,
            'total_amount'  => $request->total_amount,
            'expiry_date'   => $request->expiry_date,
        ]);

        // Update stock
        // Stock::increaseStock($medicine_id, $request->quantity);
        Stock::increaseStock($request->medicine_id, $request->quantity);

        return redirect()->route('purchases.index')
            ->with('success', 'Purchase added successfully.');

    } catch (Exception $e) {
        return redirect()->back()->with('error', $e->getMessage());
    }
}


    public function edit(Purchase $purchase)
    {
        $medicines = Medicine::all();
        return view('purchases.edit', compact('purchase', 'medicines'));
    }

    public function update(Request $request, Purchase $purchase)
    {
        $request->validate([
            'medicine_id'   => 'required|exists:medicines,id',
            'supplier_name' => 'required',
            'quantity'      => 'required|integer|min:1',
            'total_amount'         => 'required|numeric|min:0',
            'expiry_date'   => 'nullable|date',
        ]);

        $unit_price = $request->total_amount / $request->quantity;

         if (empty($request->medicine_id)) {

            if (!$request->medicine_name) {
                return back()->with('error', 'Medicine name is required');
            }

            $medicine = Medicine::create([
                'name' => $request->medicine_name
            ]);

            $medicine_id = $medicine->id; // GET NEW ID
        } else {
            $medicine_id = $request->medicine_id;
        }


        $purchase->update([
            'medicine_id'   => $request->medicine_id ?? $medicine->id,
            'supplier_name' => $request->supplier_name,
            'quantity'      => $request->quantity,
            'price'         => $unit_price,
            'total_amount'  => $request->total_amount,
            'expiry_date'   => $request->expiry_date,
        ]);

        return redirect()->route('purchases.index')->with('success', 'Purchase updated successfully.');
    }

    public function destroy(Purchase $purchase)
    {
        $purchase->delete();
        return redirect()->route('purchases.index')->with('success', 'Purchase deleted successfully.');
    }
}
