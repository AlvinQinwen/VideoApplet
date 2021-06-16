<?php

namespace App\Http\Controllers;

use App\Events\AppGroupEvent;
use App\Models\AdGroup;
use App\Models\AppGroup;
use Illuminate\Http\Request;

class AdGroupController extends Controller
{
    public function index(Request $request, AdGroup $AdGroup)
    {
        $page = $request->page??0;
        $page_size = $request->page_size??10;
        $params = $request->input();

        return response()->json([
            'code' => 200,
            'message' => '查询成功',
            'data' => $AdGroup->searchCon($params, $page, $page_size)
        ]);

    }

    public function create(Request $request, AdGroup $AdGroup)
    {
        $params = $request->input();
        $params['ad_ids'] = $params['ad_ids']??'';
        $result = $AdGroup->create($params);

        return response()->json([
            'code' => 201,
            'message' => 'success',
            'data' => $result
        ], 201);
    }

    public function edit(Request $request, AdGroup $AdGroup)
    {
        $params = $request->input();
        $data  = $AdGroup->find($request->id);
        $data->update($params);

        //通过广告组的id拿到小程序组中使用该广告组的小程序组
        $appGroups = AppGroup::select(['id', 'ad_group_id', 'app_ids'])->where('ad_group_id', $request->id)->get()->toArray();
        foreach ($appGroups as $k => $appGroup) {
            //循环前先判断该组有没有绑定小程序 如果绑定了 才会去进行重置操作
            \Log::info(json_encode($appGroup));
//            if ($appGroup->app_ids) {
//                event(new AppGroupEvent(1, $appGroup->app_ids, $appGroup->ad_group_id));
//            }
        }

        return response()->json([
            'code' => 201,
            'message' => '更新数据成功',
            'data' => null
        ], 201);
    }

    public function destroy(Request $request, AdGroup $AdGroup)
    {
        //首先拿到所有小程序组中在用该广告组的小程序
        $appGroups = AppGroup::select(['id', 'ad_group_id', 'app_ids'])->where('ad_group_id', $request->id)->get()->toArray();
        foreach ($appGroups as $k => $appGroup) {
            \Log::info(json_encode($appGroup));
//            if ($appGroup->app_ids) {
//                event(new AppGroupEvent(2, $appGroup->app_ids, $appGroup->ad_group_id));
//            }
        }

        $data = $AdGroup->find($request->id);
        return response()->json([
            'code' => 204,
            'message' => '删除数据成功',
            'data' => $data->delete()
        ]);
    }
}
