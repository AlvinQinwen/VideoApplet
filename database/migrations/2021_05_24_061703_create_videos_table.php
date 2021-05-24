<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('视频标题');
            $table->string('cover_url', 500)->comment('视频封面');
            $table->string('video_url', 500)->comment('视频播放地址');
            $table->string('share_cover', 500)->comment('分享封面');
            $table->integer('sort')->default(0)->index()->comment('权重');
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
        Schema::dropIfExists('videos');
    }
}
