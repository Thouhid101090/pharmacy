<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\ExtraIncome;
use App\Models\ExtraIncome;

class ExtraIncomeController extends Controller
{

    public function index()
    {
        $extraIncomes = ExtraIncome::latest()->get();
        return view('extra_income.index', compact('extraIncomes'));
    }

    public function create()
    {
        return view('extra_income.create');
    }

    public function store(Request $request)
    {
        ExtraIncome::create([
            'description' => $request->description,
            'amount' => $request->amount,

        ]);

        return redirect()->route('extra_income.index')->with('success', 'Extra income added successfully!');
    }

    public function destroy($id)
    {
        ExtraIncome::find($id)->delete();
        return back()->with('success', 'Entry deleted');
    }
}
