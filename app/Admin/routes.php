<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    $router->resources([
        'vps' => VpsController::class,
        'account' => AccountController::class,
        'design' => DesignController::class,
        'shirt' => ShirtController::class,
        'color' => ColorController::class,
    ]);
    $router->get('shirt/color/{id}','ShirtController@getPickColor');
    $router->post('shirt/color/{id}','ShirtController@postPickColor');
});
