<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Inertia\Inertia;

class QRScan extends Model
{
    use HasFactory;

    protected $fillable = [
        'senior_id',
        'event_id',
        'scanned',
        'scanned_at'
    ];

    public function seniorCitizen()
    {
        return $this->belongsTo(ComprehensiveSurvey::class, 'id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'id');
    }
    
}
