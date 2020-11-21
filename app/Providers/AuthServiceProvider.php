<?php
namespace App\Providers;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

use App\Models\User;

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
            } else if ($request->cookie('Authorization')) {
                $token = $request->cookie('Authorization');
            } else {
                return null;
            }

            if ($jwt = JWT::decode($token, env('JWT_SECRET'), ['HS256'])) {
                return User::find($jwt->sub);
            } else {
                return null;
            }
        });

        Gate::define('update-comment', function ($user, $comment) {
            return $user->id === $comment->user_id;
        });
    }
}