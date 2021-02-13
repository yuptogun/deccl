<?php

$router->group(['as' => 'auth', 'prefix' => 'auth'], function ($router) {
    $router->post('login', ['uses' => 'AuthController@login', 'as' => 'login']);
});

$router->group(['as' => 'user', 'prefix' => 'user'], function ($router) {
    $router->post('/',     ['uses' => 'UserController@store',  'as' => 'store']);
    $router->put('{user}', ['uses' => 'UserController@update', 'as' => 'update']);

    $router->group(['namespace' => 'User'], function ($router) {
        $router->group(['as' => 'property', 'prefix' => 'property'], function ($router) {
            $router->put('{user}', ['uses' => 'PropertyController@update', 'as' => 'update']);
            $router->post('{user}/profile_picture', ['uses' => 'PropertyController@updateProfilePicture', 'as' => 'updateProfilePicture']);
        });
    });
});

$router->group(['as' => 'comment', 'prefix' => 'comment'], function ($router) {
    $router->post('/',           ['uses' => 'CommentController@store',   'as' => 'store']);
    $router->put('{comment}',    ['uses' => 'CommentController@update',  'as' => 'update']);
    $router->delete('{comment}', ['uses' => 'CommentController@destroy', 'as' => 'destroy']);
});

$router->group(['as' => 'article', 'prefix' => 'article'], function ($router) {
    $router->post('findOrNew', ['uses' => 'ArticleController@findOrNew', 'as' => 'findOrNew']);
});