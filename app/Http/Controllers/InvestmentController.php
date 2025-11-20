<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Investment;
use App\Models\Investor;

class InvestmentController extends Controller
{
    public function index()
    {
        $investments = Investment::all()->sortByDesc('created_at');
        $totalInvestment = Investment::sum('amount');

        // Ownership percentage (based on total investment)
        $investors = Investor::all();
        $ownerships = [];

        if ($totalInvestment > 0) {
            foreach ($investors as $investor) {
                $ownerships[] = [
                    'name' => $investor->investor_name,
                    'amount' => $investor->amount,
                    'percentage' => round(($investor->amount / $totalInvestment) * 100, 2)
                ];
            }
        }

        return view('investments.index', compact('investments', 'totalInvestment', 'ownerships'));
    }

    public function create()
    {
        return view('investments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'cost_for' => 'required|string|max:255',
        ]);

        Investment::create($request->all());

        return redirect()->route('investments.index')->with('success', 'Investment added successfully!');
    }
}
