<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applets', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('小程序名称');
            $table->string('app_id')->index()->comment('appid');
            $table->string('secret')->comment('secret');
            $table->smallInteger('debug')->default(2)->comment('是否开启debug骗审 1正常 2开启 默认开启2');
            $table->string('advertising_ids', 500)->default('')->comment('广告ids');
            $table->string('mark')->default('')->comment('备用字段');
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
        Schema::dropIfExists('applets');
    }
}
