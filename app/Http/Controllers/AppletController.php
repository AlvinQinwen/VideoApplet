<?php

namespace App\Http\Controllers;

use App\Models\Applet;
use Illuminate\Http\Request;
use Predis\Client;

class AppletController extends Controller
{
    private Client $redis;
    public function __construct()
    {
        $this->redis = new Client([
            'database' => 2
        ]);
    }

    public function index(Request $request, Applet $applet)
    {
        $page = $request->page??0;
        $page_size = $request->page_size??10;
        $params = $request->input();

        return response()->json([
            'code' => 200,
            'message' => '查询成功',
            'data' => $applet->searchCon($params, $page, $page_size)
        ]);

    }

    public function create(Request $request, Applet $applet)
    {
        $params = $request->input();
        $result = $applet->create($params)->toArray();

        $this->redis->set($result['app_id'], json_encode($result));

        return response()->json([
            'code' => 201,
            'message' => '新增小程序成功',
            'data' => $result
        ], 201);
    }

    public function edit(Request $request, Applet $applet)
    {
        $params = $request->input();
        $id = $request->id;
        $data = $applet->find($id)->toArray();
        if ($data) {

            $this->redis->set($data['app_id'], json_encode($data));

            return response()->json([
                'code' => 201,
                'message' => '更新数据成功',
                'data' => $applet->where('id', $id)->update($params)
            ], 201);
        }

        return response()->json([
            'code' => 500,
            'message' => '该数据不存在',
            'data' => null
        ]);


    }

    public function destroy(Request $request, Applet $applet)
    {
        $data = $applet->find($request->id)->toArray();
        if ($data) {

            $this->redis->del($data['app_id']);

            return response()->json([
                'code' => 204,
                'message' => '删除数据成功',
                'data' => $applet->where('id', $request->id)->delete()
            ]);
        }

        return response()->json([
            'code' => 500,
            'message' => '该数据不存在',
            'data' => null
        ]);
    }
}
