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
        Schema::create('scanned_codes', function (Blueprint $table) {
            $table->id()->primary();
            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')->references('id')->on('senior_events')->onDelete('cascade'); 
            // $table->json('scanned_codes');
            $table->string('scanned_codes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scanned_codes');
    }
};
