<?php
namespace App\Http\Controllers;

/**
 * 로그인/가입/로그아웃 관련 화면들
 */
class AuthController extends Controller
{
    public function login()
    {
        $title = '로그인';
        return view('auth/login', get_defined_vars());
    }
}