<?php

namespace App\Http\Controllers;

use App\Models\DistributedMedicine;
use App\Models\MedicineList; // Add this line to import the Medicine model
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DistributedMedicineController extends Controller
{
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

    //retrieve all data
    public function retrieve()
    {
        $distributedMedicines = DistributedMedicine::all();
        return response()->json($distributedMedicines);
    }
}