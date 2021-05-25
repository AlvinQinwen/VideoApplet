<?php

namespace App\Http\Controllers;

use App\Models\Applet;
use Illuminate\Http\Request;

class AppletController extends Controller
{
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
        return response()->json([
            'code' => 201,
            'message' => 'success',
            'data' => $applet->create($request->input())
        ], 201);
    }

    public function edit(Request $request, Applet $applet)
    {
        $params = $request->input();
        $id = $request->id;

        return response()->json([
            'code' => 201,
            'message' => '更新数据成功',
            'data' => $applet->where('id', $id)->update($params)
        ], 201);
    }

    public function destroy(Request $request, Applet $applet)
    {
        return response()->json([
            'code' => 204,
            'message' => '删除数据成功',
            'data' => $applet->where('id', $request->id)->delete()
        ]);
    }
}
