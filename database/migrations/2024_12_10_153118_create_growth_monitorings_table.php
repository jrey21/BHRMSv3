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
        Schema::create('growth_monitorings', function (Blueprint $table) {
            $table->id()->primary();
            $table->unsignedBigInteger('child_id');
            $table->foreign('child_id')->references('id')->on('child_care_forms')->onDelete('cascade');
            $table->float('weight');
            $table->float('height');
            $table->float('bmi');
            $table->integer('age');
            $table->enum('sex', ['male','female'])->nullable();
            $table->string('weight_status');
            $table->string('weight_for_age_status');
            $table->string('height_for_age_status')->nullable();
            $table->string('weight_for_height_status')->nullable();
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('growth_monitorings');
    }
};
