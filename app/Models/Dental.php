<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dental extends Model
{
    use HasFactory;

    protected $table = 'dental';

    protected $fillable = [
        'date',
        'dentist',
        'findings',
        'treatment',
    ];
}
