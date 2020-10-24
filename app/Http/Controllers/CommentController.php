<?php
namespace App\Http\Controllers;

/**
 * 댓글 읽기/쓰기 화면 관련
 */
class CommentController extends Controller
{
    public function create()
    {
        $user = $this->user;
        $title = '새 댓글 작성';
        return view('comment.create', get_defined_vars());
    }
}