<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counseling extends Model
{
    use HasFactory;

    protected $table = 'counseling';

    protected $fillable = [
        'child_id',
        'breastfeeding_status',
        'duration',
        'feeding_start_age',
        'feeding_start_age_unit',
        'frequency_of_feeding', 
        'types_of_food',
        'date'
    ];

    public function child()
    {
        return $this->belongsTo(ChildCareForm::class, 'child_id');
    }
}
