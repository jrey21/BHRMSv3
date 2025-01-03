<?php
namespace App\Http\Controllers;

use App\Models\ChildCareForm;
use App\Models\VaccinationRecord; 
use Illuminate\Http\Request;

class VaccinationRecordController extends Controller
{
    public function child()
    {
        return $this->belongsTo(ChildCareForm::class, 'child_id');
    }

}
