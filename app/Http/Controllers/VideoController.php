<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index(Request $request, Video $video)
    {
        $page = $request->page??0;
        $page_size = $request->page_size??10;
        $params = $request->input();

        return response()->json([
            'code' => 200,
            'message' => '查询成功',
            'data' => $video->searchCon($params, $page, $page_size)
        ]);

    }

    public function create(Request $request, Video $video)
    {
        return response()->json([
            'code' => 201,
            'message' => 'success',
            'data' => $video->create($request->input())
        ], 201);
    }

    public function edit(Request $request, Video $video)
    {
        $params = $request->input();
        $id = $request->id;

        return response()->json([
            'code' => 201,
            'message' => '更新数据成功',
            'data' => $video->where('id', $id)->update($params)
        ], 201);
    }

    public function destroy(Request $request, Video $video)
    {
        return response()->json([
            'code' => 204,
            'message' => '删除数据成功',
            'data' => $video->where('id', $request->id)->delete()
        ], 204);
    }
}
