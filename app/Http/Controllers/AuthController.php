<?php
namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Cookie;

/**
 * 로그인/가입/로그아웃 관련 화면들
 */
class AuthController extends Controller
{
    public function login()
    {
        if (request()->user) {
            return redirect(route('home.index'));
        }

        $title = '로그인';
        return view('auth/login', get_defined_vars());
    }

    public function logout()
    {
        $cookie = new Cookie('Authorization');
        return redirect(route('home.index'))->withCookie($cookie);
    }
}