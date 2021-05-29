<?php

namespace App\Listeners;

use App\Events\PathCacheEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Predis\Client;

class CachePathData
{
    private Client $redis;

    public function __construct()
    {
        $config = [
            'database' => 1
        ];
        $this->redis = new Client($config);
    }

    /**
     * Handle the event.
     *
     * @param  PathCacheEvent  $event
     * @return void
     */
    public function handle(PathCacheEvent $event)
    {
        switch ($event->type) {
            case 1:
                $this->createPathCache($event->data);
                break;
            case 2:
                $this->deletePathCache($event->data);
                break;
        }
    }

    private function createPathCache(array $data)
    {
        $this->redis->set($data['id'], json_encode($data));
    }

    private function deletePathCache(array $data)
    {
        $this->redis->del($data['id']);
    }
}
