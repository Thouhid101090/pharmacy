<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Medicine;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::with('medicine')->get();
        return view('stocks.index', compact('stocks'));
    }
    public function search(Request $request)
    {
        $query = $request->input('query');

        $stocks = Stock::whereHas('medicine', function ($q) use ($query) {
            $q->where('name', 'like', '%' . $query . '%');
        })->get();

        return view('stocks.index', compact('stocks'));
    }
    public function destroy($id)
    {
        try {
            $stock = Stock::findOrFail($id);
            $stock->delete();

            return redirect()->back()->with('success', 'Stock item removed successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error removing stock item.');
        }
    }
}
