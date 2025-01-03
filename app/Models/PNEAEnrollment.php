<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Inertia\Inertia;

class PNEAEnrollment extends Model
{
    use HasFactory;

    protected $table = 'pnea_enrollment';

    protected $fillable = [
        'pinkCardNumber',
        'date',
        'zone',
        'fullName',
        'birth_date',
        'age',
        'education',
        'occupation',
        'term_of_pregnancy',
        'number_of_pregnancy',
        'date_last_delivery',
        'number_of_children',
        'interval_of_delivery',
        'muac',
        'height',
        'weight',
        'bmi',
        'ns',
        'name_of_husband',
        'husband_age',
        'husband_education',
        'husband_occupation',
        'monthly_family_income',
        'household_size',
    ];

    public function optimumPractice()
    {
        return $this->hasMany(OptimumPractice::class,'pnea_id');
    }
}
