<?php

namespace App\Http\Controllers;

use App\Events\AppGroupEvent;
use App\Models\AppGroup;
use Illuminate\Http\Request;

class AppGroupController extends Controller
{
    public function index(Request $request, AppGroup $AppGroup)
    {
        $page = $request->page??0;
        $page_size = $request->page_size??10;
        $params = $request->input();

        return response()->json([
            'code' => 200,
            'message' => '查询成功',
            'data' => $AppGroup->searchCon($params, $page, $page_size)
        ]);

    }

    public function create(Request $request, AppGroup $AppGroup)
    {
        $result = $AppGroup->create($request->input());

        //当同时新增了广告组的相关数据 才会触发该事件
        if (!empty($result->ad_group_id) && !empty($result->app_ids)) {
            event(new AppGroupEvent(1, $result->app_ids, $result->ad_group_id));
        }

        return response()->json([
            'code' => 201,
            'message' => 'success',
            'data' => $result
        ], 201);
    }

    public function edit(Request $request, AppGroup $AppGroup)
    {
        $params = $request->input();
        $id = $request->id;

        return response()->json([
            'code' => 201,
            'message' => '更新数据成功',
            'data' => $AppGroup->where('id', $id)->update($params)
        ], 201);
    }

    public function destroy(Request $request, AppGroup $AppGroup)
    {
        //首先拿到要删除的数据
        $data =  $AppGroup->find($request->id);
        event(new AppGroupEvent(3, $data->app_ids, $data->ad_group_id));

        return response()->json([
            'code' => 204,
            'message' => '删除数据成功',
            'data' => $data->delete()
        ]);
    }
}
