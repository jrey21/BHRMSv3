<?php

namespace App\Http\Controllers;

use App\Models\ChildCareForm;
use App\Models\Deworming;
use Illuminate\Http\Request;

class DewormingController extends Controller
{
    public function child()
    {
        return $this->belongsTo(ChildCareForm::class, 'child_id');
    }
}
