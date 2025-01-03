<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PNEAEnrollment;
use Inertia\Inertia;

class PNEAEnrollmentController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'pinkCardNumber' => 'required|string|max:255',
            'date' => 'required|date',
            'zone' => 'required|string|max:255',
            'fullName' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'age' => 'required|integer',
            'education' => 'required|string|max:255',
            'occupation' => 'required|string|max:255',
            'term_of_pregnancy' => 'required|string|max:255',
            'number_of_pregnancy' => 'required|integer',
            'date_last_delivery' => 'required|date',
            'number_of_children' => 'required|integer',
            'interval_of_delivery' => 'required|string|max:255',
            'muac' => 'required|string|max:255',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'bmi' => 'required|numeric',
            'ns' => 'required|string|max:255',
            'name_of_husband' => 'required|string|max:255',
            'husband_age' => 'required|integer',
            'husband_education' => 'required|string|max:255',
            'husband_occupation' => 'required|string|max:255',
            'monthly_family_income' => 'required|string|max:255',
            'household_size' => 'required|integer|max:255',
        ]);

        // Save the validated data to the database
        PNEAEnrollment::create($validatedData);

        session()->flash('message', 'Data has been added successfully!');

        return redirect()->route('pnea-enrollment-view'); 
    }

    //retrieve all data
    public function retrieve()
    {
        $PNEAEnrollment = PNEAEnrollment::all();
        return response()->json($PNEAEnrollment);
    }

    //edit specific data
    public function edit($id)
    {
        $PNEAEnrollment = PNEAEnrollment::find($id);
        return response()->json($PNEAEnrollment);
    }

    //update specific data
    public function update(Request $request, $id)
    {
        $pnea = PNEAEnrollment::findOrFail($id);
        $pnea->pinkCardNumber = $request->pinkCardNumber;
        $pnea->date = $request->date;
        $pnea->zone = $request->zone;
        $pnea->fullName = $request->fullName;
        $pnea->birth_date = $request->birth_date;
        $pnea->age = $request->age;
        $pnea->education = $request->education;
        $pnea->occupation = $request->occupation;
        $pnea->term_of_pregnancy = $request->term_of_pregnancy;
        $pnea->number_of_pregnancy = $request->number_of_pregnancy;
        $pnea->date_last_delivery = $request->date_last_delivery;
        $pnea->number_of_children = $request->number_of_children;
        $pnea->interval_of_delivery = $request->interval_of_delivery;
        $pnea->muac = $request->muac;
        $pnea->height = $request->height;
        $pnea->weight = $request->weight;
        $pnea->bmi = $request->bmi;
        $pnea->ns = $request->ns;
        $pnea->name_of_husband = $request->name_of_husband;
        $pnea->husband_age = $request->husband_age;
        $pnea->husband_education = $request->husband_education;
        $pnea->husband_occupation = $request->husband_occupation;
        $pnea->monthly_family_income = $request->monthly_family_income;
        $pnea->household_size = $request->household_size;        
        $pnea->save();

        return response()->json($pnea);
    }
    

    //show data from a specific record
    public function show($id)
    {
        $pnea = PNEAEnrollment::with('optimumPractice')->findOrFail($id);
        return Inertia::render('PNEA/Show', [
            'pnea' => $pnea,
        ]);
        
        // return response()->json($pnea);
    }

    //add optimum practices data
    public function addOptimumPractices(Request $request, $pnea_id)
    {
        $validatedData = $request->validate([
            'prenatal_care_counseled' => 'nullable',
            'prenatal_care_date_counseled' => 'nullable',
            'prenatal_care_practiced' => 'nullable',
            'prenatal_checkup_counseled' => 'nullable',
            'prenatal_checkup_date_counseled' => 'nullable',
            'prenatal_checkup_trimester_practiced' => 'nullable',
            'prenatal_checkup_date_practiced' => 'nullable',
            'iron_folic_acid_counseled' => 'nullable',
            'iron_folic_acid_date_counseled' => 'nullable',
            'iron_folic_acid_trimester_practiced' => 'nullable',
            'iron_folic_acid_date_practiced' => 'nullable',
            'iodized_salt_counseled' => 'nullable',
            'iodized_salt_date_counseled' => 'nullable',
            'iodized_salt_practiced' => 'nullable',
            'tetanus_counseled' => 'nullable',
            'tetanus_date_counseled' => 'nullable',
            'tetanus_dose_practiced' => 'nullable',
            'tetanus_date_practiced' => 'nullable',
            'initiation' => 'nullable',
            'exclusivity' => 'nullable',
            'duration' => 'nullable',
            'dietary_intake' => 'nullable',
            'personal_willingness' => 'nullable',
            'family_support' => 'nullable',
            'initiation_counseled' => 'nullable',
            'exclusivity_counseled' => 'nullable',
            'duration_counseled' => 'nullable',
            'dietary_intake_counseled' => 'nullable',
            'personal_willingness_counseled' => 'nullable',
            'family_support_counseled' => 'nullable',
            'initiation_start_date_practiced' => 'nullable',
            'initiation_end_date_practiced' => 'nullable',
            'exclusivity_start_date_practiced' => 'nullable',
            'exclusivity_end_date_practiced' => 'nullable',
            'duration_start_date_practiced' => 'nullable',
            'duration_end_date_practiced' => 'nullable',
            'proper_infant' => 'nullable',
            'nutripak' => 'nullable',
            'health_nutrition' => 'nullable',
            'membership' => 'nullable',
            'plant_malunggay' => 'nullable',
            'other_interventions' => 'nullable',
            'proper_infant_counseled' => 'nullable',
            'nutripak_counseled' => 'nullable',
            'health_nutrition_counseled' => 'nullable',
            'membership_counseled' => 'nullable',
            'plant_malunggay_counseled' => 'nullable',
            'other_interventions_counseled' => 'nullable',
            'proper_infant_practiced' => 'nullable',
            'nutripak_practiced' => 'nullable',
            'health_nutrition_practiced' => 'nullable',
            'membership_member_practiced' => 'nullable',
            'membership_leader_practiced' => 'nullable',
            'plant_malunggay_number_practiced' => 'nullable',
            'date_planted_practiced' => 'nullable',
            'location_practiced' => 'nullable',
            'other_interventions_practiced' => 'nullable',
            'postnatal_checkup_counseled' => 'nullable',
            'postnatal_checkup_date_counseled' => 'nullable',
            'postnatal_last_checkup_date_practiced' => 'nullable',
            'iron_supplementation_counseled' => 'nullable',
            'iron_supplementation_date_counseled' => 'nullable',
            'iron_supplementation_last_date_taken_practiced' => 'nullable',
            'breastfeeding_initiation_counseled' => 'nullable',
            'normal_delivery' => 'nullable',
            'cs_delivery' => 'nullable',
            'given_colostrums' => 'nullable',
            'no_water_given' => 'nullable',
            'exclusive_breastfeeding__colostrums_1' => 'nullable',
            'exclusive_breastfeeding__colostrums_2' => 'nullable',
            'exclusive_breastfeeding__colostrums_3' => 'nullable',
            'exclusive_breastfeeding__colostrums_4' => 'nullable',
            'exclusive_breastfeeding__colostrums_5' => 'nullable',
            'exclusive_breastfeeding__colostrums_6' => 'nullable',
            'exclusive_breastfeeding__water_1' => 'nullable',
            'exclusive_breastfeeding__water_2' => 'nullable',
            'exclusive_breastfeeding__water_3' => 'nullable',
            'exclusive_breastfeeding__water_4' => 'nullable',
            'exclusive_breastfeeding__water_5' => 'nullable',
            'exclusive_breastfeeding__water_6' => 'nullable',
            'exclusive_breastfeeding__food_1' => 'nullable',
            'exclusive_breastfeeding__food_2' => 'nullable',
            'exclusive_breastfeeding__food_3' => 'nullable',
            'exclusive_breastfeeding__food_4' => 'nullable',
            'exclusive_breastfeeding__food_5' => 'nullable',
            'exclusive_breastfeeding__food_6' => 'nullable',
            'exclusive_breastfeeding__vitamins_1' => 'nullable',
            'exclusive_breastfeeding__vitamins_2' => 'nullable',
            'exclusive_breastfeeding__vitamins_3' => 'nullable',
            'exclusive_breastfeeding__vitamins_4' => 'nullable',
            'exclusive_breastfeeding__vitamins_5' => 'nullable',
            'exclusive_breastfeeding__vitamins_6' => 'nullable',
            'exclusive_breastfeeding__formula_milk_1' => 'nullable',
            'exclusive_breastfeeding__formula_milk_2' => 'nullable',
            'exclusive_breastfeeding__formula_milk_3' => 'nullable',
            'exclusive_breastfeeding__formula_milk_4' => 'nullable',
            'exclusive_breastfeeding__formula_milk_5' => 'nullable',
            'exclusive_breastfeeding__formula_milk_6' => 'nullable',
            'exclusive_breastfeeding__other_liquid_1' => 'nullable',
            'exclusive_breastfeeding__other_liquid_2' => 'nullable',
            'exclusive_breastfeeding__other_liquid_3' => 'nullable',
            'exclusive_breastfeeding__other_liquid_4' => 'nullable',
            'exclusive_breastfeeding__other_liquid_5' => 'nullable',
            'exclusive_breastfeeding__other_liquid_6' => 'nullable',
            'child_sick_counseled' => 'nullable',
            'mother_sick_counseled' => 'nullable',
            'child_sick_practiced' => 'nullable',
            'mother_sick_practiced' => 'nullable',
            'continue_breastfeed_beyond_2_counseled' => 'nullable',
            'continue_breastfeed_beyond_2_practiced' => 'nullable',
            'backyard_gardening_counseled' => 'nullable',
            'backyard_gardening_practiced' => 'nullable',
            'clean_environment_counseled' => 'nullable',
            'clean_environment_practiced' => 'nullable',
            'sanitary_counseled' => 'nullable',
            'sanitary_practiced' => 'nullable',
            'potable_water_counseled' => 'nullable',
            'potable_water_practiced' => 'nullable',
        ]);


        $pnea = PNEAEnrollment::findOrFail($pnea_id);
        $record = $pnea->optimumPractices()->create($validatedData);

        return response()->json($pnea);
    }

    //retrieve all data with optimum practice data
    public function retrieveWithOptimumPractices()
    {
        $PNEAEnrollment = PNEAEnrollment::with('optimumPractice')->get();
        return response()->json($PNEAEnrollment);
    }

    //retrieve specific data with optimum practice data
    // public function retrieveSpecificWithOptimumPractices($id)
    // {
    //     $PNEAEnrollment = PNEAEnrollment::with('optimumPractice')->find($id);
    //     return response()->json($PNEAEnrollment);
    // }
    

}
