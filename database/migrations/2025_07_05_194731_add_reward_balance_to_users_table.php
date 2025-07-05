<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRewardBalanceToUsersTable extends Migration
{

    public function up()
    {
        Schema::table('users', function ($table) {
            $table->integer('reward_balance')->default(0)->after('available_points');
        });
    }

    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('reward_balance');
        });
    }
}