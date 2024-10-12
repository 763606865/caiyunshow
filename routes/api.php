<?php

use App\Api\BusinessCard\Controllers\AuthController;
use App\Api\BusinessCard\Controllers\IndexController;
use App\Api\Tool\Controllers\StateOpenController;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([
    'prefix' => '/business_card',
    'namespace' => 'App\\Api\\BusinessCard\\Controllers'
], static function (Router $router) {

    $router->group(['prefix' => '/auth'], function (Router $router) {

        $router->post('/login', 'AuthController@login')->name('login');

        $router->post('/wechat/login', 'AuthController@wechatLogin')->name('wechat_login');
    });

    // 用户信息
    $router->group(['prefix' => '/user', 'middleware' => ['auth.business_card']], function (Router $router) {
        $router->group(['prefix' => '/wechat'], function (Router $router) {
            $router->post('/sync', [\App\Api\BusinessCard\Controllers\UserController::class, 'wechatSync'])->name('wechat_sync');
        });
    });


    $router->group(['prefix' => '/test'], function (Router $router) {
        $router->group(['prefix' => '/wechat'], function (Router $router) {
            $router->post('/encrypt', [IndexController::class, 'wechatEncrypt']);
            $router->post('/decrypt', [IndexController::class, 'wechatDecrypt']);
        });
    });

    $router->post('/test', [IndexController::class, 'test']);
    $router->get('/user', [AuthController::class, 'user']);
});

Route::group([
    'prefix' => '/tool',
    'namespace' => 'App\\Api\\Tool\\Controllers'
], static function (Router $router) {
    // 国家开放大学-监听video
    Route::post('/state_open/video_listener', [StateOpenController::class, 'postVideoListener']);
    Route::post('/state_open/video_listener/bulk', [StateOpenController::class, 'postBulkVideoListener']);
    // ---------------------------------------------------------------------------
});
