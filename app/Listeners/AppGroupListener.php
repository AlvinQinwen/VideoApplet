<?php

namespace App\Listeners;

use App\Events\AppGroupEvent;
use App\Models\AdGroup;
use App\Models\Advertising;
use App\Models\Applet;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AppGroupListener
{
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
     * @param  AppGroupEvent  $event
     * @return void
     */
    public function handle(AppGroupEvent $event)
    {

        switch ($event->type) {
            case 1:
                //首先分割appids 拿到需要操作的公众号
                $appArr = explode(',', $event->app_id);
                foreach ($appArr as $appId) {

                    //一个小程序组 只能绑定一个广告组
                    $adIds = explode(',', AdGroup::where('id', $event->ad_group_id)->select('ad_ids')->value('ad_ids'));


                    //比对当前小程序的广告ids
                    $selfIdsStr = Applet::where('id', $appId)->select('advertising_ids')->value('advertising_ids');
                    $selfIdsArr = explode(',', $selfIdsStr);
                    //进行拍重 重复的进行unset操作
                    $newIdsArr = array_unique(array_merge($adIds, $selfIdsArr));
                    //然后更新该小程序的广告ids
                    Applet::where('id', $appId)->update([
                        'advertising_ids' => implode(',', $newIdsArr)
                    ]);
                }
                break;
            case 2:
                //修改操作 是否修改该数字 进而判断是否需要更新小程序的广告ids
                break;

            case 3:
                //删除操作 需要删除掉那些广告ids
//                $appArr = explode(',', $event->app_id);
//                foreach ($appArr as $appId) {
//                    //
//                }
                break;
        }


    }
}
