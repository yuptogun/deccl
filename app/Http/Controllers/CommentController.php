<?php
namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Support\Facades\Gate;

/**
 * 댓글 읽기/쓰기 화면 관련
 */
class CommentController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth', ['only' => ['create', 'edit']]);
    }

    public function create()
    {
        $user = $this->user;
        $title = '새 댓글 작성';
        return view('comment.create', get_defined_vars());
    }

    public function show($comment)
    {
        $comment = Comment::findOrFail($comment);
        $user = $this->user;
        $title = strip_tags($comment->summary_with_info);
        $thumbnail = $comment->article->thumbnail;
        return view('comment.show', get_defined_vars());
    }

    public function edit($comment)
    {
        $comment = Comment::findOrFail($comment);
        $user = $this->user;
        if (!Gate::forUser($user)->allows('update-comment', $comment)) {
            return $this->alertAndGoBack(401, '권한이 없습니다.');
        }

        $title = '댓글 수정';
        return view('comment.edit', get_defined_vars());
    }
}