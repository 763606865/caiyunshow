<?php

use App\Admin\Controllers\BannerController;
use App\Admin\Controllers\Evaluations\EvaluationController;
use App\Admin\Controllers\Evaluations\IndicatorController;
use App\Admin\Controllers\Evaluations\MeasureController;
use App\Admin\Controllers\MenuController;
use Encore\Admin\Facades\Admin;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], static function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');

    $router->resource('menu', MenuController::class);

    $router->resource('banner', BannerController::class);

});

// 测评项目
Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], static function (Router $router) {

    // 类别-列表
    $router->get('/evaluation/evaluations', [EvaluationController::class, 'index']);
    // 类别-新增页
    $router->get('/evaluation/evaluations/create', [EvaluationController::class, 'create']);
    // 类别-新增
    $router->post('/evaluation/evaluations', [EvaluationController::class, 'store']);
    // ----------------------------------------------------------------------------------

    // 分类指标组
    $router->resource('/evaluation/measures', MeasureController::class);
    // ----------------------------------------------------------------------------------

    // 指标库
    $router->resource('/evaluation/indicators', IndicatorController::class);
    // ----------------------------------------------------------------------------------
});
