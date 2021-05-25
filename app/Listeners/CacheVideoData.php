<?php

namespace App\Listeners;

use App\Events\RedisCacheDataEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Predis\Client;

class CacheVideoData implements ShouldQueue
{
    use InteractsWithQueue;

    private Client $redis;
    public function __construct()
    {
        $config = [
            'host' => '127.0.0.1',
            'database' => 0
        ];
        $this->redis = new Client($config);
    }

    /**
     * Handle the event.
     *
     * @param  RedisCacheDataEvent  $event
     * @return void
     */
    public function handle(RedisCacheDataEvent $event)
    {
        switch ($event->type) {
            //新增
            case 1:
                $this->createCache($event->data);
                break;
            case 2:
                $this->deleteCache($event->data);
                break;
            case 3:
                $this->updateCache($event->data);
                break;
        }
    }

    private function createCache($data)
    {
        $this->redis->set('video-'.$data['id'], json_encode($data));
    }

    private function deleteCache($data)
    {
        $this->redis->del('video-'.$data['id']);
    }

    private function updateCache($data)
    {
        $this->redis->set('video-'.$data['id'], json_encode($data));
    }
}
