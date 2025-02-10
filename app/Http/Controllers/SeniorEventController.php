<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SeniorEvent;
use Inertia\Inertia;

class SeniorEventController extends Controller
{
    //store
    public function store (Request $request)
    {
        $request->validate([
            'title' => 'required',
            'date' => 'required',
            'location' => 'required',
        ]);

        SeniorEvent::create($request->all());

        session()->flash('message', 'Data has been added successfully!');
    }

    //retrieve
    public function retrieve()
    {
        $seniorEvents = SeniorEvent::all();
        return response()->json($seniorEvents);
    }

    //show (retrieve by id)
    public function show($id)
    {
        $seniorEvent = SeniorEvent::with('seniorEvent')->findOrFail($id);

        // dd($seniorEvent);
        return Inertia::render('SeniorCitizen/Show', [
            'seniorEvent' => $seniorEvent,
        ]);
    }

    //add scanned code
    public function addScannedCode(Request $request, $event_id)
    {
        $validatedData = $request->validate([
            'code'=> 'required|string',
        ]);

        $event = SeniorEvent::findOrFail($event_id);
        $record = $event->scannedCodes()->create($validatedData);

        return response()->json(['message' => 'Data added successfully!', 'record' => $record]);
    }

    //show scanned codes in a specific event
    public function showScannedCodes($event_id)
    {
        $event = SeniorEvent::with('scannedCodes')->findOrFail($event_id);
        return response()->json($event->scannedCodes);
    }

}
