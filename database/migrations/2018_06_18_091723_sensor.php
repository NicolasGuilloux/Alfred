<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Sensor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sensors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('type')->comment('0: Electricity, 1: Waste, 2: Water');
            $table->unsignedInteger('parent_id')->nullable();
            $table->string('place')->nullable();
            $table->timestamps();
        });

        Schema::table('sensors', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('sensors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sensors');
    }
}
