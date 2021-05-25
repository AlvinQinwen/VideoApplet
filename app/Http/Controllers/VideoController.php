<?php

namespace App\Http\Controllers;

use App\Events\RedisCacheDataEvent;
use App\Models\Video;
use Illuminate\Http\Request;
use Predis\Client;

class VideoController extends Controller
{
    public function index(Request $request, Video $video)
    {
        $page = $request->page??0;
        $page_size = $request->page_size??10;
        $params = $request->input();
        $redis = new Client();
        $redis->set('total', $video->count());

        return response()->json([
            'code' => 200,
            'message' => '查询成功',
            'data' => $video->searchCon($params, $page, $page_size)
        ]);

    }

    public function create(Request $request, Video $video)
    {
        $result = $video->create($request->input());
        event(new RedisCacheDataEvent(1, $result->toArray()));

        return response()->json([
            'code' => 201,
            'message' => '新增视频成功',
            'data' => $result
        ], 201);
    }

    public function edit(Request $request, Video $video)
    {
        $params = $request->input();
        $id = $request->id;
        $data = $video->find($id)->toArray();
        if ($data) {
            event(new RedisCacheDataEvent(3, $data));
            return response()->json([
                'code' => 201,
                'message' => '更新数据成功',
                'data' => $video->where('id', $id)->update($params)
            ], 201);
        }

        return response()->json([
            'code' => 500,
            'message' => '该数据不存在',
            'data' => null
        ]);
    }

    public function destroy(Request $request, Video $video)
    {
        $data = $video->find($request->id)->toArray();
        if ($data) {
            event(new RedisCacheDataEvent(2, $data));
            return response()->json([
                'code' => 204,
                'message' => '删除数据成功',
                'data' => $video->where('id', $request->id)->delete()
            ]);
        }

        return response()->json([
            'code' => 500,
            'message' => '该数据不存在',
            'data' => null
        ]);
    }
}
