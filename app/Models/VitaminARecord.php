
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VitaminARecord extends Model
{
    use HasFactory;

    protected $fillable = ['age', 'dose', 'date', 'child_id'];

    // Define the relationship with Child
    public function child()
    {
        return $this->belongsTo(Child::class);
    }
}