<?php
namespace App\Http\Controllers;

use App\Models\User;

/**
 * 기본 화면들
 * 
 * @todo 사용자가 자기 자신을 수정/삭제 하는 부분도 authorization policy 구현 가능하지 않은가? 되는 대로 하기
 */
class UserController extends Controller
{
    public function __consturct()
    {
        $this->middleware('auth', ['only' => 'edit']);
    }

    /**
     * 회원가입 화면 
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $title = '회원가입';
        return view('user.create', get_defined_vars());
    }

    public function show($user)
    {
        $user = User::whereHas('property', function ($q) use ($user) {
            return $q->where('username', $user);
        })->orWhere('id', $user)->first();
        if (!$user) abort(404);

        return view('user.show', get_defined_vars());
    }

    /**
     * 내 정보 수정 화면
     * 
     * 대시보드와 구분해서 생각하기. 여기는 회원정보 관리하는 곳이다. 대시보드 메뉴는 별도로 있어야 한다.
     *
     * @param integer $user
     * @return \Illuminate\View\View
     */
    public function edit($user)
    {
        $user = User::find($user);
        if (!$user || $user != request()->user) {
            return $this->alertAndGoBack();
        }

        $title = '내 정보';
        return view('user.edit', get_defined_vars());
    }
}