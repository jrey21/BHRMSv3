<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicineList;
use Inertia\Inertia;

class MedicineListController extends Controller
{
    //store the data to the database
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'measurement' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'expiry_date' => 'date',
        ]);

        $newData = MedicineList::create($validatedData);
        return response()->json($newData); 
    }

    //retrieve all data from the database
    public function retrieve()
    {
        $medicineList = MedicineList::all();

        return response()->json($medicineList);
    }

    //edit specific data
    public function edit($id)
    {
        $medicineList = MedicineList::find($id);

        return response()->json($medicineList);
    }

    //update specific data
    public function update(Request $request, $id)
    {
        $medicineList = MedicineList::findOrFail($id);
        $medicineList->update($request->all());
        return response()->json($medicineList);
    }

    //delete specific data
    public function destroy($id)
    {
        $medicineList = MedicineList::destroy($id);

        return response()->json($medicineList); 
    }

    public function distribute(Request $request, $id)
    {
        $medicine = MedicineList::findOrFail($id);
        $distributedQuantity = $request->input('distributed_quantity');
        $beneficiaryName = $request->input('beneficiary_name');

        if ($medicine->quantity < $distributedQuantity) {
            return response()->json(['error' => 'Not enough quantity available'], 400);
        }

        $medicine->quantity -= $distributedQuantity;
        $medicine->save();

        DistributedMedicine::create([
            'medicine_id' => $medicine->id,
            'beneficiary_name' => $beneficiaryName,
            'medicine_name' => $medicine->name,
            'distributed_quantity' => $distributedQuantity,
            'distribution_date' => now(),
        ]);

        return response()->json(['distributedQuantity' => $distributedQuantity]);
    }
}
