<?php

namespace App\Http\Controllers;

use App\Models\PregnancyPeriod;
use App\Models\PNEAEnrollment;
use Illuminate\Http\Request;

class PregnancyPeriodController extends Controller
{
    public function pnea()
    {
        return $this->belongsTo(PNEAEnrollment::class, 'pnea_id');
    }
}
