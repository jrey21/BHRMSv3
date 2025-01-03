<?php

namespace App\Http\Controllers;

use App\Models\ChildCareForm;
use App\Models\Counseling;
use Illuminate\Http\Request;

class CounselingController extends Controller
{
    public function child()
    {
        return $this->belongsTo(ChildCareForm::class, 'child_id');
    }
}
