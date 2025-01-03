<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevelopmentalScreening extends Model
{
    use HasFactory;

    protected $table = 'developmental_screenings';

    protected $fillable = [
        'child_id',
        'date',
        'age',
        'age_unit',
        'milestones_achieved',
        'developmental_concerns',
    ];
}
