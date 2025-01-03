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
        Schema::create('distributed_medicines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('medicine_id');
            $table->string('beneficiary_name');
            $table->string('medicine_name');
            $table->integer('distributed_quantity');
            $table->date('distribution_date');
            $table->timestamps();

            $table->foreign('medicine_id')->references('id')->on('medicine_lists')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::dropIfExists('distributed_medicines');
    }
};
