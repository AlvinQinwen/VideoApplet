<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Applet
 *
 * @property int $id
 * @property string $name 小程序名称
 * @property string $app_id appid
 * @property string $secret secret
 * @property int $debug 是否开启debug骗审 1正常 2开启 默认开启2
 * @property string $advertising_ids 广告ids
 * @property string $mark 备用字段
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Applet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Applet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Applet query()
 * @method static \Illuminate\Database\Eloquent\Builder|Applet whereAdvertisingIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applet whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applet whereDebug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applet whereMark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applet whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applet whereSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applet whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read mixed $advertising_info
 * @property string $interstitia_unitId 插屏广告单元
 * @property int $screen_open 是否开启插屏1开启，2关闭
 * @property string $rewarded_unitId 激励广告单元
 * @property int $excitation_open 是否开启激励1开启，2关闭
 * @property string $which_video_type 使用哪种视频 1腾讯云 2腾讯视频 默认1
 * @method static \Illuminate\Database\Eloquent\Builder|Applet whereExcitationOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applet whereInterstitiaUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applet whereRewardedUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Applet whereScreenOpen($value)
 */
class Applet extends BaseModel
{
    protected $fillable = ['id', 'name', 'app_id', 'secret', 'debug', 'advertising_ids', 'mark',
        'interstitia_unitId', 'screen_open', 'rewarded_unitId', 'excitation_open', 'which_video_type', 'created_at'
    ];

    protected $hidden = ['updated_at', 'advertising_ids'];

    protected $appends = ['advertisingInfo'];

    public function getAdvertisingInfoAttribute()
    {
        if ($this->advertising_ids != '') {
            $array = explode(',', $this->advertising_ids);
            return Advertising::getInstance()->getInfo($array);
        }
        return collect([]);
    }

    public function searchCon(array $validated, $page, $page_size)
    {
         $page = $page > 0 ? $page : 1;
         $start = $page_size * ($page - 1);

         $condition = self::where(function ($query) use ($validated){

             if(!empty($validated)) {

                if ( !empty($validated['name'])) {
                    $query->where('name', 'like', '%'.$validated['name'].'%');
                }

                 if ( !empty($validated['app_id'])) {
                     $query->where('app_id', $validated['app_id']);
                 }

                 if ( !empty($validated['debug'])) {
                     $query->where('debug', $validated['debug']);
                 }

                 if ( !empty($validated['mark'])) {
                     $query->where('mark', 'like', '%'.$validated['mark'].'%');
                 }
             }

         });

        $data['total'] = $condition->count('id');

         $data['data'] = $condition
             ->select($this->fillable)
             ->skip($start)
             ->take($page_size)
             ->orderBy('created_at', 'desc')
             ->get();

         $data['per_page'] = $page_size;

         return $data;

    }
}
