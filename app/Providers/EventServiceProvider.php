<?php

namespace App\Providers;

use App\Events\PathCacheEvent;
use App\Events\RedisCacheDataEvent;
use App\Listeners\CachePathData;
use App\Listeners\CacheVideoData;
use App\Listeners\RedisCacheDataListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        //缓存视频
        RedisCacheDataEvent::class => [CacheVideoData::class],

        //缓存path
        PathCacheEvent::class => [CachePathData::class]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
