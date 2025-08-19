<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAvailablePointsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->integer('available_points')->default(0);
            $table->integer('reward_balance')->default(0);
        });
    }
    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn(['available_points', 'reward_balance']);
        });
    }
}