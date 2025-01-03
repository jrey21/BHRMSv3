<?php

namespace App\Http\Controllers;

use App\Models\ChildCareForm;
use App\Models\DevelopmentalScreening;
use Illuminate\Http\Request;

class DevelopmentalScreeningController extends Controller
{
    public function child()
    {
        return $this->belongsTo(ChildCareForm::class, 'child_id');
    }
}
