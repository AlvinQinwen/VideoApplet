<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdvertisingController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\AppletController;
use App\Http\Controllers\PathController;

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
    Route::post('edit/{id}', [AdvertisingController::class, 'edit'])->name('广告修改');
    Route::get('destroy/{id}', [AdvertisingController::class, 'destroy'])->name('广告删除');
});

/**
 * 视频模块
 */
Route::group(['prefix' => 'video'], function () {
    Route::post('index/{page?}/{page_size?}', [VideoController::class, 'index'])->name('视频列表');
    Route::post('create', [VideoController::class, 'create'])->name('新增视频');
    Route::post('edit/{id}', [VideoController::class, 'edit'])->name('视频修改');
    Route::get('destroy/{id}', [VideoController::class, 'destroy'])->name('视频删除');
});

/**
 * 小程序模块
 */
Route::group(['prefix' => 'app'], function () {
    Route::post('index/{page?}/{page_size?}', [AppletController::class, 'index'])->name('小程序列表');
    Route::post('create', [AppletController::class, 'create'])->name('新增小程序');
    Route::post('edit/{id}', [AppletController::class, 'edit'])->name('小程序修改');
    Route::get('destroy/{id}', [AppletController::class, 'destroy'])->name('小程序删除');
});

/**
 * 路径
 */
Route::group(['prefix' => 'path'], function () {
    Route::post('index/{page?}/{page_size?}', [PathController::class, 'index'])->name('小程序列表');
    Route::post('create', [PathController::class, 'create'])->name('新增小程序');
    Route::post('edit/{id}', [PathController::class, 'edit'])->name('小程序修改');
    Route::get('destroy/{id}', [PathController::class, 'destroy'])->name('小程序删除');
});
