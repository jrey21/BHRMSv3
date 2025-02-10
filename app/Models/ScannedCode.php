<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScannedCode extends Model
{
    use HasFactory;

    protected $table = 'scanned_codes';

    protected $fillable = [
        'event_id',
        'scanned_codes'
       
    ];
    // protected $casts = [
    //     'scanned_codes' => 'array'
    // ];

    public function event()
    {
        return $this->belongsTo(SeniorEvent::class);
    }
    public function seniorCitizens()
    {
        return $this->belongsToMany(SeniorCitizen::class, 'scanned_data_senior_citizen', 'scanned_code_id', 'senior_id');
    }
}
?>
