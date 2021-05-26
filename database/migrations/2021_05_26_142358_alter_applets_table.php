<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAppletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applets', function (Blueprint $table) {
            $table->string('interstitia_unitId')->default('')->comment('插屏广告单元')->after('mark');
            $table->smallInteger('screen_open')->default(1)->comment('是否开启插屏1开启，2关闭')->after('interstitia_unitId');
            $table->string('rewarded_unitId')->default('')->comment('激励广告单元')->after('screen_open');
            $table->smallInteger('excitation_open')->default(1)->comment('是否开启激励1开启，2关闭')->after('rewarded_unitId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applets', function (Blueprint $table) {
            //
        });
    }
}
