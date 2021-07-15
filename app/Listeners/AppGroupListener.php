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
            //新增 / 修改操作，会进行重置
            case 1:
                //首先分割appids 拿到需要操作的公众号
                $appArr = explode(',', $event->app_id);
                foreach ($appArr as $appId) {
                    \Log::info("小程序appid {$appId}");

                    //一个小程序组 只能绑定一个广告组
                    $adIds = explode(',', AdGroup::where('id', $event->ad_group_id)->select('ad_ids')->value('ad_ids'));
                    \Log::info("广告ids", $adIds);

//                    //比对当前小程序的广告ids
//                    $selfIdsArr = explode(',', Applet::where('id', $appId)->select('advertising_ids')->value('advertising_ids'));

                    //进行排重 重复的进行unset操作
//                    $newIdsArr = array_unique(array_merge($adIds, $selfIdsArr));
                    //然后更新该小程序的广告ids
                    Applet::where('id', $appId)->update([
                        'advertising_ids' => implode(",", $adIds)
                    ]);
                }
                break;

            case 2:
                //删除操作 进行取消配对的操作
                $appArr = explode(',', $event->app_id);
                foreach ($appArr as $appId) {
                    //广告组的ids
                    $adIds = explode(',', AdGroup::where('id', $event->ad_group_id)->select('ad_ids')->value('ad_ids'));
                    //本身小程序的广告ids
                    $selfIdsStr = Applet::where('id', $appId)->select('advertising_ids')->value('advertising_ids');
                    $selfIdsArr = explode(',', $selfIdsStr);

                    //进行对比 将本身的广告ids 与 广告组的广告ids 进行对比 如果广告组的广告ids在 本身的广告ids中 进行unset操作
                    foreach ($selfIdsArr as $k => $selfAd) {
                        foreach ($adIds as $adId) {
                            if ($adId == $selfAd) {
                                unset($selfIdsArr[$k]);
                            }
                        }
                    }

                    //进行更新操作 更新本身的广告ids implode
                    Applet::where('id', $appId)->update([
                        'advertising_ids' => implode(",", $selfIdsArr)
                    ]);
                }
                break;
        }
    }
}
