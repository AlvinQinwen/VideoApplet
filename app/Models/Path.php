<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Path
 *
 * @property int $id
 * @property string $app_id app_id
 * @property string $desc 描述
 * @property int $status 状态 1正常 2异常
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Path newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Path newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Path query()
 * @method static \Illuminate\Database\Eloquent\Builder|Path whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Path whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Path whereDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Path whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Path whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Path whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Path extends BaseModel
{
    protected $fillable = ['id', 'app_id', 'desc', 'status', 'created_at'];

    protected $hidden = ['updated_at'];

    protected $appends = ['app_name'];

    public function getAppNameAttribute()
    {
        return Applet::where('app_id', $this->app_id)->select('name')->value('name');
    }


    public function searchCon(array $validated, $page, $page_size)
    {
         $page = $page > 0 ? $page : 1;
         $start = $page_size * ($page - 1);

         $condition = self::where(function ($query) use ($validated){

             if(!empty($validated)) {

                if ( !empty($validated['app_id'])) {
                    $query->where('app_id', 'like', '%'.$validated['app_id'].'%');
                }

                if ( !empty($validated['desc'])) {
                    $query->where('desc', 'like', '%'.$validated['desc'].'%');
                }

                 if ( !empty($validated['status'])) {
                     $query->where('status', $validated['status']);
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
