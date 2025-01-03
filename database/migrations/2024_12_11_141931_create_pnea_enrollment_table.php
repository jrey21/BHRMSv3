<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pnea_enrollment', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('pinkCardNumber');
            $table->date('date');
            $table->string('zone');
            $table->string('fullName');
            $table->date('birth_date');
            $table->integer('age');
            $table->enum('education',['None','Elementary','Highschool','College','Postgraduate']);
            $table->string('occupation');
            $table->string('term_of_pregnancy');
            $table->integer('number_of_pregnancy');
            $table->date('date_last_delivery');
            $table->integer('number_of_children');
            $table->string('interval_of_delivery');
            $table->double('muac');
            $table->double('height');
            $table->double('weight');
            $table->double('bmi');
            $table->string('ns');
            $table->string('name_of_husband');
            $table->integer('husband_age');
            $table->enum('husband_education',['None','Elementary','Highschool','College','Postgraduate']);
            $table->string('husband_occupation');
            $table->string('monthly_family_income');
            $table->integer('household_size');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pnea_enrollment');
    }
};
