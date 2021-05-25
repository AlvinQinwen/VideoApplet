<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Video
 *
 * @property int $id
 * @property string $title 视频标题
 * @property string $cover_url 视频封面
 * @property string $video_url 视频播放地址
 * @property string $share_cover 分享封面
 * @property int $sort 权重
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Video newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Video newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Video query()
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereCoverUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereShareCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereVideoUrl($value)
 * @mixin \Eloquent
 */
class Video extends BaseModel
{
    protected $fillable = ['id', 'title', 'cover_url', 'video_url', 'share_cover', 'sort', 'created_at'];

    protected $hidden = ['updated_at'];

    /**
     * @param array $validated
     * @param $page
     * @param $page_size
     * @return mixed
     */
    public function searchCon(array $validated, $page, $page_size)
    {
         $page = $page > 0 ? $page : 1;
         $start = $page_size * ($page - 1);

         $condition = self::where(function ($query) use ($validated){

             if(!empty($validated)) {

                if ( !empty($validated['title'])) {
                    $query->where('title', 'like', '%'.$validated['title'].'%');
                }

                 if ( !empty($validated['id'])) {
                     $query->where('id', $validated['id']);
                 }

             }

         });

        $data['total'] = $condition->count('id');

         $data['data'] = $condition
             ->select($this->fillable)
             ->skip($start)
             ->take($page_size)
             ->orderBy('sort', 'desc')
             ->orderBy('created_at', 'desc')
             ->get();

         $data['per_page'] = $page_size;

         return $data;
    }

}
