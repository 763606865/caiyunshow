<?php

use App\Api\BusinessCard\Controllers\AuthController;
use App\Api\BusinessCard\Controllers\IndexController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group([
    'prefix' => '/business_card',
    'namespace' => 'App\\Api\\BusinessCard\\Controllers',
], static function (Router $router) {

    $router->group(['prefix' => '/auth'], function (Router $router) {

        $router->post('/login', 'AuthController@login')->name('login');

        $router->post('/wechat/login', 'AuthController@wechatLogin')->name('wechat_login');
    });

    // 用户信息
    $router->group(['prefix' => '/user'], function (Router $router) {
        $router->group(['prefix' => '/wechat'], function (Router $router) {
            $router->post('/sync', 'UserController@wechatSync')->name('wechat_sync');
        });
    })->middleware('auth');


    $router->group(['prefix' => '/test'], function (Router $router) {
        $router->group(['prefix' => '/wechat'], function (Router $router) {
            $router->post('/encrypt', [IndexController::class, 'wechatEncrypt']);
            $router->post('/decrypt', [IndexController::class, 'wechatDecrypt']);
        });
    });

    $router->post('/test', [IndexController::class, 'test']);
    $router->get('/user', [AuthController::class, 'user']);
});
