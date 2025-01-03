<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrowthMonitoring extends Model
{
    use HasFactory;

    protected $table = 'growth_monitorings';

    protected $fillable = [
        'child_id',
        'weight',
        'height',
        'age',
        'sex',
        'bmi',
        'weight_status',
        'weight_for_age_status',
        'height_for_age_status',
        'weight_for_height_status',
        'date',
    ];
}
