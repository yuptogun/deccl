<?php
namespace App\Http\Controllers\API;

use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Cookie;

use App\Models\User;

use App\Http\Controllers\APIController;

/**
 * 로그인/가입/로그아웃 관련 화면들
 */
class AuthController extends APIController
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login']]);
    }

    public function login(Request $request)
    {
        // 최소한의 검증
        $this->validate($request, [
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);

        // 비밀번호 확인
        $user = User::where('email', $request->input('email'))->first();
        if (!Hash::check($request->input('password'), $user->password)) {
            return $this->responseAJAX(404, 'No matching credential.');
        }

        // JWT 생성
        $token = JWT::encode([
            'sub' => $user->getKey(),
            'aud' => request()->ip(),
            'iat' => time(),
            'exp' => strtotime('+1 year'),
        ], env('JWT_SECRET'));

        // 반환
        return response()
            ->json(['message' => 'SUCCESS', 'redirect' => route('home.index')], 200)
            ->withCookie(new Cookie('Authorization', $token, strtotime('+1 year')));
    }
}