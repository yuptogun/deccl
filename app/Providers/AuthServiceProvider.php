<?php

namespace App\Providers;

use App\Models\User;

use Firebase\JWT\JWT;

use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['auth']->viaRequest('api', function ($request) {
            if ($request->header('Authorization')) {
                $token = explode(' ', $request->header('Authorization'))[1];
                if ($jwt = JWT::decode($token, env('JWT_SECRET'), ['HS256'])) {
                    return User::find($jwt->sub);
                }
            }
        });
    }
}