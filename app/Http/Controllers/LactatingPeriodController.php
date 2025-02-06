<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PNEAEnrollment;
use App\Models\LactatingPeriod;

class LactatingPeriodController extends Controller
{
    public function pnea()
    {
        return $this->belongsTo(PNEAEnrollment::class, 'pnea_id');
    }
}
