<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Models\Comment;

use App\Http\Controllers\APIController;

/**
 * 댓글 관련 API
 */
class CommentController extends APIController
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'article_id' => 'required',
            'comment' => 'required',
        ]);

        $comment = new Comment;
        $comment->fill($request->input());
        $comment->user_id = $request->user->id;
        if (!$comment->save()) return $this->responseAJAX(500, '다시 시도해 주세요.');

        return $this->responseAJAX(200, '댓글이 등록됐습니다.', route('home.index'), compact('comment'));
    }
}