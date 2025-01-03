<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('vitamin_a_supplementations', function (Blueprint $table) {
            $table->id()->primary();
            $table->unsignedBigInteger('child_id');
            $table->foreign('child_id')->references('id')->on('child_care_forms')->onDelete('cascade');
            $table->tinyInteger('age');
            $table->enum('age_unit', ['years', 'months'])->default('years');
            $table->string('dose');
            $table->date('date');
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
          Schema::dropIfExists('vitamin_a_supplementations');
    }
};
