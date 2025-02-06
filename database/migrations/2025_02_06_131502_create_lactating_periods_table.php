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
        Schema::create('lactating_periods', function (Blueprint $table) {
            $table->id()->primary();
            $table->unsignedBigInteger('pnea_id');
            $table->foreign('pnea_id')->references('id')->on('pnea_enrollment')->onDelete('cascade');
            $table->enum('month', ['1st Month', '2nd Month', '3rd Month', '4th Month', '5th Month', '6th Month']);
            $table->float('weight');
            $table->float('height');
            $table->string('bmi');
            $table->string('status');
            $table->float('muac');
            $table->string('muac_color');
            $table->string('muac_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lactating_periods');
    }
};
