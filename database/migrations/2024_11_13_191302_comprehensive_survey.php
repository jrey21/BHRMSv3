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
        Schema::create('comprehensive_surveys', function (Blueprint $table) {
            $table->id();
            $table->string('household_number')->nullable();
            $table->string('family_number');
            $table->enum('zone',['','Zone 1','Zone 2','Zone 3', 'Zone 4', 'Zone 5', 'Zone 6','Zone 7'])->nullable();
            $table->string('last_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->enum('suffix', ['None', 'Jr.', 'Sr.', 'II', 'III', 'IV'])->nullable();
            $table->tinyInteger('age')->nullable();
            $table->enum('age_unit', ['years', 'months'])->default('years');
            $table->enum('sex', ['Male', 'Female'])->nullable();
            $table->enum('civil_status', ['Single', 'Married', 'Widowed', 'Separated'])->nullable();
            $table->date('birth_date')->nullable();
            $table->enum('education', ['none', 'Elementary', 'Highschool', 'College', 'Postgraduate'])->nullable();
            $table->string('religion')->nullable();
            $table->string('occupation')->nullable();
            $table->enum('sanitary_access', ['Owned', 'Shared', 'None'])->nullable();
            $table->enum('water_source', ['Level 1', 'Level 2', 'Level 3'])->nullable();
            $table->string('family_planning')->nullable();
            $table->boolean('lgbt')->nullable();
            $table->boolean('pwd')->nullable();
            $table->boolean('four_ps')->nullable();
            $table->boolean('non_hts')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comprehensive_surveys');
    }
};
