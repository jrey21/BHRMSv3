<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Inertia\Inertia;

class PNEAEnrollment extends Model
{
    use HasFactory;

    protected $table = 'pnea_enrollment';

    protected $fillable = [
        'pinkCardNumber',
        'date',
        'zone',
        'fullName',
        'birth_date',
        'age',
        'education',
        'occupation',
        'term_of_pregnancy',
        'number_of_pregnancy',
        'date_last_delivery',
        'number_of_children',
        'interval_of_delivery',
        'muac',
        'height',
        'weight',
        'bmi',
        'ns',
        'name_of_husband',
        'husband_age',
        'husband_education',
        'husband_occupation',
        'monthly_family_income',
        'household_size',
        
        //Row 1
        'prenatal_care_counseled',
        'prenatal_care_date_counseled',
        'prenatal_care_practiced',

        //Row 2
        'prenatal_checkup_counseled',
        'prenatal_checkup_date_counseled',
        'prenatal_care_date_1',
        'prenatal_care_date_2',
        'prenatal_care_date_3',
        'prenatal_care_date_4',
        'prenatal_care_date_5',
        'prenatal_care_date_6',
        'prenatal_care_date_7',
        'prenatal_care_date_8',
        'prenatal_care_date_9',

        //Row 3
        'iron_folic_acid_counseled',
        'iron_folic_acid_date_counseled',
        'iron_folic_acid_date_1',
        'iron_folic_acid_date_2',
        'iron_folic_acid_date_3',
        'iron_folic_acid_date_4',
        'iron_folic_acid_date_5',
        'iron_folic_acid_date_6',
        'iron_folic_acid_date_7',
        'iron_folic_acid_date_8',
        'iron_folic_acid_date_9',

        //Row 4
        'iodized_salt_counseled',
        'iodized_salt_date_counseled',
        'iodized_salt_practiced',

        //Row 5
        'tetanus_counseled',
        'tetanus_date_counseled',
        'dose_date_1',
        'dose_date_2',
        'dose_date_3',
        'dose_date_4',
        'dose_date_5',

        //Row 6
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

        //Row 7
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

        //Row 8
        'postnatal_checkup_counseled',
        'postnatal_checkup_date_counseled',
        'postnatal_last_checkup_date_practiced',

        //Row 9
        'iron_supplementation_counseled',
        'iron_supplementation_date_counseled',
        'iron_supplementation_last_date_taken_practiced',
        'iron_supplementation_amount_practiced',

        //Row 10
        'breastfeeding_initiation_counseled',
        'breastfeeding_initiation_date_counseled',
        'normal_delivery',
        'cs_delivery',

        //Row 11
        'given_colostrums',
        'no_water_given',
        'no_food_given',
        'no_vitamins_given',
        'no_formula_milk_given',
        'no_other_liquid_given',

        'exclusive_breastfeed_colostrums_1',
        'exclusive_breastfeed_colostrums_2',
        'exclusive_breastfeed_colostrums_3',
        'exclusive_breastfeed_colostrums_4',
        'exclusive_breastfeed_colostrums_5',
        'exclusive_breastfeed_colostrums_6',
        'exclusive_breastfeed_water_1',
        'exclusive_breastfeed_water_2',
        'exclusive_breastfeed_water_3',
        'exclusive_breastfeed_water_4',
        'exclusive_breastfeed_water_5',
        'exclusive_breastfeed_water_6',
        'exclusive_breastfeed_food_1',
        'exclusive_breastfeed_food_2',
        'exclusive_breastfeed_food_3',
        'exclusive_breastfeed_food_4',
        'exclusive_breastfeed_food_5',
        'exclusive_breastfeed_food_6',
        'exclusive_breastfeed_vitamins_1',
        'exclusive_breastfeed_vitamins_2',
        'exclusive_breastfeed_vitamins_3',
        'exclusive_breastfeed_vitamins_4',
        'exclusive_breastfeed_vitamins_5',
        'exclusive_breastfeed_vitamins_6',
        'exclusive_breastfeed_formula_milk_1',
        'exclusive_breastfeed_formula_milk_2',
        'exclusive_breastfeed_formula_milk_3',
        'exclusive_breastfeed_formula_milk_4',
        'exclusive_breastfeed_formula_milk_5',
        'exclusive_breastfeed_formula_milk_6',
        'exclusive_breastfeed_other_liquid_1',
        'exclusive_breastfeed_other_liquid_2',
        'exclusive_breastfeed_other_liquid_3',
        'exclusive_breastfeed_other_liquid_4',
        'exclusive_breastfeed_other_liquid_5',
        'exclusive_breastfeed_other_liquid_6',

        //Row 12
        'child_sick_counseled',
        'mother_sick_counseled',
        'child_sick_practiced',
        'mother_sick_practiced',

        //Row 13
        'continue_breastfeed_beyond_2_counseled',
        'continue_breastfeed_beyond_2_practiced',

        //Row 14
        'backyard_gardening_counseled',
        'backyard_gardening_practiced',
        'clean_environment_counseled',
        'clean_environment_practiced',
        'sanitary_counseled',
        'sanitary_practiced',
        'potable_water_counseled',
        'potable_water_practiced',
        

    ];
    public function pneaEnrollment()
    {
        return $this->hasMany(PNEAEnrollment::class, 'id');
    }

    public function pregnancyPeriods()
    {
        return $this->hasMany(PregnancyPeriod::class, 'pnea_id');
    }

    public function lactatingPeriods()
    {
        return $this->hasMany(LactatingPeriod::class, 'pnea_id');
    }
}
