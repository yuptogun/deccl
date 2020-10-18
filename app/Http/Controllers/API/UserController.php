<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

use App\Http\Controllers\APIController;

/**
 * 사용자 관리 관련 API
 * 
 * @todo 사용자가 자기 자신을 수정/삭제 하는 부분도 authorization policy 구현 가능하지 않은가? 되는 대로 하기
 */
class UserController extends APIController
{
    /**
     * 가입 처리 POST 액션
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'password_confirm' => 'required|same:password',
            'agreed_terms' => 'required',
        ]);

        $user = new User;
        $user->fill($request->input());
        if (!$user->save()) return $this->responseAJAX(500, '다시 시도해 주세요.');

        return $this->responseAJAX(200, '가입되셨습니다! 로그인 화면으로 이동합니다.', route('auth.login'));
    }

    /**
     * 정보 변경 PUT 액션
     *
     * @param \Illuminate\Http\Request $request
     * @param integer $user 사용자번호
     * @param string type 현재 'info' 와 'password' 를 지원함
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $user)
    {
        $user = User::find($user);
        $type = $request->input('type');
        if (!$user || $user != $request->user) {
            return $this->responseAJAX(401, 'Unauthorized.');
        }

        $rules = $messages = [];
        switch ($type) {
            case 'info':
                break;

            case 'password':
                $rules = [
                    'old_password' => 'required|password:api',
                    'password' => 'required|min:6|different:old_password',
                    'password_confirm' => 'required|same:password',
                ];
                $messages = [
                    'old_password.password' => '기존 비밀번호가 틀립니다.',
                ];
                break;

            default:
                return $this->responseAJAX();
                break;
        }

        $this->validate($request, $rules, $messages);
        $user->fill($request->input());

        switch ($type) {
            case 'info':
                if (empty($user->name)) {
                    $user->name = $user->email;
                }
                break;
            case 'password':
                $user->password = Hash::make($request->input('password'));
                break;
            default:
                break;
        }

        if (!$user->save()) return $this->responseAJAX(500, '다시 시도해 주세요.');

        return $this->responseAJAX(200, '변경되었습니다.', '#');
    }
}