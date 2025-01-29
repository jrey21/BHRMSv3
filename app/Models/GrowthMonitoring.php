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
        'weight_age_status',
        'height_age_status',
        'weight_height_status',
        'date',
    ];
}
