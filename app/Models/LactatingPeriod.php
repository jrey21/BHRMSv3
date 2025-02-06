<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LactatingPeriod extends Model
{
    use HasFactory;

    protected $table = 'lactating_periods';

    protected $fillable = [
        'pnea_id',
        'month',
        'weight',
        'height',
        'bmi',
        'status',
        'muac',
        'muac_color',
        'muac_status',
        'date'
    ];

    public function pnea()
    {
        return $this->belongsTo(PNEAEnrollment::class, 'pnea_id');
    }
}
