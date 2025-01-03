<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VitaminASupplementation extends Model
{
    use HasFactory;

    protected $table = 'vitamin_a_supplementations';

    protected $fillable = [
        'child_id',
        'age',
        'age_unit',
        'dose',
        'date',
    ];

    public function child()
    {
        return $this->belongsTo(ChildCareForm::class, 'child_id');
    }
}
