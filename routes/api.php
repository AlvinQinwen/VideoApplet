<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdvertisingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * 广告模块
 */
Route::group(['prefix' => 'advertising'], function () {
    Route::post('index/{page?}/{page_size?}', [AdvertisingController::class, 'index'])->name('广告列表');
    Route::post('create', [AdvertisingController::class, 'create'])->name('新增广告');
    Route::get('edit/{id}', [AdvertisingController::class, 'edit'])->name('广告修改');
    Route::get('destroy/{id}', [AdvertisingController::class, 'destroy'])->name('广告删除');
});

/**
 * 视频模块
 */
Route::group(['prefix' => 'video'], function () {

});
