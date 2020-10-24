<?php

$router->group(['as' => 'auth', 'prefix' => 'auth'], function ($router) {
    $router->post('login', ['uses' => 'AuthController@login', 'as' => 'login']);
});

$router->group(['as' => 'user', 'prefix' => 'user'], function ($router) {
    $router->post('/',     ['uses' => 'UserController@store',  'as' => 'store']);
    $router->put('{user}', ['uses' => 'UserController@update', 'as' => 'update']);
});

$router->group(['as' => 'comment', 'prefix' => 'comment'], function ($router) {
    $router->post('/',     ['uses' => 'CommentController@store',  'as' => 'store']);
});

$router->group(['as' => 'article', 'prefix' => 'article'], function ($router) {
    $router->post('findOrNew', ['uses' => 'ArticleController@findOrNew', 'as' => 'findOrNew']);
});