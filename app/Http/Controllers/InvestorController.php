<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Investor;

class InvestorController extends Controller
{
    public function index()
    {
        $investors = Investor::all();
        return view('investors.index', compact('investors'));
    }

    public function create()
    {
        return view('investors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'investor_name' => 'required|string|max:255',
            'amount' => 'required|numeric',
        ]);

        // Check if the investor already exists
        $investor = \App\Models\Investor::where('investor_name', $request->investor_name)->first();

        if ($investor) {
            // Add the new amount to the existing one
            $investor->amount += $request->amount;
            $investor->save();
        } else {
            // Create a new investor record if not found (for first-time investment)
            \App\Models\Investor::create([
                'investor_name' => $request->investor_name,
                'amount' => $request->amount,
            ]);
        }

        return redirect()->route('investors.index')->with('success', 'Investment added successfully!');
    }

}
