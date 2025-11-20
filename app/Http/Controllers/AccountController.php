<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::latest()->get();

        $totalSavings = Account::where('type', 'saving')->sum('amount');
        $expenseFromCash = Account::where('type', 'expense')->where('source', 'cash')->sum('amount');
        $expenseFromSaving = Account::where('type', 'expense')->where('source', 'saving')->sum('amount');

        $remainingSavings = $totalSavings - $expenseFromSaving;

        return view('accounts.index', compact('accounts', 'totalSavings', 'expenseFromCash', 'expenseFromSaving', 'remainingSavings'));
    }

    public function create()
    {
        return view('accounts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:saving,expense',
            'source' => 'nullable|in:cash,saving',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string'
        ]);

        Account::create($request->all());

        return redirect()->route('accounts.index')->with('success', 'Record added successfully.');
    }
}
