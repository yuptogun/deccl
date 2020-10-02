<?php
namespace App\Http\Controllers;

/**
 * API용 컨트롤러
 */
class APIController extends Controller
{
    /**
     * HTTP 상태코드와 필요한 내용을 전달한다.
     *
     * @param integer $code
     * @param string $message
     * @param string $redirect
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseAJAX($code = 400, $message = 'Bad Request', $data = null, $redirect = null)
    {
        $body = compact('message');
        if ($data) $body = array_merge($body, compact('data'));
        if ($redirect) $body = array_merge($body, compact('redirect'));
        return response()->json($body, $code);
    }
}