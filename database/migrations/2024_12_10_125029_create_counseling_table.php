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
        Schema::create('counseling', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('child_id');
            $table->foreign('child_id')->references('id')->on('child_care_forms')->onDelete('cascade');
            $table->enum ('breastfeeding_status', ['exclusive', 'mixed', 'formula', 'weaned','none'])->default('exclusive');
            $table->string('duration');
            $table->tinyInteger('feeding_start_age');
            $table->enum('feeding_start_age_unit',['years', 'months'])->default('years');
            $table->string('frequency_of_feeding');
            $table->string('types_of_food');
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counseling');
    }
};
