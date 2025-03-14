<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Inertia\Inertia;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'date'
    ];
}