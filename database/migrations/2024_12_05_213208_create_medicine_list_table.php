<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicineListTable extends Migration
{
    public function up()
    {
        Schema::create('medicine_lists', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('name');
            $table->string('type');
            $table->integer('quantity');
            $table->string('measurement');
            $table->date('expiry_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('medicine_lists');
    }
}
