<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributedMedicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_id', 
        'beneficiary_name', 
        'medicine_name', 
        'distributed_quantity', 
        'distribution_date'
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}