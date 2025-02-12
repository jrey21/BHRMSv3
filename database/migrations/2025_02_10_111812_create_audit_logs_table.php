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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable(); // Store user ID if available
            $table->string('action'); // Action performed
            $table->string('table_name')->nullable(); // Affected table
            $table->text('old_data')->nullable(); // Old data before update
            $table->text('new_data')->nullable(); // New data after update
            $table->ipAddress('ip_address')->nullable(); // IP address of user
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
