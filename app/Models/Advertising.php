<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * App\Models\Advertising
 *
 * @property int $id
 * @property string|null $title 广告标题
 * @property string $cover_url 广告图片
 * @property string $jump_url 跳转连接
 * @property int $sort 权重
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Advertising newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Advertising newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Advertising query()
 * @method static \Illuminate\Database\Eloquent\Builder|Advertising whereCoverUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertising whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertising whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertising whereJumpUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertising whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertising whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertising whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Advertising extends BaseModel
{
    protected $fillable = ['id', 'title', 'cover_url', 'jump_url', 'sort', 'type', 'created_at'];

    protected $hidden = ['updated_at'];

    //单利调用
    private static $_instance;
    public static function getInstance()
    {
        if (self::$_instance === NULL) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function searchCon(array $validated, $page, $page_size)
    {
         $page = $page > 0 ? $page : 1;
         $start = $page_size * ($page - 1);

         $condition = self::where(function ($query) use ($validated){

             if(!empty($validated)) {

                if ( !empty($validated['title'])) {
                    $query->where('title','like','%'.$validated['title'].'%');
                }

                 if ( !empty($validated['sort'])) {
                     $query->where('sort', $validated['sort']);
                 }

                 if ( !empty($validated['type'])) {
                     $query->where('type', $validated['type']);
                 }

             }

         });

        $data['total'] = $condition->count('id');

         $data['data'] = $condition
             ->select($this->fillable)
             ->skip($start)
             ->take($page_size)
             ->orderBy('sort','desc')
             ->get();

         $data['per_page'] = $page_size;

         return $data;
    }

    /**
     * @description 通过ids获取广告信息
     * @param $ids
     * @return Collection
     */
    public function getInfo($ids)
    {
        return self::whereIn('id', $ids)
            ->select(['id', 'title', 'cover_url', 'jump_url', 'sort', 'type'])
            ->orderBy('sort', 'desc')
            ->get();
    }
}
