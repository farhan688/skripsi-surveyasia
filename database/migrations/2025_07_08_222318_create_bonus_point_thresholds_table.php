<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonus_point_thresholds', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('min_points');
            $table->integer('max_points')->nullable();
            $table->integer('bonus_amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bonus_point_thresholds');
    }
};