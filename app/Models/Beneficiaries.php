<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiaries extends Model
{
    use HasFactory;

    protected $table = 'beneficiaries';

    protected $fillable = [
        'name',
        'zone',
    ];
}
