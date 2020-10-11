<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * 기본 화면들
 */
class UserController extends Controller
{
    public function create()
    {
        $title = '회원가입';
        return view('user.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'password_confirm' => 'required|min:6|same:password',
            'agreed_terms' => 'required',
        ]);

        return $this->responseAJAX(500, '개발중!');
    }
}