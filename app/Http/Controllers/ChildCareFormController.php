<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChildCareForm;
use Inertia\Inertia;

class ChildCareFormController extends Controller
{
    // Store the data to the database
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'family_no' => 'required|string|max:255',
            'child_no' => 'required|string|max:255',
            'zone' => 'required|string|max:255',
            'complete_address' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'mother_name' => 'required|string|max:255',
            'mother_education' => 'required|string|max:255',
            'mother_occupation' => 'required|string|max:255',
            'no_pregancies' => 'required|integer',
            'father_name' => 'required|string|max:255',
            'father_education' => 'required|string|max:255',
            'father_occupation' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gestational_age' => 'required|string',
            'type_of_birth' => 'required|string|max:255',
            'birth_order' => 'required|integer',
            'birth_weight' => 'required|numeric',
            'birth_length' => 'required|numeric',
            'birth_place' => 'required|string|max:255',
            'other_birth_place' => 'nullable|string|max:255',
            'birth_registered' => 'required|date',
            'birth_attendant' => 'required|string|max:255',
            'other_birth_attendant' => 'nullable|string|max:255',
        ]);

        ChildCareForm::create($validatedData);
        
        session()->flash('message', 'Data has been added successfully!');

        // return redirect()->route('childcare-form-view');  
    }

    // Retrieve all the data from the database
    public function retrieve()
    {
        $childcareForms = ChildCareForm::all();
        return response()->json($childcareForms);
    }

    // Edit data from the database
    public function edit($id)
    {

        $childcareForm = ChildCareForm::findOrFail($id);
        return Inertia::render('ChildCareForm/Edit', [
            'form' => $childcareForm,
        ]);
    }

    //Update data to the database
    public function update(Request $request, $id)
    {
        $child = ChildCareForm::findOrFail($id);
        $child->family_no = $request->input('family_no');
        $child->child_no = $request->input('child_no');
        $child->zone = $request->input('zone');
        $child->complete_address = $request->input('complete_address');
        $child->last_name = $request->input('last_name');
        $child->first_name = $request->input('first_name');
        $child->middle_name = $request->input('middle_name');
        $child->suffix = $request->input('suffix');
        $child->mother_name = $request->input('mother_name');
        $child->mother_education = $request->input('mother_education');
        $child->mother_occupation = $request->input('mother_occupation');
        $child->no_pregancies = $request->input('no_pregancies');
        $child->father_name = $request->input('father_name');
        $child->father_education = $request->input('father_education');
        $child->father_occupation = $request->input('father_occupation');
        $child->birth_date = $request->input('birth_date');
        $child->gestational_age = $request->input('gestational_age');
        $child->type_of_birth = $request->input('type_of_birth');
        $child->birth_order = $request->input('birth_order');
        $child->birth_weight = $request->input('birth_weight');
        $child->birth_length = $request->input('birth_length');
        $child->birth_place = $request->input('birth_place');
        $child->other_birth_place = $request->input('other_birth_place');
        $child->birth_registered = $request->input('birth_registered');
        $child->birth_attendant = $request->input('birth_attendant');
        $child->other_birth_attendant = $request->input('other_birth_attendant');
        $child->save();

        return response()->json($child);
    }   

    // Show data from a single child
    public function show($id)
    {
        $child = ChildCareForm::with('vaccinationRecords','vitaminASupplementation','counseling','growthMonitorings','developmentalScreening','deworming','dental')->findOrFail($id); 
        return Inertia::render('ChildCareForm/Show', [
            'child' => $child,
        ]);

        // return response()->json($child);
    }

    // Add a vaccination record for a specific child
    public function addVac(Request $request, $child_id)
    {
        $validatedData = $request->validate([
            'vaccine_name' => 'required|string|max:255',
            'other_vaccine_name' => 'nullable|string|max:255',
            'dose_number' => 'required|string|max:255',
            'date' => 'required|date',
            'status' => 'nullable|string|max:255',
        ]);

        $child = ChildCareForm::findOrFail($child_id);
        $record = $child->vaccinationRecords()->create($validatedData);

        return response()->json(['message' => 'Vaccination record added successfully!', 'record' => $record]);
    }

    //Add a vitamin A supplementation record for a specific child
    public function addVitA(Request $request, $child_id)
    {
        $validatedData = $request->validate([
            'age'=> 'required|integer|max:255',
            'age_unit' => 'required|string|max:255',
            'dose' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        $child = ChildCareForm::findOrFail($child_id);
        $record = $child->vitaminASupplementation()->create($validatedData);

        return response()->json(['message' => 'Vitamin A Supplementation record added successfully!', 'record' => $record]);
    }

    // Add a counseling record for a specific child
    public function addCounseling(Request $request, $child_id)
    {
        $validatedData = $request->validate([
            'breastfeeding_status'=> 'required|string|max:255',
            'duration'=> 'required|string|max:255',
            'feeding_start_age'=> 'required|integer|max:255',
            'feeding_start_age_unit' => 'required|string|max:255',
            'frequency_of_feeding' => 'required|string|max:255', 
            'types_of_food' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        $child = ChildCareForm::findOrFail($child_id);
        $record = $child->counseling()->create($validatedData);

        return response()->json(['message' => 'Counseling record added successfully!', 'record' => $record]);
    }

    //Add a growth monitoring record for a specific child
    public function addGrowthMonitoring(Request $request, $child_id)
    {
        $validatedData = $request->validate([
            'weight'=> 'required|numeric',
            'height'=> 'required|numeric',
            'age'=> 'required|integer',
            'date' => 'date',
            'sex' => 'string|max:255',
            'weight_status' => 'string|max:255',
            'weight_for_age_status' => 'string|max:255',
            'height_for_age_status' => 'string|max:255',
            'weight_for_height_status' => 'string|max:255',
            'bmi' => 'numeric',
        ]);

        $child = ChildCareForm::findOrFail($child_id);
        $record = $child->growthMonitorings()->create($validatedData);

        return response()->json(['message' => 'Growth Monitoring record added successfully!', 'record' => $record]);
    }

    //Add developmental screening record for a specific child

    public function addDevelopmentalScreening(Request $request, $child_id)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'age' => 'required|integer',
            'age_unit' => 'required|string|max:255',
            'milestones_achieved' => 'required|string|max:255',
            'developmental_concerns' => 'required|string|max:255',
        ]);

        $child = ChildCareForm::findOrFail($child_id);
        $record = $child->developmentalScreening()->create($validatedData);

        return response()->json(['message' => 'Developmental Screening record added successfully!', 'record' => $record]);
    }

    //add deworming record for a specific child
    public function addDeworming(Request $request, $child_id)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'age' => 'required|integer',
            'age_unit' => 'required|string|max:255',
            'deworming_medicine' => 'required|string|max:255',
            'other_deworming_medicine' => 'nullable|string|max:255',
            'administered_by' => 'required|string|max:255',

        ]);

        $child = ChildCareForm::findOrFail($child_id);
        $record = $child->deworming()->create($validatedData);

        return response()->json(['message' => 'Deworming record added successfully!', 'record' => $record]);
    }

    //add dental checkup record for a specific child
    public function addDental(Request $request, $child_id)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'dentist' => 'required|string|max:255',
            'findings' => 'required|string|max:255',
            'treatment' => 'required|string|max:255',
        ]);

        $child = ChildCareForm::findOrFail($child_id);
        $record = $child->dental()->create($validatedData);

        return response()->json(['message' => 'Dental Checkup record added successfully!', 'record' => $record]);
    }


    // display all the growth monitoring records of children who have growth monitoring data
    public function showGrowthMonitoring()
    {
        $childcareForms = ChildCareForm::whereHas('growthMonitorings')->with('growthMonitorings')->get();
        return response()->json($childcareForms);
    }

    //display all the vaccination records of children who have vaccination records
    public function showVaccinationRecord()
    {
        $childcareForms = ChildCareForm::whereHas('vaccinationRecords')->with('vaccinationRecords')->get();
        return response()->json($childcareForms);
    }     
}