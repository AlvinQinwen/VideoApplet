<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '测试';

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

        $adIds = [
            0 => "1",
            1 => "2",
            2 => "3",
            3 => "4",
            4 => "5"
        ];

        $selfIdsArr = [
            0 => "1",
            1 => "2",
            2 => "3"
        ];


        foreach ($adIds as $k => $adId) {
            foreach ($selfIdsArr as $selfAd) {
                if ($selfAd == $adId) {
                    unset($adIds[$k]);
                }
            }
        }

        dd(implode(",", $adIds));


        return 0;
    }
}
