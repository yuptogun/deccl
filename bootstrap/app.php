<?php

require_once __DIR__.'/../vendor/autoload.php';

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();

date_default_timezone_set(env('APP_TIMEZONE', 'Asia/Seoul'));

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

$app->withFacades();
$app->withEloquent();

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->configure('app');

// $app->middleware([
//     App\Http\Middleware\ExampleMiddleware::class
// ]);

$app->routeMiddleware([
    'user' => App\Http\Middleware\GetCurrentUser::class,
    'auth' => App\Http\Middleware\Authenticate::class,
]);

$app->register(App\Providers\AppServiceProvider::class);
$app->register(App\Providers\AuthServiceProvider::class);
$app->register(App\Providers\EventServiceProvider::class);

$app->router->group([
    'namespace' => 'App\Http\Controllers',
    'middleware' => 'user'
], function ($router) {
    require __DIR__.'/../routes/web.php';
});
$app->router->group([
    'as' => 'api', 'prefix' => 'api',
    'namespace' => 'App\Http\Controllers\API',
    'middleware' => 'user'
], function ($router) {
    require __DIR__.'/../routes/api.php';
});

// todo 미들웨어로 빼기
app('translator')->setlocale('ko');

return $app;