<?php

namespace App\Listeners;

use App\Events\RedisCacheDataEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CacheVideoData implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  RedisCacheDataEvent  $event
     * @return void
     */
    public function handle(RedisCacheDataEvent $event)
    {

    }
}
