<?php

namespace App\Http\Controllers;

use App\Models\PNEAEnrollment;
use App\Models\OptimumPractice;
use Illuminate\Http\Request;

class OptimumPracticeController extends Controller
{
    // public function store(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'pnea_enrollment_id' => 'required|exists:pnea_enrollments,id',
    //         'preNatalCare' => 'array',
    //         'preNatalCheckUp' => 'array',
    //         'ironFolicSupplementation' => 'array',
    //         'iodizedSalt' => 'array',
    //         'tetanusVaccination' => 'array',
    //         'breastfeedingPreparation' => 'array',
    //         'nutritionInterventions' => 'array',
    //         'postNatalCare' => 'array',
    //         'ironSupplementation' => 'array',
    //         'breastfeedingInitiation' => 'array',
    //         'exclusiveBreastfeeding' => 'array',
    //         'continueBreastfeeding' => 'array',
    //         'continueBreastfeedingBeyondTwo' => 'array',
    //         'healthSanitation' => 'array',
    //     ]);

    //     $optimumPractice = OptimumPractice::create($validatedData);

    //     return response()->json(['success' => true, 'data' => $optimumPractice], 201);
    // }

    public function pnea()
    {
        return $this->belongsTo(PNEAEnrollment::class, 'pnea_id');
    }
}
