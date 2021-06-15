<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AdGroup
 *
 * @property int $id
 * @property string $ad_group_name 广告组组名
 * @property string $ad_ids 广告表的ids
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AdGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdGroup whereAdGroupName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdGroup whereAdIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AdGroup extends BaseModel
{
    protected $fillable = ['id', 'ad_group_name', 'ad_ids', 'created_at'];

    protected $appends = ['ad_name'];

    protected $hidden = ['updated_at'];

    public function getAdNameAttribute()
    {
        if ($this->ad_ids != '') {
            $idArr = explode(',', $this->ad_ids);
            return Advertising::whereIn('id', $idArr)->select('title')->get();
        }
        return collect([]);
    }

    public function searchCon(array $validated, $page, $page_size)
    {
         $page = $page > 0 ? $page : 1;
         $start = $page_size * ($page - 1);

         $condition = self::where(function ($query) use ($validated){

             if(!empty($validated)) {

                 if ( !empty($validated['id']) ) {
                     $query->where('id', $validated['id']);
                 }

                if ( !empty($validated['ad_group_name'])) {
                    $query->where('ad_group_name','like','%'.$validated['ad_group_name'].'%');
                }

                if ( !empty($validated['ad_ids'])) {
                    $query->where('ad_ids','like','%'.$validated['ad_ids'].'%');
                }

             }

         });

        $data['total'] = $condition->count('id');

         $data['data'] = $condition
             ->select($this->fillable)
             ->skip($start)
             ->take($page_size)
             ->orderBy('created_at','desc')
             ->get();

         $data['per_page'] = $page_size;

         return $data;

    }
}
