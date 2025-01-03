<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildCareForm extends Model
{
    use HasFactory;

    protected $table = 'child_care_forms';

    protected $fillable = [
        'family_no',
        'child_no',
        'zone',
        'complete_address',
        'last_name',
        'first_name',
        'middle_name',
        'suffix',
        'mother_name',
        'mother_education',
        'mother_occupation',
        'no_pregancies',
        'father_name',
        'father_education',
        'father_occupation',
        'birth_date',
        'gestational_age',
        'type_of_birth',
        'birth_order',
        'birth_weight',
        'birth_length',
        'birth_place',
        'other_birth_place',
        'birth_registered',
        'birth_attendant',
        'other_birth_attendant',
    ];

    public function vaccinationRecords()
    {
        return $this->hasMany(VaccinationRecord::class, 'child_id');
    }

    public function vitaminASupplementation()
    {
        return $this->hasMany(VitaminASupplementation::class, 'child_id');
    }

    public function counseling()
    {
        return $this->hasMany(Counseling::class, 'child_id');
    }

    public function growthMonitorings()
    {
        return $this->hasMany(GrowthMonitoring::class, 'child_id');
    }

    public function developmentalScreening()
    {
        return $this->hasMany(DevelopmentalScreening::class, 'child_id');
    }

    public function deworming()
    {
        return $this->hasMany(Deworming::class, 'child_id');
    }

    public function dental()
    {
        return $this->hasMany(Dental::class, 'child_id');
    }
}