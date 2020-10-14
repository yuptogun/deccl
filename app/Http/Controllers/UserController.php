<?php
namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;

/**
 * 기본 화면들
 */
class UserController extends Controller
{
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

    /**
     * 가입 처리 POST 액션
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * 내 정보 (수정) 화면
     * 
     * 대시보드와 구분해서 생각하기. 여기는 회원정보 관리하는 곳이다. 대시보드 메뉴는 별도로 있어야 한다.
     *
     * @param integer $user
     * @return \Illuminate\View\View
     */
    public function show($user)
    {
        if ($user = User::find($user)) {
            if ($user == request()->user) {
                $title = '내 정보';
                return view('user.show', get_defined_vars());
            }
        }
        return abort(401, 'Unauthorized.');
    }
}