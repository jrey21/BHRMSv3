<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Beneficiaries;
use Inertia\Inertia;

class BeneficiariesController extends Controller
{
    //store the data to the database
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'zone' => 'string|max:255',
        ]);

        $newData = Beneficiaries::create($validatedData);
        

        return response()->json($newData); 
    }

    //retrieve all data from the database
    public function retrieve()
    {
        $beneficiaries = Beneficiaries::all();

        return response()->json($beneficiaries);
    }

    //edit specific data
    public function edit($id)
    {
        $beneficiaries = Beneficiaries::find($id);

        return response()->json($beneficiaries);
    }

    //update specific data
    public function update(Request $request, $id)
    {
        $beneficiary = Beneficiaries::findOrFail($id);
        $beneficiary->update($request->all());
        return response()->json($beneficiary);
    }

    //delete specific data
    public function destroy($id)
    {
        $beneficiaries = Beneficiaries::destroy($id);

        return response()->json($beneficiaries); 
    }
}
