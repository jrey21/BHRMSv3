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
        Schema::create('qr_scan_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('senior_id');
            $table->foreign('senior_id')->references('id')->on('comprehensive_surveys')->onDelete('cascade');
            $table->boolean('scanned')->default(false);
            $table->timestamp('scanned_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qr_scan_records');
    }
};
