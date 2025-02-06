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

            // Row 1
            'prenatal_care_counseled' => 'nullable|boolean',
            'prenatal_care_date_counseled' => 'nullable|date',
            'prenatal_care_practiced' => 'nullable|string|max:255',

            // Row 2
            'prenatal_checkup_counseled' => 'nullable|boolean',
            'prenatal_checkup_date_counseled' => 'nullable|date',
            'prenatal_care_date_1' => 'nullable|date',
            'prenatal_care_date_2' => 'nullable|date',
            'prenatal_care_date_3' => 'nullable|date',
            'prenatal_care_date_4' => 'nullable|date',
            'prenatal_care_date_5' => 'nullable|date',
            'prenatal_care_date_6' => 'nullable|date',
            'prenatal_care_date_7' => 'nullable|date',
            'prenatal_care_date_8' => 'nullable|date',
            'prenatal_care_date_9' => 'nullable|date',

            // Row 3
            'iron_folic_acid_counseled' => 'nullable|boolean',
            'iron_folic_acid_date_counseled' => 'nullable|date',
            'iron_folic_acid_date_1' => 'nullable|date',
            'iron_folic_acid_date_2' => 'nullable|date',
            'iron_folic_acid_date_3' => 'nullable|date',
            'iron_folic_acid_date_4' => 'nullable|date',
            'iron_folic_acid_date_5' => 'nullable|date',
            'iron_folic_acid_date_6' => 'nullable|date',
            'iron_folic_acid_date_7' => 'nullable|date',
            'iron_folic_acid_date_8' => 'nullable|date',
            'iron_folic_acid_date_9' => 'nullable|date',

            // Row 4
            'iodized_salt_counseled' => 'nullable|boolean',
            'iodized_salt_date_counseled' => 'nullable|date',
            'iodized_salt_practiced' => 'nullable|date',

            // Row 5
            'tetanus_counseled' => 'nullable|boolean',
            'tetanus_date_counseled' => 'nullable|date',
            'dose_date_1' => 'nullable|date',
            'dose_date_2' => 'nullable|date',
            'dose_date_3' => 'nullable|date',
            'dose_date_4' => 'nullable|date',
            'dose_date_5' => 'nullable|date',

            // Row 6
            'initiation' => 'nullable|integer',
            'exclusivity' => 'nullable|integer',
            'duration' => 'nullable|integer',
            'dietary_intake' => 'nullable|integer',
            'personal_willingness' => 'nullable|integer',
            'family_support' => 'nullable|integer',
            'initiation_counseled' => 'nullable|boolean',
            'exclusivity_counseled' => 'nullable|boolean',
            'duration_counseled' => 'nullable|boolean',
            'dietary_intake_counseled' => 'nullable|boolean',
            'personal_willingness_counseled' => 'nullable|boolean',
            'family_support_counseled' => 'nullable|boolean',
            'initiation_start_date_practiced' => 'nullable|date',
            'initiation_end_date_practiced' => 'nullable|date',
            'exclusivity_start_date_practiced' => 'nullable|date',
            'exclusivity_end_date_practiced' => 'nullable|date',
            'duration_start_date_practiced' => 'nullable|date',
            'duration_end_date_practiced' => 'nullable|date',

            // Row 7
            'proper_infant' => 'nullable|integer',
            'nutripak' => 'nullable|integer',
            'health_nutrition' => 'nullable|integer',
            'membership' => 'nullable|integer',
            'plant_malunggay' => 'nullable|integer',
            'other_interventions' => 'nullable|string|max:255',
            'proper_infant_counseled' => 'nullable|boolean',
            'nutripak_counseled' => 'nullable|boolean',
            'health_nutrition_counseled' => 'nullable|boolean',
            'membership_counseled' => 'nullable|boolean',
            'plant_malunggay_counseled' => 'nullable|boolean',
            'other_interventions_counseled' => 'nullable|boolean',
            'proper_infant_practiced' => 'nullable|boolean',
            'nutripak_practiced' => 'nullable|integer',
            'health_nutrition_practiced' => 'nullable|boolean',
            'membership_member_practiced' => 'nullable|boolean',
            'membership_leader_practiced' => 'nullable|boolean',
            'plant_malunggay_number_practiced' => 'nullable|integer',
            'date_planted_practiced' => 'nullable|date',
            'location_practiced' => 'nullable|string|max:255',
            'other_interventions_practiced' => 'nullable|boolean',

            // Row 8
            'postnatal_checkup_counseled' => 'nullable|boolean',
            'postnatal_checkup_date_counseled' => 'nullable|date',
            'postnatal_last_checkup_date_practiced' => 'nullable|date',

            // Row 9
            'iron_supplementation_counseled' => 'nullable|boolean',
            'iron_supplementation_date_counseled' => 'nullable|date',
            'iron_supplementation_last_date_taken_practiced' => 'nullable|date',
            'iron_supplementation_amount_practiced' => 'nullable|integer',

            // Row 10
            'breastfeeding_initiation_counseled' => 'nullable|boolean',
            'breastfeeding_initiation_date_counseled' => 'nullable|date',
            'normal_delivery' => 'nullable|integer',
            'cs_delivery' => 'nullable|integer',

            // Row 11
            'given_colostrums' => 'nullable|boolean',
            'no_water_given' => 'nullable|boolean',
            'no_food_given' => 'nullable|boolean',
            'no_vitamins_given' => 'nullable|boolean',
            'no_formula_milk_given' => 'nullable|boolean',
            'no_other_liquid_given' => 'nullable|boolean',
            'exclusive_breastfeeding_colostrums_1' => 'nullable|string|max:255',
            'exclusive_breastfeeding_colostrums_2' => 'nullable|string|max:255',
            'exclusive_breastfeeding_colostrums_3' => 'nullable|string|max:255',
            'exclusive_breastfeeding_colostrums_4' => 'nullable|string|max:255',
            'exclusive_breastfeeding_colostrums_5' => 'nullable|string|max:255',
            'exclusive_breastfeeding_colostrums_6' => 'nullable|string|max:255',
            'exclusive_breastfeeding_water_1' => 'nullable|string|max:255',
            'exclusive_breastfeeding_water_2' => 'nullable|string|max:255',
            'exclusive_breastfeeding_water_3' => 'nullable|string|max:255',
            'exclusive_breastfeeding_water_4' => 'nullable|string|max:255',
            'exclusive_breastfeeding_water_5' => 'nullable|string|max:255',
            'exclusive_breastfeeding_water_6' => 'nullable|string|max:255',
            'exclusive_breastfeeding_food_1' => 'nullable|string|max:255',
            'exclusive_breastfeeding_food_2' => 'nullable|string|max:255',
            'exclusive_breastfeeding_food_3' => 'nullable|string|max:255',
            'exclusive_breastfeeding_food_4' => 'nullable|string|max:255',
            'exclusive_breastfeeding_food_5' => 'nullable|string|max:255',
            'exclusive_breastfeeding_food_6' => 'nullable|string|max:255',
            'exclusive_breastfeeding_vitamins_1' => 'nullable|string|max:255',
            'exclusive_breastfeeding_vitamins_2' => 'nullable|string|max:255',
            'exclusive_breastfeeding_vitamins_3' => 'nullable|string|max:255',
            'exclusive_breastfeeding_vitamins_4' => 'nullable|string|max:255',
            'exclusive_breastfeeding_vitamins_5' => 'nullable|string|max:255',
            'exclusive_breastfeeding_vitamins_6' => 'nullable|string|max:255',
            'exclusive_breastfeeding_formula_milk_1' => 'nullable|string|max:255',
            'exclusive_breastfeeding_formula_milk_2' => 'nullable|string|max:255',
            'exclusive_breastfeeding_formula_milk_3' => 'nullable|string|max:255',
            'exclusive_breastfeeding_formula_milk_4' => 'nullable|string|max:255',
            'exclusive_breastfeeding_formula_milk_5' => 'nullable|string|max:255',
            'exclusive_breastfeeding_formula_milk_6' => 'nullable|string|max:255',
            'exclusive_breastfeeding_other_liquid_1' => 'nullable|string|max:255',
            'exclusive_breastfeeding_other_liquid_2' => 'nullable|string|max:255',
            'exclusive_breastfeeding_other_liquid_3' => 'nullable|string|max:255',
            'exclusive_breastfeeding_other_liquid_4' => 'nullable|string|max:255',
            'exclusive_breastfeeding_other_liquid_5' => 'nullable|string|max:255',
            'exclusive_breastfeeding_other_liquid_6' => 'nullable|string|max:255',

            // Row 12
            'child_sick_counseled' => 'nullable|boolean',
            'mother_sick_counseled' => 'nullable|boolean',
            'child_sick_practiced' => 'nullable|boolean',
            'mother_sick_practiced' => 'nullable|boolean',

            // Row 13
            'continue_breastfeed_beyond_2_counseled' => 'nullable|boolean',
            'continue_breastfeed_beyond_2_practiced' => 'nullable|boolean',

            // Row 14
            'backyard_gardening_counseled' => 'nullable|boolean',
            'backyard_gardening_practiced' => 'nullable|boolean',
            'clean_environment_counseled' => 'nullable|boolean',
            'clean_environment_practiced' => 'nullable|boolean',
            'sanitary_counseled' => 'nullable|boolean',
            'sanitary_practiced' => 'nullable|boolean',
            'potable_water_counseled' => 'nullable|boolean',
            'potable_water_practiced' => 'nullable|boolean',
        ]);

        // Save the validated data to the database
        PNEAEnrollment::create($validatedData);

        session()->flash('message', 'Data has been added successfully!');

        return redirect()->route('pnea-enrollment-view'); 
    }

    //add pregnancy period data
    public function addPregnancyPeriod(Request $request, $pnea_id)
    {
        $validatedData = $request->validate([
            'month' => 'required|string',
            'weight' => 'required|numeric',
            'height' => 'required|numeric',
            'bmi' => 'nullable|numeric',
            'status' => 'nullable|string',
            'muac' => 'nullable|numeric',  
            'muac_color' => 'nullable|string',
            'muac_status' => 'nullable|string', 
        ]);

        $pnea = PNEAEnrollment::findOrFail($pnea_id);
        $record = $pnea->pregnancyPeriods()->create($validatedData);
        
        return response()->json(['message' => 'New record added successfully!', 'record' => $record]);
    }

    //add pregnancy period data
    public function addLactatingPeriod(Request $request, $pnea_id)
    {
        $validatedData = $request->validate([
            'month' => 'required|string',
            'weight' => 'required|numeric',
            'height' => 'required|numeric',
            'bmi' => 'nullable|numeric',
            'status' => 'nullable|string',
            'muac' => 'nullable|numeric',  
            'muac_color' => 'nullable|string',
            'muac_status' => 'nullable|string', 
        ]);

        $pnea = PNEAEnrollment::findOrFail($pnea_id);
        $record = $pnea->lactatingPeriods()->create($validatedData);
        
        return response()->json(['message' => 'New record added successfully!', 'record' => $record]);
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
        
        $pnea->prenatal_care_counseled = $request->prenatal_care_counseled;
        $pnea->prenatal_care_date_counseled = $request->prenatal_care_date_counseled;
        $pnea->prenatal_care_practiced = $request->prenatal_care_practiced;

        $pnea->prenatal_checkup_counseled = $request->prenatal_checkup_counseled;
        $pnea->prenatal_checkup_date_counseled = $request->prenatal_checkup_date_counseled;
        $pnea->prenatal_care_date_1 = $request->prenatal_care_date_1;
        $pnea->prenatal_care_date_2 = $request->prenatal_care_date_2;
        $pnea->prenatal_care_date_3 = $request->prenatal_care_date_3;
        $pnea->prenatal_care_date_4 = $request->prenatal_care_date_4;
        $pnea->prenatal_care_date_5 = $request->prenatal_care_date_5;
        $pnea->prenatal_care_date_6 = $request->prenatal_care_date_6;
        $pnea->prenatal_care_date_7 = $request->prenatal_care_date_7;
        $pnea->prenatal_care_date_8 = $request->prenatal_care_date_8;
        $pnea->prenatal_care_date_9 = $request->prenatal_care_date_9;

        $pnea->iron_folic_acid_counseled = $request->iron_folic_acid_counseled;
        $pnea->iron_folic_acid_date_counseled = $request->iron_folic_acid_date_counseled;
        $pnea->iron_folic_acid_date_1 = $request->iron_folic_acid_date_1;
        $pnea->iron_folic_acid_date_2 = $request->iron_folic_acid_date_2;
        $pnea->iron_folic_acid_date_3 = $request->iron_folic_acid_date_3;
        $pnea->iron_folic_acid_date_4 = $request->iron_folic_acid_date_4;
        $pnea->iron_folic_acid_date_5 = $request->iron_folic_acid_date_5;
        $pnea->iron_folic_acid_date_6 = $request->iron_folic_acid_date_6;
        $pnea->iron_folic_acid_date_7 = $request->iron_folic_acid_date_7;
        $pnea->iron_folic_acid_date_8 = $request->iron_folic_acid_date_8;
        $pnea->iron_folic_acid_date_9 = $request->iron_folic_acid_date_9;

        $pnea->iodized_salt_counseled = $request->iodized_salt_counseled;
        $pnea->iodized_salt_date_counseled = $request->iodized_salt_date_counseled;
        $pnea->iodized_salt_practiced = $request->iodized_salt_practiced;

        $pnea->tetanus_counseled = $request->tetanus_counseled;
        $pnea->tetanus_date_counseled = $request->tetanus_date_counseled;
        $pnea->dose_date_1 = $request->dose_date_1;
        $pnea->dose_date_2 = $request->dose_date_2;
        $pnea->dose_date_3 = $request->dose_date_3;
        $pnea->dose_date_4 = $request->dose_date_4;
        $pnea->dose_date_5 = $request->dose_date_5;

        $pnea->initiation = $request->initiation;
        $pnea->exclusivity = $request->exclusivity;
        $pnea->duration = $request->duration;
        $pnea->dietary_intake = $request->dietary_intake;
        $pnea->personal_willingness = $request->personal_willingness;
        $pnea->family_support = $request->family_support;
        $pnea->initiation_counseled = $request->initiation_counseled;
        $pnea->exclusivity_counseled = $request->exclusivity_counseled;
        $pnea->duration_counseled = $request->duration_counseled;
        $pnea->dietary_intake_counseled = $request->dietary_intake_counseled;
        $pnea->personal_willingness_counseled = $request->personal_willingness_counseled;
        $pnea->family_support_counseled = $request->family_support_counseled;
        $pnea->initiation_start_date_practiced = $request->initiation_start_date_practiced;
        $pnea->initiation_end_date_practiced = $request->initiation_end_date_practiced;
        $pnea->exclusivity_start_date_practiced = $request->exclusivity_start_date_practiced;
        $pnea->exclusivity_end_date_practiced = $request->exclusivity_end_date_practiced;
        $pnea->duration_start_date_practiced = $request->duration_start_date_practiced;
        $pnea->duration_end_date_practiced = $request->duration_end_date_practiced;

        $pnea->proper_infant = $request->proper_infant;
        $pnea->nutripak = $request->nutripak;
        $pnea->health_nutrition = $request->health_nutrition;
        $pnea->membership = $request->membership;
        $pnea->plant_malunggay = $request->plant_malunggay;
        $pnea->other_interventions = $request->other_interventions;
        $pnea->proper_infant_counseled = $request->proper_infant_counseled;
        $pnea->nutripak_counseled = $request->nutripak_counseled;
        $pnea->health_nutrition_counseled = $request->health_nutrition_counseled;
        $pnea->membership_counseled = $request->membership_counseled;
        $pnea->plant_malunggay_counseled = $request->plant_malunggay_counseled;
        $pnea->other_interventions_counseled = $request->other_interventions_counseled;
        $pnea->proper_infant_practiced = $request->proper_infant_practiced;
        $pnea->nutripak_practiced = $request->nutripak_practiced;
        $pnea->health_nutrition_practiced = $request->health_nutrition_practiced;
        $pnea->membership_member_practiced = $request->membership_member_practiced;
        $pnea->membership_leader_practiced = $request->membership_leader_practiced;
        $pnea->plant_malunggay_number_practiced = $request->plant_malunggay_number_practiced;
        $pnea->date_planted_practiced = $request->date_planted_practiced;
        $pnea->location_practiced = $request->location_practiced;
        $pnea->other_interventions_practiced = $request->other_interventions_practiced;

        $pnea->postnatal_checkup_counseled = $request->postnatal_checkup_counseled;
        $pnea->postnatal_checkup_date_counseled = $request->postnatal_checkup_date_counseled;
        $pnea->postnatal_last_checkup_date_practiced = $request->postnatal_last_checkup_date_practiced;

        $pnea->iron_supplementation_counseled = $request->iron_supplementation_counseled;
        $pnea->iron_supplementation_date_counseled = $request->iron_supplementation_date_counseled;
        $pnea->iron_supplementation_last_date_taken_practiced = $request->iron_supplementation_last_date_taken_practiced;
        $pnea->iron_supplementation_amount_practiced = $request->iron_supplementation_amount_practiced;

        $pnea->breastfeeding_initiation_counseled = $request->breastfeeding_initiation_counseled;
        $pnea->breastfeeding_initiation_date_counseled = $request->breastfeeding_initiation_date_counseled;
        $pnea->normal_delivery = $request->normal_delivery;
        $pnea->cs_delivery = $request->cs_delivery;

        $pnea->given_colostrums = $request->given_colostrums;
        $pnea->no_water_given = $request->no_water_given;
        $pnea->no_food_given = $request->no_food_given;
        $pnea->no_vitamins_given = $request->no_vitamins_given;
        $pnea->no_formula_milk_given = $request->no_formula_milk_given;
        $pnea->no_other_liquid_given = $request->no_other_liquid_given;
        $pnea->exclusive_breastfeeding_colostrums_1 = $request->exclusive_breastfeeding_colostrums_1;
        $pnea->exclusive_breastfeeding_colostrums_2 = $request->exclusive_breastfeeding_colostrums_2;
        $pnea->exclusive_breastfeeding_colostrums_3 = $request->exclusive_breastfeeding_colostrums_3;
        $pnea->exclusive_breastfeeding_colostrums_4 = $request->exclusive_breastfeeding_colostrums_4;
        $pnea->exclusive_breastfeeding_colostrums_5 = $request->exclusive_breastfeeding_colostrums_5;
        $pnea->exclusive_breastfeeding_colostrums_6 = $request->exclusive_breastfeeding_colostrums_6;
        $pnea->exclusive_breastfeeding_water_1 = $request->exclusive_breastfeeding_water_1;
        $pnea->exclusive_breastfeeding_water_2 = $request->exclusive_breastfeeding_water_2;
        $pnea->exclusive_breastfeeding_water_3 = $request->exclusive_breastfeeding_water_3;
        $pnea->exclusive_breastfeeding_water_4 = $request->exclusive_breastfeeding_water_4;
        $pnea->exclusive_breastfeeding_water_5 = $request->exclusive_breastfeeding_water_5;
        $pnea->exclusive_breastfeeding_water_6 = $request->exclusive_breastfeeding_water_6;
        $pnea->exclusive_breastfeeding_food_1 = $request->exclusive_breastfeeding_food_1;
        $pnea->exclusive_breastfeeding_food_2 = $request->exclusive_breastfeeding_food_2;
        $pnea->exclusive_breastfeeding_food_3 = $request->exclusive_breastfeeding_food_3;
        $pnea->exclusive_breastfeeding_food_4 = $request->exclusive_breastfeeding_food_4;
        $pnea->exclusive_breastfeeding_food_5 = $request->exclusive_breastfeeding_food_5;
        $pnea->exclusive_breastfeeding_food_6 = $request->exclusive_breastfeeding_food_6;
        $pnea->exclusive_breastfeeding_vitamins_1 = $request->exclusive_breastfeeding_vitamins_1;
        $pnea->exclusive_breastfeeding_vitamins_2 = $request->exclusive_breastfeeding_vitamins_2;
        $pnea->exclusive_breastfeeding_vitamins_3 = $request->exclusive_breastfeeding_vitamins_3;
        $pnea->exclusive_breastfeeding_vitamins_4 = $request->exclusive_breastfeeding_vitamins_4;
        $pnea->exclusive_breastfeeding_vitamins_5 = $request->exclusive_breastfeeding_vitamins_5;
        $pnea->exclusive_breastfeeding_vitamins_6 = $request->exclusive_breastfeeding_vitamins_6;
        $pnea->exclusive_breastfeeding_formula_milk_1 = $request->exclusive_breastfeeding_formula_milk_1;
        $pnea->exclusive_breastfeeding_formula_milk_2 = $request->exclusive_breastfeeding_formula_milk_2;
        $pnea->exclusive_breastfeeding_formula_milk_3 = $request->exclusive_breastfeeding_formula_milk_3;
        $pnea->exclusive_breastfeeding_formula_milk_4 = $request->exclusive_breastfeeding_formula_milk_4;
        $pnea->exclusive_breastfeeding_formula_milk_5 = $request->exclusive_breastfeeding_formula_milk_5;
        $pnea->exclusive_breastfeeding_formula_milk_6 = $request->exclusive_breastfeeding_formula_milk_6;
        $pnea->exclusive_breastfeeding_other_liquid_1 = $request->exclusive_breastfeeding_other_liquid_1;
        $pnea->exclusive_breastfeeding_other_liquid_2 = $request->exclusive_breastfeeding_other_liquid_2;
        $pnea->exclusive_breastfeeding_other_liquid_3 = $request->exclusive_breastfeeding_other_liquid_3;
        $pnea->exclusive_breastfeeding_other_liquid_4 = $request->exclusive_breastfeeding_other_liquid_4;
        $pnea->exclusive_breastfeeding_other_liquid_5 = $request->exclusive_breastfeeding_other_liquid_5;
        $pnea->exclusive_breastfeeding_other_liquid_6 = $request->exclusive_breastfeeding_other_liquid_6;

        $pnea->child_sick_counseled = $request->child_sick_counseled;
        $pnea->mother_sick_counseled = $request->mother_sick_counseled;
        $pnea->child_sick_practiced = $request->child_sick_practiced;
        $pnea->mother_sick_practiced = $request->mother_sick_practiced;

        $pnea->continue_breastfeed_beyond_2_counseled = $request->continue_breastfeed_beyond_2_counseled;
        $pnea->continue_breastfeed_beyond_2_practiced = $request->continue_breastfeed_beyond_2_practiced;

        $pnea->backyard_gardening_counseled = $request->backyard_gardening_counseled;
        $pnea->backyard_gardening_practiced = $request->backyard_gardening_practiced;
        $pnea->clean_environment_counseled = $request->clean_environment_counseled;
        $pnea->clean_environment_practiced = $request->clean_environment_practiced;
        $pnea->sanitary_counseled = $request->sanitary_counseled;
        $pnea->sanitary_practiced = $request->sanitary_practiced;
        $pnea->potable_water_counseled = $request->potable_water_counseled;
        $pnea->potable_water_practiced = $request->potable_water_practiced;

        
        $pnea->save();

        return response()->json($pnea);
    }
    

    //show data from a specific record
    public function show($id)
    {
        
      
        $pnea = PNEAEnrollment::with('pneaEnrollment','pregnancyPeriods','lactatingPeriods')->findOrFail($id);

        // dd(response()->json($pnea));
    

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

    //delete specific data
    public function destroy($id)
    {
        $pnea = PNEAEnrollment::findOrFail($id);
        $pnea->delete();

        return response()->json($pnea);
    }
    

}
