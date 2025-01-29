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
        Schema::create('deworming', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('child_id');
            $table->foreign('child_id')->references('id')->on('child_care_forms')->onDelete('cascade');
            $table->date('date');
            $table->integer('age');
            $table->string('age_unit');
            $table->enum('deworming_medicine', ['Albendazole', 'Mebendazole', 'Pyrantel Pamoate', 'Others']);
            $table->string('other_deworming_medicine')->nullable();
            $table->string('administered_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deworming');
    }
};
