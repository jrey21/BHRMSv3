<?php

namespace App\Http\Controllers;

use App\Models\ChildCareForm;
use App\Models\GrowthMonitoring; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GrowthMonitoringController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $growth_monitorings = GrowthMonitoring::all();
        return response()->json($growth_monitorings);
    }

    public function underweight()
    {
        $underweight = GrowthMonitoring::select('growth_monitorings.*')
            ->join(DB::raw('(SELECT child_id, MAX(date) as latest_date FROM growth_monitorings GROUP BY child_id) as latest_records'), function ($join) {
                $join->on('growth_monitorings.child_id', '=', 'latest_records.child_id')
                    ->on('growth_monitorings.date', '=', 'latest_records.latest_date');
            })
            ->where(function ($query) {
                $query->where('weight_age_status', 'Severely Underweight')
                    ->orWhere('weight_age_status', 'Underweight');
            })
            ->get();

        return response()->json($underweight);
    }

    public function child()
    {
        return $this->belongsTo(ChildCareForm::class, 'child_id');
    }
}
