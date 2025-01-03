<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Inertia\Inertia;

class ComprehensiveSurvey extends Model
{
    use HasFactory;

    protected $fillable = [
        'household_number',
        'family_number',
        'zone',
        'last_name',
        'first_name',
        'middle_name',
        'suffix',
        'age',
        'age_unit',
        'sex',
        'civil_status',
        'birth_date',
        'education',
        'religion',
        'occupation',
        'sanitary_access',
        'water_source',
        'family_planning',
        'lgbt',
        'pwd',
        'four_ps',
        'non_hts',
        'remarks',
    ];

    public function comprehensiveSurvey()
    {
        return $this->hasMany(ComprehensiveSurvey::class, 'id');
    }
}