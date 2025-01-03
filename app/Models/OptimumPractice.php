<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptimumPractice extends Model
{
    use HasFactory;

    protected $table = 'optimum_practices';

    protected $fillable = [
        'pnea_id',
        'prenatal_care_counseled',
        'prenatal_care_date_counseled',
        'prenatal_care_practiced',
        'prenatal_checkup_counseled',
        'prenatal_checkup_date_counseled',
        'prenatal_checkup_trimester_practiced',
        'prenatal_checkup_date_practiced',
        'iron_folic_acid_counseled',
        'iron_folic_acid_date_counseled',
        'iron_folic_acid_trimester_practiced',
        'iron_folic_acid_date_practiced',
        'iodized_salt_counseled',
        'iodized_salt_date_counseled',
        'iodized_salt_practiced',
        'tetanus_counseled',
        'tetanus_date_counseled',
        'tetanus_dose_practiced',
        'tetanus_date_practiced',
        'initiation',
        'exclusivity',
        'duration',
        'dietary_intake',
        'personal_willingness',
        'family_support',
        'initiation_counseled',
        'exclusivity_counseled',
        'duration_counseled',
        'dietary_intake_counseled',
        'personal_willingness_counseled',
        'family_support_counseled',
        'initiation_start_date_practiced',
        'initiation_end_date_practiced',
        'exclusivity_start_date_practiced',
        'exclusivity_end_date_practiced',
        'duration_start_date_practiced',
        'duration_end_date_practiced',
        'proper_infant',
        'nutripak',
        'health_nutrition',
        'membership',
        'plant_malunggay',
        'other_interventions',
        'proper_infant_counseled',
        'nutripak_counseled',
        'health_nutrition_counseled',
        'membership_counseled',
        'plant_malunggay_counseled',
        'other_interventions_counseled',
        'proper_infant_practiced',
        'nutripak_practiced',
        'health_nutrition_practiced',
        'membership_member_practiced',
        'membership_leader_practiced',
        'plant_malunggay_number_practiced',
        'date_planted_practiced',
        'location_practiced',
        'other_interventions_practiced',
        'postnatal_checkup_counseled',
        'postnatal_checkup_date_counseled',
        'postnatal_last_checkup_date_practiced',
        'iron_supplementation_counseled',
        'iron_supplementation_date_counseled',
        'iron_supplementation_last_date_taken_practiced',
        'breastfeeding_initiation_counseled',
        'breastfeeding_initiation_date_counseled',
        'normal_delivery',
        'cs_delivery',
        'exclusive_breastfeeding_1',
        'exclusive_breastfeeding_2',
        'exclusive_breastfeeding_3',
        'exclusive_breastfeeding_4',
        'exclusive_breastfeeding_5',
        'exclusive_breastfeeding_6',
        'given_colostrums',
        'no_water_given',
        'no_food_given',
        'no_vitamins_given',
        'no_formula_milk_given',
        'no_other_liquid_given',
        'child_sick_counseled',
        'mother_sick_counseled',
        'child_sick_practiced',
        'mother_sick_practiced',
        'continue_breastfeed_beyond_2_counseled',
        'continue_breastfeed_beyond_2_practiced',
        'backyard_gardening_counseled',
        'backyard_gardening_practiced',
        'clean_environment_counseled',
        'clean_environment_practiced',
        'sanitary_counseled',
        'sanitary_practiced',
        'potable_water_counseled',
    ];

    public function pnea()
    {
        return $this->belongsTo(PNEAEnrollment::class, 'pnea_id');
    }

    public function pneaEnrollment()
    {
        return $this->belongsTo(PNEAEnrollment::class, 'pnea_id');
    }
}
