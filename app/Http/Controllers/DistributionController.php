<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Distribution;
use Inertia\Inertia;

class DistributionController extends Controller
{
    //save the data to the database
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'medicine_name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'beneficiary_name' => 'required|string|max:255',
            'date' => 'required|date', // Ensure date is required
        ]);

        $newData = Distribution::create($validatedData);
        return response()->json($newData); 
    }

    //retrieve all data from the database
    public function retrieve()
    {
        $distribution = Distribution::all();
        return response()->json($distribution);
    }

    //edit specific data
    public function edit($id)
    {
        $distribution = Distribution::find($id);
        return response()->json($distribution);
    }

    //update specific data
    public function update(Request $request, $id)
    {
        $distribution = Distribution::findOrFail($id);
        $distribution->update($request->all());
        return response()->json($distribution);
    }
}
