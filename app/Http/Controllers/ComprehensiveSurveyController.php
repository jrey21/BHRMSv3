<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ComprehensiveSurvey;
use Inertia\Inertia;
use Carbon\Carbon;

class ComprehensiveSurveyController extends Controller
{
    public function survey(Request $request)
    {    
        // Validate the form data
        $validatedData = $request->validate([
            'householdNumber' => ['required', 'string', 'max:255'],
            'zone' => ['string', 'max:255'],
            'family_number' => ['required', 'integer', 'min:1'],
            'personalInfo.*.lastName' => ['required', 'string', 'max:255'],
            'personalInfo.*.firstName' => ['required', 'string', 'max:255'],
            'personalInfo.*.middleName' => ['nullable', 'string', 'max:255'],
            'personalInfo.*.suffix' => ['nullable', 'string', 'max:255'],
            // 'personalInfo.*.age' => ['required', 'integer', 'min:0'],
            // 'personalInfo.*.age_unit' => ['required', 'string', 'max:255'],
            'personalInfo.*.sex' => ['required', 'string', 'max:255'],
            'personalInfo.*.civilStatus' => ['required', 'string', 'max:255'],
            'personalInfo.*.birth_date' => ['required', 'date'],
            'personalInfo.*.education' => ['required', 'string', 'max:255'],
            'personalInfo.*.religion' => ['required', 'string', 'max:255'],
            'personalInfo.*.occupation' => ['required', 'string', 'max:255'],
            'personalInfo.*.sanitaryAccess' => ['required', 'string', 'max:255'],
            'personalInfo.*.waterSource' => ['required', 'string', 'max:255'],
            'personalInfo.*.familyPlanning' => ['required', 'string', 'max:255'],
            'personalInfo.*.lgbt' => ['required', 'boolean'],
            'personalInfo.*.pwd' => ['required', 'boolean'],
            'personalInfo.*.fourPs' => ['required', 'boolean'],
            'personalInfo.*.nonHTS' => ['required', 'boolean'],
            'remarks' => ['nullable', 'max:255'],
        ]);

        foreach ($validatedData['personalInfo'] as $personalInfo) {
            ComprehensiveSurvey::create([
                'household_number' => $validatedData['householdNumber'],
                'zone' => $validatedData['zone'],
                'family_number' => $validatedData['family_number'],
                'last_name' => $personalInfo['lastName'],
                'first_name' => $personalInfo['firstName'],
                'middle_name' => $personalInfo['middleName'],
                'suffix' => $personalInfo['suffix'],
                // 'age' => $personalInfo['age'],
                // 'age_unit' => $personalInfo['age_unit'],
                'sex' => $personalInfo['sex'],
                'civil_status' => $personalInfo['civilStatus'],
                'birth_date' => $personalInfo['birth_date'],
                'education' => $personalInfo['education'],
                'religion' => $personalInfo['religion'],
                'occupation' => $personalInfo['occupation'],
                'sanitary_access' => $personalInfo['sanitaryAccess'],
                'water_source' => $personalInfo['waterSource'],
                'family_planning' => $personalInfo['familyPlanning'],
                'lgbt' => $personalInfo['lgbt'],
                'pwd' => $personalInfo['pwd'],
                'four_ps' => $personalInfo['fourPs'],
                'non_hts' => $personalInfo['nonHTS'],
                'remarks' => $validatedData['remarks'] ?? null,
            ]);
        }

        // return redirect()->route('comprehensive-survey-view')->with('success', 'Survey submitted successfully!');
    }

    // Retrieve all the data from the database
    public function retrieve()
    {
        $comprehensiveSurveys = ComprehensiveSurvey::all();
        return response()->json($comprehensiveSurveys);
    }

    // Retrieve a specific data from the database
    public function show($id)
    {
        $survey = ComprehensiveSurvey::with('comprehensiveSurvey')->findOrFail($id);
        
        return Inertia::render('ComprehensiveSurvey/Show', [
            'survey' => $survey,
        ]);
    }

    // Edit a specific data from the database
    public function edit($id)
    {
        $survey = ComprehensiveSurvey::findOrFail($id);
        
        return Inertia::render('ComprehensiveSurvey/Edit', [
            'survey' => $survey,
        ]);
    }

    //Fetch senior citizen data
    public function seniorCitizen()
    {
        $today = Carbon::today();
        $seniorCitizen = ComprehensiveSurvey::whereRaw("TIMESTAMPDIFF(YEAR, birth_date, ?) >= 60", [$today])->get();
        return response()->json($seniorCitizen);   
    }

    //Fetch four ps data
    public function fourPs()
    {
        $fourPs = ComprehensiveSurvey::where('four_ps', 1)->get();
        return response()->json($fourPs);   
    }

    //Fetch pwd data
    public function pwd()
    {
        $pwd = ComprehensiveSurvey::where('pwd', 1)->get();
        return response()->json($pwd);   
    }

    //Update a specific data from the database
    public function update(Request $request, $id)
    {
        $survey = ComprehensiveSurvey::findOrFail($id);
        $survey->zone = $request->input('zone');
        $survey->last_name = $request->input('last_name');
        $survey->first_name = $request->input('first_name');
        $survey->middle_name = $request->input('middle_name');
        $survey->suffix = $request->input('suffix');
        $survey->birth_date = $request->input('birth_date');
        $survey->sex = $request->input('sex');
        $survey->civil_status = $request->input('civil_status');
        $survey->education = $request->input('education');
        $survey->religion = $request->input('religion');
        $survey->occupation = $request->input('occupation');

        $survey->save();

        return response()->json($survey);
    }   

    //Delete a specific data from the database
    public function destroy($id)
    {
        $survey = ComprehensiveSurvey::findOrFail($id);
        $survey->delete();

        return response()->json($survey);
    }

    // Function to retrieve all zones without sorting
    public function retrieveAndSortZones()
    {
        $zones = ComprehensiveSurvey::select('zone')->get();
        return response()->json($zones);
    }
}
