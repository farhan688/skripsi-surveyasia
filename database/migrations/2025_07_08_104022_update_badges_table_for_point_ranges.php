<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBadgesTableForPointRanges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('badges', function (Blueprint $table) {
            $table->renameColumn('threshold_points', 'min_threshold_points');
        });
        Schema::table('badges', function (Blueprint $table) {
            $table->integer('max_threshold_points')->after('min_threshold_points');
        });
    }

    public function down()
    {
        Schema::table('badges', function (Blueprint $table) {
            $table->renameColumn('min_threshold_points', 'threshold_points');
            $table->dropColumn('max_threshold_points');
        });
    }
}
