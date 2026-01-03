<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
// use App\ExtraIncome;
use App\Models\ExtraIncome;
use Illuminate\Http\Request;

class ExtraIncomeController extends Controller
{

    // public function index()
    // {
    //     $extraIncomes = ExtraIncome::latest()->get();
    //     return view('extra_income.index', compact('extraIncomes'));
    // }
    public function index(Request $request)
    {
        $from = Carbon::parse($request->from_date)->setTime(5, 0, 0);   // 5:00 AM
        $to   = Carbon::parse($request->to_date)->setTime(23, 59, 59); // 11:59 PM
        $extraIncomes = ExtraIncome::orderBy('created_at', 'desc')->get();

        // Calculate monthly total (current month)
        $monthlyIncome = ExtraIncome::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('amount');
        // Load all records for table

        // Default: no filtering yet
        $filteredIncome = null;

        // If user selects date range
        $filteredIncome = ExtraIncome::whereBetween('created_at', [$from, $to])
        ->sum('amount');

        return view('extra_income.index', compact('extraIncomes', 'monthlyIncome', 'filteredIncome'));
    }


    public function create()
    {
        return view('extra_income.create');
    }

    public function store(Request $request)
    {
        $descriptions = $request->description;
        $amounts = $request->amount;

        foreach ($descriptions as $index => $description) {
            ExtraIncome::create([
                'description' => $description,
                'amount'      => $amounts[$index],
            ]);
        }

        return redirect()
            ->route('extra_income.index')
            ->with('success', 'Extra income added successfully!');
    }


    public function destroy($id)
    {
        ExtraIncome::find($id)->delete();
        return back()->with('success', 'Entry deleted');
    }
}
