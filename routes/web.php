<?php

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

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('/login', ['as' => 'login', 'uses' => 'Auth\LoginController@login']);

//    $router->group(['middleware' => 'auth'], function () use ($router) {
//        $router->group(['middleware' => 'role:admin'], function () use ($router) {
            $router->post('/upload-file', ['as' => 'admin.upload_file', 'uses' => 'Admin\AdminController@uploadFile']);
//        });
//    });
});