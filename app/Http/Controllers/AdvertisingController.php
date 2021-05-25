<?php

namespace App\Http\Controllers;

use App\Models\Advertising;
use Illuminate\Http\Request;

class AdvertisingController extends Controller
{

    public function index(Request $request, Advertising $advertising)
    {
        $page = $request->page??0;
        $page_size = $request->page_size??10;
        $params = $request->input();

        return response()->json([
            'code' => 200,
            'message' => '查询成功',
            'data' => $advertising->searchCon($params, $page, $page_size)
        ]);

    }

    public function create(Request $request, Advertising $advertising)
    {
        return response()->json([
            'code' => 201,
            'message' => 'success',
            'data' => $advertising->create($request->input())
        ], 201);
    }

    public function edit(Request $request, Advertising $advertising)
    {
        $params = $request->input();
        $id = $request->id;

        return response()->json([
            'code' => 201,
            'message' => '更新数据成功',
            'data' => $advertising->where('id', $id)->update($params)
        ], 201);
    }

    public function destroy(Request $request, Advertising $advertising)
    {
        return response()->json([
            'code' => 204,
            'message' => '删除数据成功',
            'data' => $advertising->where('id', $request->id)->delete()
        ]);
    }
}
