<?php

use Illuminate\Routing\Router;
use Orchestra\Support\Facades\Foundation;

/*
|--------------------------------------------------------------------------
| Frontend Routing
|--------------------------------------------------------------------------
*/

Foundation::group('blupl/host', 'host', ['namespace' => 'Blupl\Host\Http\Controllers'], function (Router $router) {

        $router->get('create', 'HostController@create');
});

/*
|--------------------------------------------------------------------------
| Backend Routing
|--------------------------------------------------------------------------
*/

Foundation::namespaced('Blupl\Host\Http\Controllers\Admin', function (Router $router) {
    $router->group(['prefix' => 'Host'], function (Router $router) {
        $router->get('/', 'HomeController@index');
        $router->match(['GET', 'HEAD', 'DELETE'], 'profile/{roles}/delete', 'HomeController@delete');

    });
});
