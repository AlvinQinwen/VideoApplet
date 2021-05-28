<?php

namespace App\Console\Commands;

use App\Models\Video;
use Illuminate\Console\Command;
use Predis\Client;

class CacheVideoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:video';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '每三小时刷新redis缓存';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $redis = new Client(['database' => 3]);
        $videos = Video::get()->toArray();
        foreach ($videos as $video) {
            $key = "video-".$video['id'];
            $redis->set($key, json_encode($video));
        }

        return 0;
    }
}
