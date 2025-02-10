<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScannedCode;
use App\Models\SeniorEvent;
use Illuminate\Support\Facades\DB;

class ScannedCodeController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'eventId' => 'required|integer',
            'scannedCodes' => 'required|string'
        ]);

        $scannedCodesArray = explode(',', $validatedData['scannedCodes']);
        $existingCodes = ScannedCode::where('event_id', $validatedData['eventId'])
                                    ->whereIn('scanned_codes', $scannedCodesArray)
                                    ->pluck('scanned_codes')
                                    ->toArray();

        $newCodes = array_diff($scannedCodesArray, $existingCodes);

        if (!empty($newCodes)) {
            $scannedData = new ScannedCode();
            $scannedData->event_id = $validatedData['eventId'];
            $scannedData->scanned_codes = implode(',', $newCodes);
            $scannedData->save();

            // Update the status of senior citizens based on new scanned codes
            foreach ($newCodes as $code) {
                $senior = SeniorCitizen::find($code);
                if ($senior) {
                    $senior->status = 'Claimed';
                    $senior->save();
                }
            }
        }

        return response()->json(['message' => 'Scanned data saved successfully'], 200);
    }

    //display all scanned codes
    public function index()
    {
        $scanned_codes = ScannedCode::all();
        return response()->json($scanned_codes);
    }

    //display scanned codes by event
    public function show($event_id)
    {
        $scanned_codes = ScannedCode::where('event_id', $event_id)->get();
        return response()->json($scanned_codes);
    }

    //display scanned codes by event and code
    public function showByCode($event_id, $code)
    {
        $scanned_codes = ScannedCode::where('event_id', $event_id)->where('code', $code)->get();
        return response()->json($scanned_codes);
    }

    public function event()
    {
        return $this->belongsTo(SeniorEvent::class, 'event_id');
    }

    //retrieve all data from the database
    public function retrieveData()
    {
        $scanned_codes  = ScannedCode::all();
        return response()->json($scanned_codes );
    }


}
?>
