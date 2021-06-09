<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_groups', function (Blueprint $table) {
            $table->id();
            $table->string('app_group_name')->index()->comment('小程序组名');
            $table->string('app_ids')->index()->default('')->comment('小程序表的主键ids');
            $table->integer("ad_group_id")->index()->comment('广告组表的id');
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
        Schema::dropIfExists('app_groups');
    }
}
