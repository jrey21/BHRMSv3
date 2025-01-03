<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineList extends Model
{
    use HasFactory;

    protected $table = 'medicine_lists';

    protected $fillable = [
        'name',
        'type',
        'quantity',
        'measurement',
        'expiry_date',
    ];
}
