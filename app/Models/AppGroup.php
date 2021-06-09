<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AppGroup
 *
 * @property int $id
 * @property string $app_group_name 小程序组名
 * @property string $app_ids 小程序表的ids 这里是主键的id 不是app_id
 * @property int $ad_group_id 广告组表的id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AppGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|AppGroup whereAdGroupIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppGroup whereAppGroupName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AppGroup extends BaseModel
{
    protected $fillable = ['id', 'app_group_name', 'app_ids', 'ad_group_id', 'created_at'];

    protected $hidden = ['updated_at'];

    public function searchCon(array $validated, $page, $page_size)
    {
         $page = $page > 0 ? $page : 1;
         $start = $page_size * ($page - 1);

         $condition = self::where(function ($query) use ($validated){

             if(!empty($validated)) {

                 if ( !empty($validated['id']) ) {
                     $query->where('id', $validated['id']);
                 }

                if ( !empty($validated['app_group_name'])) {
                    $query->where('app_group_name','like','%'.$validated['app_group_name'].'%');
                }

                if ( !empty($validated['app_ids'])) {
                    $query->where('app_ids','like','%'.$validated['app_ids'].'%');
                }

                if ( !empty($validated['ad_group_id'])) {
                    $query->where('ad_group_ids', $validated['ad_group_ids']);
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
