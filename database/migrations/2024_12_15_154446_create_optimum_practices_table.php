<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptimumPracticesTable extends Migration
{
    public function up()
    {
        Schema::create('optimum_practices', function (Blueprint $table) {
            $table->id()->primary();
            $table->unsignedBigInteger('pnea_id');
            $table->foreign('pnea_id')->references('id')->on('pnea_enrollment')->onDelete('cascade');

            //Row 1
            $table->boolean('prenatal_care_counseled')->default(false)->nullable();
            $table->date('prenatal_care_date_counseled')->nullable();
            $table->enum('prenatal_care_practiced',['Rural Health Unit','Private Hospital/Clinic'])->nullable();

            //Row 2
            $table->boolean('prenatal_checkup_counseled')->default(false)->nullable();
            $table->date('prenatal_checkup_date_counseled')->nullable();
            $table->date(' prenatal_care_date_1')->nullable();
            $table->date(' prenatal_care_date_2')->nullable();
            $table->date(' prenatal_care_date_3')->nullable();
            $table->date(' prenatal_care_date_4')->nullable();
            $table->date(' prenatal_care_date_5')->nullable();
            $table->date(' prenatal_care_date_6')->nullable();
            $table->date(' prenatal_care_date_7')->nullable();
            $table->date(' prenatal_care_date_8')->nullable();
            $table->date(' prenatal_care_date_9')->nullable();

            //Row 3
            $table->boolean('iron_folic_acid_counseled')->default(false)->nullable();
            $table->date('iron_folic_acid_date_counseled')->nullable();
            $table->date('iron_folic_acid_date_1')->nullable();
            $table->date('iron_folic_acid_date_2')->nullable();
            $table->date('iron_folic_acid_date_3')->nullable();
            $table->date('iron_folic_acid_date_4')->nullable();
            $table->date('iron_folic_acid_date_5')->nullable();
            $table->date('iron_folic_acid_date_6')->nullable();
            $table->date('iron_folic_acid_date_7')->nullable();
            $table->date('iron_folic_acid_date_8')->nullable();
            $table->date('iron_folic_acid_date_9')->nullable();

            //Row 4
            $table->boolean('iodized_salt_counseled')->default(false)->nullable();
            $table->date('iodized_salt_date_counseled')->nullable();
            $table->date('iodized_salt_practiced')->nullable();

            //Row 5
            $table->boolean('tetanus_counseled')->default(false)->nullable();
            $table->date('tetanus_date_counseled')->nullable();
           
            $table->date('dose_date_1')->nullable();
            $table->date('dose_date_2')->nullable();
            $table->date('dose_date_3')->nullable();
            $table->date('dose_date_4')->nullable();
            $table->date('dose_date_5')->nullable();

            //Row 6
            $table->tinyInteger('initiation')->default(0)->nullable();
            $table->tinyInteger('exclusivity')->default(0)->nullable();
            $table->tinyInteger('duration')->default(0)->nullable();
            $table->tinyInteger('dietary_intake')->default(0)->nullable();
            $table->tinyInteger('personal_willingness')->default(0)->nullable();
            $table->tinyInteger('family_support')->default(0)->nullable();
            $table->boolean('initiation_counseled')->default(false)->nullable();
            $table->boolean('exclusivity_counseled')->default(false)->nullable();
            $table->boolean('duration_counseled')->default(false)->nullable();
            $table->boolean('dietary_intake_counseled')->default(false)->nullable();
            $table->boolean('personal_willingness_counseled')->default(false)->nullable();
            $table->boolean('family_support_counseled')->default(false)->nullable();
            $table->date('initiation_start_date_practiced')->nullable();
            $table->date('initiation_end_date_practiced')->nullable();
            $table->date('exclusivity_start_date_practiced')->nullable();
            $table->date('exclusivity_end_date_practiced')->nullable();
            $table->date('duration_start_date_practiced')->nullable();
            $table->date('duration_end_date_practiced')->nullable();

            $table->tinyInteger('proper_infant')->default(0)->nullable();
            $table->tinyInteger('nutripak')->default(0)->nullable();
            $table->tinyInteger('health_nutrition')->default(0)->nullable();
            $table->tinyInteger('membership')->default(0)->nullable();
            $table->tinyInteger('plant_malunggay')->default(0)->nullable();
            $table->string('other_interventions')->nullable();
            
            $table->boolean('proper_infant_counseled')->default(false)->nullable();
            $table->boolean('nutripak_counseled')->default(false)->nullable();
            $table->boolean('health_nutrition_counseled')->default(false)->nullable();
            $table->boolean('membership_counseled')->default(false)->nullable();
            $table->boolean('plant_malunggay_counseled')->default(false)->nullable();
            $table->boolean('other_interventions_counseled')->default(false)->nullable();
            $table->boolean('proper_infant_practiced')->default(false)->nullable();
            $table->integer('nutripak_practiced')->nullable();
            $table->boolean('health_nutrition_practiced')->nullable();
            $table->boolean('membership_member_practiced')->nullable();
            $table->boolean('membership_leader_practiced')->nullable();
            $table->integer('plant_malunggay_number_practiced')->nullable();
            $table->date('date_planted_practiced')->nullable();
            $table->string('location_practiced')->nullable();
            $table->boolean('other_interventions_practiced')->nullable();
            $table->boolean('postnatal_checkup_counseled')->default(false)->nullable();
            $table->date('postnatal_checkup_date_counseled')->nullable();
            $table->date('postnatal_last_checkup_date_practiced')->nullable();
            $table->boolean('iron_supplementation_counseled')->default(false)->nullable();
            $table->date('iron_supplementation_date_counseled')->nullable();
            $table->date('iron_supplementation_last_date_taken_practiced')->nullable();
            $table->integer('iron_supplementation_amount_practiced')->nullable();
            $table->boolean('breastfeeding_initiation_counseled')->default(false)->nullable();
            $table->date('breastfeeding_initiation_date_counseled')->nullable();
            $table->tinyInteger('normal_delivery')->default(0)->nullable();
            $table->tinyInteger('cs_delivery')->default(0)->nullable();

            // Exclusive Breastfeeding Fields
            $table->boolean('given_colostrums')->default(false)->nullable();
            $table->boolean('no_water_given')->default(false)->nullable();
            $table->boolean('no_food_given')->default(false)->nullable();
            $table->boolean('no_vitamins_given')->default(false)->nullable();
            $table->boolean('no_formula_milk_given')->default(false)->nullable();
            $table->boolean('no_other_liquid_given')->default(false)->nullable();

            // Dropdown for multiple instances (1st to 6th)
            $table->enum('exclusive_breastfeeding_colostrums_1',['Yes','No'])->nullable();
            $table->enum('exclusive_breastfeeding_colostrums_2',['Yes','No'])->nullable();
            $table->enum('exclusive_breastfeeding_colostrums_3',['Yes','No'])->nullable();
            $table->enum('exclusive_breastfeeding_colostrums_4',['Yes','No'])->nullable();
            $table->enum('exclusive_breastfeeding_colostrums_5',['Yes','No'])->nullable();
            $table->enum('exclusive_breastfeeding_colostrums_6',['Yes','No'])->nullable();

            $table->enum('exclusive_breastfeeding_water_1',['Yes','No'])->nullable();
            $table->enum('exclusive_breastfeeding_water_2',['Yes','No'])->nullable();
            $table->enum('exclusive_breastfeeding_water_3',['Yes','No'])->nullable();
            $table->enum('exclusive_breastfeeding_water_4',['Yes','No'])->nullable();
            $table->enum('exclusive_breastfeeding_water_5',['Yes','No'])->nullable();
            $table->enum('exclusive_breastfeeding_water_6',['Yes','No'])->nullable();

            $table->enum('exclusive_breastfeeding_food_1',['Yes','No'])->nullable();
            $table->enum('exclusive_breastfeeding_food_2',['Yes','No'])->nullable();
            $table->enum('exclusive_breastfeeding_food_3',['Yes','No'])->nullable();
            $table->enum('exclusive_breastfeeding_food_4',['Yes','No'])->nullable();
            $table->enum('exclusive_breastfeeding_food_5',['Yes','No'])->nullable();
            $table->enum('exclusive_breastfeeding_food_6',['Yes','No'])->nullable();

            $table->enum('exclusive_breastfeeding_vitamins_1',['Yes','No'])->nullable();
            $table->enum('exclusive_breastfeeding_vitamins_2',['Yes','No'])->nullable();
            $table->enum('exclusive_breastfeeding_vitamins_3',['Yes','No'])->nullable();
            $table->enum('exclusive_breastfeeding_vitamins_4',['Yes','No'])->nullable();
            $table->enum('exclusive_breastfeeding_vitamins_5',['Yes','No'])->nullable();
            $table->enum('exclusive_breastfeeding_vitamins_6',['Yes','No'])->nullable();

            $table->enum('exclusive_breastfeeding_formula_milk_1',['Yes','No'])->nullable();
            $table->enum('exclusive_breastfeeding_formula_milk_2',['Yes','No'])->nullable();
            $table->enum('exclusive_breastfeeding_formula_milk_3',['Yes','No'])->nullable();
            $table->enum('exclusive_breastfeeding_formula_milk_4',['Yes','No'])->nullable();
            $table->enum('exclusive_breastfeeding_formula_milk_5',['Yes','No'])->nullable();
            $table->enum('exclusive_breastfeeding_formula_milk_6',['Yes','No'])->nullable();

            $table->enum('exclusive_breastfeeding_other_liquid_1',['Yes','No'])->nullable();
            $table->enum('exclusive_breastfeeding_other_liquid_2',['Yes','No'])->nullable();
            $table->enum('exclusive_breastfeeding_other_liquid_3',['Yes','No'])->nullable();
            $table->enum('exclusive_breastfeeding_other_liquid_4',['Yes','No'])->nullable();
            $table->enum('exclusive_breastfeeding_other_liquid_5',['Yes','No'])->nullable();
            $table->enum('exclusive_breastfeeding_other_liquid_6',['Yes','No'])->nullable();
            

            //Continue breastfeeding
            $table->boolean('child_sick_counseled')->default(false)->nullable();
            $table->boolean('mother_sick_counseled')->default(false)->nullable();
            $table->boolean('child_sick_practiced')->default(false)->nullable();
            $table->boolean('mother_sick_practiced')->default(false)->nullable();

            //Continue breastfeeding beyond 2 years
            $table->boolean('continue_breastfeed_beyond_2_counseled')->default(false)->nullable();
            $table->boolean('continue_breastfeed_beyond_2_practiced')->default(false)->nullable();

            //Health Sanitation/Food Availability
            $table->boolean('backyard_gardening_counseled')->default(false)->nullable();
            $table->boolean('backyard_gardening_practiced')->default(false)->nullable();
            $table->boolean('clean_environment_counseled')->default(false)->nullable();
            $table->boolean('clean_environment_practiced')->default(false)->nullable();
            $table->boolean('sanitary_counseled')->default(false)->nullable();
            $table->boolean('sanitary_practiced')->default(false)->nullable();
            $table->boolean('potable_water_counseled')->default(false)->nullable();
            $table->boolean('potable_water_practiced')->default(false)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('optimum_practices');
    }
}
