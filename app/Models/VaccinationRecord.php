<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccinationRecord extends Model
{
    use HasFactory;

    protected $table = 'vaccination_records';
    
    protected $fillable = [
        'child_id',
        'vaccine_name',
        'other_vaccine_name',
        'dose_number',
        'date',
        'status',
    ];

    public function child()
    {
        return $this->belongsTo(ChildCareForm::class, 'child_id');
    }
}

