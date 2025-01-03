<?php

namespace App\Http\Controllers;

use App\Models\ChildCareForm;
use App\Models\Dental;
use Illuminate\Http\Request;

class DentalController extends Controller
{
    public function child()
    {
        return $this->belongsTo(ChildCareForm::class, 'child_id');
    }
}
