<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use App\Models\Stock;
use App\Models\Medicine;
use App\Models\Purchase;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        $purchases = Purchase::latest()->paginate(10);

        // Daily Purchase Total
        $dailyPurchase = Purchase::whereDate('created_at', today())
            ->sum('total_amount');

        // Monthly Purchase Total
        $monthlyPurchase = Purchase::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');
        $query = Purchase::query()->with('medicine');

        if ($request->has('search')) {
            $search = $request->get('search');

            $query->where(function ($q) use ($search) {
                $q->where('supplier_name', 'like', "%{$search}%") // Search Supplier
                    ->orWhereHas('medicine', function ($m) use ($search) {
                        $m->where('name', 'like', "%{$search}%"); // Search Medicine Name
                    });
            });
        }
        $purchases = $query->latest()->paginate(10);

        return view('purchases.index', compact('purchases', 'dailyPurchase', 'monthlyPurchase'));
    }


    public function create()
    {
        $medicines = Medicine::all();
        $stocks = Stock::all();
        return view('purchases.create', compact('medicines', 'stocks'));
    }


    public function store(Request $request)
    {
        // 1. Validation for Arrays
        $request->validate([
            'supplier_name'   => 'required|string|max:255',
            'medicine_id'     => 'required|array',
            'medicine_id.*'   => 'nullable|exists:medicines,id', // Can be null if it's a new medicine
            'medicine_name'   => 'required|array',
            'medicine_name.*' => 'required|string|max:255',
            'quantity'        => 'required|array',
            'quantity.*'      => 'required|integer|min:1',
            'total_amount'    => 'required|array',
            'total_amount.*'  => 'required|numeric|min:0',
            'expiry_date'     => 'nullable|array',
            'expiry_date.*'   => 'nullable|date',
        ]);

        try {
            return \DB::transaction(function () use ($request) {

                // 2. Generate ONE Invoice Number for the entire batch
                $today = now()->format('Ymd');
                $count = Purchase::whereDate('created_at', today())->distinct('invoice_no')->count('invoice_no') + 1;
                $invoice_no = 'INV-' . $today . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

                // 3. Loop through the submitted data
                foreach ($request->medicine_id as $index => $medicineId) {

                    $mName    = trim($request->medicine_name[$index]);
                    $qty      = $request->quantity[$index];
                    $totalRow = $request->total_amount[$index];
                    $expiry   = $request->expiry_date[$index] ?? null;

                    // 4. Determine Medicine (ID or Create New)
                    if (empty($medicineId)) {
                        $medicine = Medicine::firstOrCreate(
                            ['name' => $mName],
                            ['company_name' => trim($request->supplier_name)]
                        );
                        $medicineId = $medicine->id;
                    }

                    // 5. Calculate Unit Price for this row
                    $unit_price = $totalRow / $qty;

                    // 6. Create Purchase Record
                    Purchase::create([
                        'invoice_no'    => $invoice_no,
                        'medicine_id'   => $medicineId,
                        'supplier_name' => $request->supplier_name,
                        'quantity'      => $qty,
                        'price'         => $unit_price,
                        'total_amount'  => $totalRow,
                        'expiry_date'   => $expiry,
                    ]);

                    // 7. Update stock for each item
                    Stock::increaseStock($medicineId, $qty);
                }

                return redirect()->route('purchases.index')
                    ->with('success', "Bulk purchase ($invoice_no) added successfully.");
            });
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error: ' . $e->getMessage())
                ->withInput();
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
            'supplier_name' => 'required|string',
            'medicine_id'   => 'required',
            'quantity'      => 'required|integer|min:1',
            'total_amount'  => 'required|numeric',
            'expiry_date'   => 'nullable|date',
        ]);

        // 1. Adjust Stock
        $stock = Stock::where('medicine_id', $purchase->medicine_id)->first();

        // Reverse the old purchase quantity from stock, then add the new quantity
        $stock->quantity = ($stock->quantity - $purchase->quantity) + $request->quantity;
        $stock->save();

        // 2. Update the Purchase Record
        $purchase->update([
            'supplier_name' => $request->supplier_name,
            'medicine_id'   => $request->medicine_id,
            'quantity'      => $request->quantity,
            'total_amount'  => $request->total_amount,
            'purchase_price' => $request->total_amount / $request->quantity,
            'expiry_date'   => $request->expiry_date,
        ]);

        return redirect()->route('purchases.index')->with('success', 'Purchase record updated successfully.');
    }



    public function destroy(Purchase $purchase)
    {
        $purchase->delete();
        return redirect()->route('purchases.index')->with('success', 'Purchase deleted successfully.');
    }
}
