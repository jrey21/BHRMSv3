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
        Schema::create('vaccination_records', function (Blueprint $table) {
            $table->id()->primary();
            $table->unsignedBigInteger('child_id');
            $table->foreign('child_id')->references('id')->on('child_care_forms')->onDelete('cascade');
            $table->string('vaccine_name');
            $table->string('other_vaccine_name')->nullable();
            $table->string('dose_number');
            $table->date('date');
            $table->string('status')->nullable();
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->useCurrent();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccination_records');
    }
};
