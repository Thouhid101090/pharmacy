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


//     public function store(Request $request)
// {
//     $request->validate([
//         'supplier_name' => 'required',
//         'quantity'      => 'required|integer|min:1',
//         'total_amount'  => 'required|numeric|min:0',
//         'expiry_date'   => 'nullable|date',
//         // Medicine ID is optional if Name is provided
//         'medicine_id'   => 'nullable|exists:medicines,id',
//         'medicine_name' => 'required_without:medicine_id|string|max:255',
//     ]);

//     try {
//         return \DB::transaction(function () use ($request) {
//             // 1. Determine the Medicine
//             if ($request->filled('medicine_id')) {
//                 $medicineId = $request->medicine_id;
//             } else {
//                 // Create the medicine if it doesn't exist (case-insensitive check)
//                 $medicine = Medicine::firstOrCreate(
//                     ['name' => trim($request->medicine_name)],
//                     ['company_name' => trim($request->supplier_name)],

//                 );
//                 $medicineId = $medicine->id;
//             }

//             // 2. Auto-generate invoice_no
//             $today = now()->format('Ymd');
//             $count = Purchase::whereDate('created_at', today())->count() + 1;
//             $invoice_no = 'INV-' . $today . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

//             $unit_price = $request->total_amount / $request->quantity;
// // dd($invoice_no );
//             // 3. Create Purchase
//             Purchase::create([
//                 'invoice_no'    => $invoice_no,
//                 'medicine_id'   => $medicineId,
//                 'supplier_name' => $request->supplier_name,
//                 'quantity'      => $request->quantity,
//                 'price'         => $unit_price,
//                 'total_amount'  => $request->total_amount,
//                 'expiry_date'   => $request->expiry_date,
//             ]);


// // dd($medicineId);
//             // 4. Update stock
//             Stock::increaseStock($medicineId, $request->quantity);

//             return redirect()->route('purchases.index')->with('success', 'Purchase added successfully.');
//         });
//     } catch (Exception $e) {
//         return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
//     }
// }
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
