<?php

$router->group(['as' => 'auth', 'prefix' => 'auth'], function ($router) {
    $router->post('login', ['uses' => 'AuthController@login', 'as' => 'login']);
});