<?php

namespace App\Http\Controllers;

use App\Models\ChildCareForm;
use App\Models\GrowthMonitoring; 
use Illuminate\Http\Request;

class GrowthMonitoringController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $growth_monitorings = GrowthMonitoring::all();
        return response()->json($growth_monitorings);
    }

   //display all the latest data of underwight in weight_of_height in each child in the growth monitoring table
    public function underweight()
    {
        $underweight = GrowthMonitoring::where('weight_of_height', '<', 80)->get();
        return response()->json($underweight);
    }


    public function child()
    {
        return $this->belongsTo(ChildCareForm::class, 'child_id');
    }
}
