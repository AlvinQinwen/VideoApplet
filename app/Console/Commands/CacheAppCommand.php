<?php

namespace App\Console\Commands;

use App\Models\Applet;
use Illuminate\Console\Command;
use Predis\Client;

class CacheAppCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:app';

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
        $redis = new Client(['database' => 2]);
        $apps = Applet::get();
        foreach ($apps as $app) {
            $key = $app->app_id;
            $redis->set($key, json_encode($app));
        }
        return 0;
    }
}
