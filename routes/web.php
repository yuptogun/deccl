<?php

$router->group(['as' => 'home'], function ($router) {
    $router->get('/', ['uses' => 'HomeController@index', 'as' => 'index']);
});

$router->get('@{user}', ['uses' => 'UserController@show', 'as' => 'user.showAsUsername']);

$router->group(['prefix' => 'user', 'as' => 'user'], function ($router) {
    $router->get('create',      ['uses' => 'UserController@create', 'as' => 'create']);
    $router->get('{user}',      ['uses' => 'UserController@show',   'as' => 'show']);
    $router->get('{user}/edit', ['uses' => 'UserController@edit',   'as' => 'edit']);
});

$router->group(['prefix' => 'comment', 'as' => 'comment'], function ($router) {
    $router->get('create',    ['uses' => 'CommentController@create', 'as' => 'create']);
    $router->get('{comment}', ['uses' => 'CommentController@show',   'as' => 'show']);
    // $router->put('{user}', ['uses' => 'UserController@update', 'as' => 'update']);
});

$router->group(['as' => 'auth'], function ($router) {
    $router->get('login',   ['uses' => 'AuthController@login',  'as' => 'login']);
    $router->post('logout', ['uses' => 'AuthController@logout', 'as' => 'logout']);
});