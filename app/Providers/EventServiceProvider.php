<?php

namespace App\Providers;

use App\Events\AppGroupEvent;
use App\Events\PathCacheEvent;
use App\Events\RedisCacheDataEvent;
use App\Listeners\AppGroupListener;
use App\Listeners\CachePathData;
use App\Listeners\CacheVideoData;
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
        PathCacheEvent::class => [CachePathData::class],

        //更新修改删除新增 小程序组时 进行对应的操作
        AppGroupEvent::class => [AppGroupListener::class]
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
