<?php
namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;

use App\Models\User;

/**
 * get current user on the web by "token" cookie.
 */
class GetCurrentUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->user = null;
        if ($request->cookie('Authorization')) {
            $token = $request->cookie('Authorization');
            if ($jwt = JWT::decode($token, env('JWT_SECRET'), ['HS256'])) {
                $request->user = User::find($jwt->sub);
            }
        }
        return $next($request);
    }
}