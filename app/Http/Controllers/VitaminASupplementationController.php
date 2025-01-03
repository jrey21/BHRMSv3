<?php

namespace App\Http\Controllers;

use App\Models\ChildCareForm;
use App\Models\VitaminASupplementation;
use Illuminate\Http\Request;

class VitaminASupplementationController extends Controller
{
    public function child()
    {
        return $this->belongsTo(ChildCareForm::class, 'child_id');
    }
}
