<?php

namespace App\Console\Commands;

use App\Models\Path;
use App\Models\Video;
use Illuminate\Console\Command;
use Predis\Client;

class CachePathCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:path';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '每三小时刷新path redis缓存';

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
        $redis = new Client(['database' => 1]);
        $paths = Path::get();
        foreach ($paths as $path) {
            $key = $path->id;
            $redis->set($key, json_encode($path));
        }
        return 0;
    }
}
