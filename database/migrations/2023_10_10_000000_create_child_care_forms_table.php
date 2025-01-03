<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChildCareFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('child_care_forms', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('family_no');
            $table->string('child_no');
            $table->enum('zone',['','Zone 1','Zone 2','Zone 3', 'Zone 4', 'Zone 5', 'Zone 6','Zone 7'])->nullable();
            $table->string('complete_address');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('suffix')->nullable();
            $table->string('mother_name');
            $table->string('mother_education');
            $table->string('mother_occupation');
            $table->integer('no_pregancies');
            $table->string('father_name');
            $table->string('father_education');
            $table->string('father_occupation');
            $table->date('birth_date');
            $table->string('gestational_age');
            $table->string('type_of_birth');
            $table->integer('birth_order');
            $table->float('birth_weight');
            $table->float('birth_length');
            $table->string('birth_place');
            $table->string('other_birth_place')->nullable();
            $table->date('birth_registered');
            $table->string('birth_attendant');
            $table->string('other_birth_attendant')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('child_care_forms');
    }
}