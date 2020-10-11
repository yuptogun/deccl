<?php
namespace App\Http\Controllers;

use App\Models\User;

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

        $user = new User;
        $user->fill($request->input());
        if (!$user->save()) return $this->responseAJAX(500, '다시 시도해 주세요.');

        return $this->responseAJAX(200, '가입되셨습니다! 로그인 화면으로 이동합니다.', route('auth.login'));
    }
}