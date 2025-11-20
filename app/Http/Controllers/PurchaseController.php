<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Medicine;
use App\Models\Stock;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::latest()->paginate(10);
        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $medicines = Medicine::all();
        $stocks = Stock::all();
        return view('purchases.create', compact('medicines', 'stocks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'medicine_id'   => 'required|exists:medicines,id',
            'supplier_name' => 'required',
            'quantity'      => 'required|integer|min:1',
            'total_amount'  => 'required|numeric|min:0',
            'expiry_date'   => 'nullable|date',
        ]);

        // Auto-generate invoice_no
        $today = now()->format('Ymd');
        $lastInvoice = Purchase::whereDate('created_at', now()->toDateString())->count() + 1;
        $invoice_no = 'INV-' . $today . '-' . str_pad($lastInvoice, 3, '0', STR_PAD_LEFT);

        $unit_price = $request->total_amount / $request->quantity;

        $purchase = Purchase::create([
            'invoice_no'    => $invoice_no,
            'medicine_id'   => $request->medicine_id,
            'supplier_name' => $request->supplier_name,
            'quantity'      => $request->quantity,
            'price'         => $unit_price,
            'total_amount'  => $request->total_amount,
            'expiry_date'   => $request->expiry_date,
        ]);

        // update stock
        Stock::increaseStock($request->medicine_id, $request->quantity);

        return redirect()->route('purchases.index')->with('success', 'Purchase added successfully.');
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

        $purchase->update([
            'medicine_id'   => $request->medicine_id,
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
