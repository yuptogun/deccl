<?php

$router->group(['as' => 'home'], function ($router) {
    $router->get('/', ['uses' => 'HomeController@index', 'as' => 'index']);
});

$router->group(['as' => 'auth'], function ($router) {
    $router->get('login', ['uses' => 'AuthController@login', 'as' => 'login']);
    $router->post('logout', ['uses' => 'AuthController@logout', 'as' => 'logout']);
});