<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index()
    {
        $medicines = Medicine::latest()->paginate(10);
        return view('medicines.index', compact('medicines'));
    }

    public function create()
    {
        return view('medicines.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required',
            'company_name'  => 'required',

        ]);

        Medicine::create($request->all());

        return redirect()->route('medicines.index')->with('success', 'Medicine added successfully.');
    }

    public function edit(Medicine $medicine)
    {
        return view('medicines.edit', compact('medicine'));
    }

    public function update(Request $request, Medicine $medicine)
    {
        $request->validate([
            'name'          => 'required',
            'company_name'  => 'required',

        ]);

        $medicine->update($request->all());

        return redirect()->route('medicines.index')->with('success', 'Medicine updated successfully.');
    }

    public function destroy(Medicine $medicine)
    {
        $medicine->delete();
        return redirect()->route('medicines.index')->with('success', 'Medicine deleted successfully.');
    }
    public function storeMultiple(Request $request)
    {
        $request->validate([
            'company_name' => 'required',
            'names'        => 'required|string',
        ]);

        $company = $request->company_name;

        // Split the textarea input by new lines
        $names = preg_split('/\r\n|\r|\n/', trim($request->names));

        $insertData = [];
        foreach ($names as $name) {
            if (!empty(trim($name))) {
                $insertData[] = [
                    'name'          => trim($name),
                    'company_name'  => $company,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ];
            }
        }

        if (!empty($insertData)) {
            Medicine::insert($insertData);
        }

        return redirect()->route('medicines.index')->with('success', 'All medicines added successfully.');
    }




}
