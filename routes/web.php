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

    $router->group(['prefix' => 'category'], function () use ($router){
        $router->get('/', ['uses' => 'CategoryController@getAllCategories']);
        $router->post('/', ['uses' => 'CategoryController@createCategory']);
        $router->get('/{id}', ['uses' => 'CategoryController@getCategoryByID']);
        $router->put('/{id}', ['uses' => 'CategoryController@updateCategory']);
//        $router->delete('/{id}', ['uses' => 'CategoryController@deleteCategory']);
        //TODO: Add delete
    });
    $router->group(['prefix' => 'product'], function () use ($router){
        $router->get('/', ['uses' => 'ProductController@getAllProducts']);
        $router->post('/', ['uses' => 'ProductController@createProduct']);
        $router->get('/{id}', ['uses' => 'ProductController@getProductByID']);
        $router->put('/{id}', ['uses' => 'ProductController@updateProduct']);
    });
});

$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->get('/', function () use ($router) {
        return "Welcome to the auth page";
    });
    $router->get('info', ['middleware' => 'authToken' , 'uses' => 'UserController@info']);
    $router->post('login', ['uses' => 'UserController@login']);
    $router->post('register', ['uses' => 'UserController@register']);
});
