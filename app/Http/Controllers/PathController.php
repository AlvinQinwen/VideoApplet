<?php

namespace App\Http\Controllers;

use App\Events\PathCacheEvent;
use App\Models\Path;
use Illuminate\Http\Request;

class PathController extends Controller
{
    public function index(Request $request, Path $Path)
    {
        $page = $request->page??0;
        $page_size = $request->page_size??10;
        $params = $request->input();

        return response()->json([
            'code' => 200,
            'message' => '查询成功',
            'data' => $Path->searchCon($params, $page, $page_size)
        ]);

    }

    public function create(Request $request, Path $Path)
    {
        $result = $Path->create($request->input());
        event(new PathCacheEvent(1, $result->toArray()));

        return response()->json([
            'code' => 201,
            'message' => 'success',
            'data' => $result
        ], 201);
    }

    public function edit(Request $request, Path $Path)
    {
        $params = $request->input();
        $id = $request->id;
        $data = $Path->find($id);
        if ($data) {

            event(new PathCacheEvent(1, $data->toArray()));

            return response()->json([
                'code' => 201,
                'message' => '更新数据成功',
                'data' => $Path->where('id', $id)->update($params)
            ], 201);
        }

        return response()->json([
            'code' => 500,
            'message' => '该数据不存在',
            'data' => null
        ]);

    }

    public function destroy(Request $request, Path $Path)
    {
        $data = $Path->find($request->id);
        if ($data) {

            event(new PathCacheEvent(2, $data->toArray()));

            return response()->json([
                'code' => 204,
                'message' => '删除数据成功',
                'data' => $Path->where('id', $request->id)->delete()
            ]);
        }

        return response()->json([
            'code' => 500,
            'message' => '该数据不存在',
            'data' => null
        ]);
    }
}
