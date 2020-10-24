<?php
namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * 총괄 공통 컨트롤러
 */
class Controller extends BaseController
{
    /**
     * 현재 로그인한 사용자
     *
     * @var \App\Models\User
     */
    public $user;

    public function __construct()
    {
        $this->user = request()->user;
    }

    /**
     * alert() 를 실행한 뒤 바로 어딘가로 이동하는 응답을 제공한다.
     *
     * @param integer $httpCode HTTP 응답 코드
     * @param string $message alert() 실행할 메시지
     * @param string $redirect 리디렉션 url. 별도 지정하지 않으면 back()
     * @return \Illuminate\Http\Response
     */
    public function alertAndGoBack($httpCode = 400, $message = '잘못된 접근입니다.', $redirect = null)
    {
        $script = '<script>alert("'.$message.'"); '.($redirect ? 'window.location.href = "'.$redirect.'"' : 'window.history.back();').'</script>';
        $html = '<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><meta http-equiv="X-UA-Compatible" content="ie=edge"><title>'.env('APP_NAME').'</title></head><body>'.$script.'</body></html>';

        return response($html, $httpCode);
    }

    /**
     * HTTP 상태코드와 필요한 내용을 전달한다.
     *
     * @param integer $code HTTP 응답 코드
     * @param string $message alert() 실행할 메시지
     * @param string $redirect 리디렉션 url. 별도 지정하지 않으면 AJAX 콜 발생한 그자리에 가만히 있는다.
     * @param array $data 혹시나 필요한 데이터가 있으면 넘길 것
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseAJAX($code = 400, $message = 'Bad Request', $redirect = null, $data = null)
    {
        $body = compact('message');
        if ($data) $body = array_merge($body, compact('data'));
        if ($redirect) $body = array_merge($body, compact('redirect'));
        return response()->json($body, $code);
    }
}