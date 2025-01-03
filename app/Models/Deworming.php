<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deworming extends Model
{
    use HasFactory;

    protected $table = 'deworming';
    
    protected $fillable = [
        'date',
        'age',
        'age_unit',
        'deworming_medicine',
        'other_deworming_medicine',
        'administered_by',
    ];

    public function child()
    {
        return $this->belongsTo(ChildCareForm::class, 'child_id');
    }
}
