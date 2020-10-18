<?php

$router->group(['as' => 'auth', 'prefix' => 'auth'], function ($router) {
    $router->post('login', ['uses' => 'AuthController@login', 'as' => 'login']);
});

$router->group(['as' => 'user', 'prefix' => 'user'], function ($router) {
    $router->post('/',     ['uses' => 'UserController@store',  'as' => 'store']);
    $router->put('{user}', ['uses' => 'UserController@update', 'as' => 'update']);
});