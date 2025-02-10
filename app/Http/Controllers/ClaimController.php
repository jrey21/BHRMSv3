<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Claim;

class ClaimController extends Controller
{
    public function scanQrCode(Request $request)
    {
        $surveyId = $request->input('survey_id');
        $eventId = $request->input('event_id');
    
        // Check if already claimed
        $existingClaim = Claim::where('event_id', $eventId)->where('survey_id', $surveyId)->first();
    
        if ($existingClaim) {
            return response()->json(['message' => 'Already claimed'], 400);
        }
    
        // Insert claim
        Claim::create([
            'event_id' => $eventId,
            'survey_id' => $surveyId,
            'claimed_at' => now(),
        ]);
    
        return response()->json(['message' => 'Claim recorded']);
    }
}
