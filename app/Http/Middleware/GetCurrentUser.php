<?php
namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;

use App\Models\User;

/**
 * 토큰 쿠키 또는 요청 인증헤더 쪽에 정당한 JWT 가 있는지 확인한다.
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