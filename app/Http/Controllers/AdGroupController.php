<?php

namespace App\Http\Controllers;

use App\Models\AdGroup;
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
        $id = $request->id;

        return response()->json([
            'code' => 201,
            'message' => '更新数据成功',
            'data' => $AdGroup->where('id', $id)->update($params)
        ], 201);
    }

    public function destroy(Request $request, AdGroup $AdGroup)
    {
        return response()->json([
            'code' => 204,
            'message' => '删除数据成功',
            'data' => $AdGroup->where('id', $request->id)->delete()
        ]);
    }
}
