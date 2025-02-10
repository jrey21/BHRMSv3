<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Inertia\Inertia;

class SeniorEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'date',
        'location'
    ];

    public function seniorEvent()
    {
        return $this->hasMany(SeniorEvent::class, 'id');
    }

    public function scannedCodes()
    {
        return $this->hasMany(ScannedCode::class, 'event_id');
    }
}
