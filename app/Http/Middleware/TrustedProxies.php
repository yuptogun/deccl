<?php
namespace App\Http\Middleware;

use Illuminate\Http\Request;

/**
 * 리버스 프록시 지원 미들웨어
 */
class TrustedProxies
{
    protected $trustedProxies = [
        '0.0.0.0/0'
    ];

    public function handle(Request $request, \Closure $next)
    {
        $trustedHeaderSet =
            Request::HEADER_FORWARDED |
            Request::HEADER_X_FORWARDED_ALL |
            Request::HEADER_X_FORWARDED_FOR |
            Request::HEADER_X_FORWARDED_HOST |
            Request::HEADER_X_FORWARDED_PROTO;
        Request::setTrustedProxies($this->trustedProxies, $trustedHeaderSet);
        return $next($request);
    }
}