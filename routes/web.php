<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/test', function () use ($router) {
    return 'Ik zweer ik steek php in zen hol';
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('items',  ['uses' => 'ItemsController@showAllItems']);
    $router->get('items/{id}', ['uses' => 'ItemsController@getByID']);
    $router->post('items', ['uses' => 'ItemsController@store']);
//    $router->delete('items/{id}', ['uses' => 'ItemController@delete']);
    $router->put('items/{id}', ['uses' => 'ItemsController@update']);
});
