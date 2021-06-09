<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AppGroupEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $ad_group_id;
    public string $app_id; //此app_id是小程序表的主键 用于查询当前的小程序广告信息
    public int $type;   //操作类型 1新增操作 2修改操作 3删除操作

    public function __construct(int $type, string $app_id, string $ad_group_id)
    {
        $this->ad_group_id = $ad_group_id;
        $this->app_id = $app_id;
        $this->type = $type;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('update-app-adv');
    }
}
