<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Models\Comment;
use App\Models\Reaction;

use App\Http\Controllers\APIController;

/**
 * 댓글 관련 API
 */
class ReactionController extends APIController
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store(Request $request, $comment)
    {
        $this->validate($request, [
            'reaction' => ['required_without:custom_reaction'],
            'custom_reaction' => ['required_without:reaction'],
        ], [
            'reaction.required_without' => '이모지를 선택하세요.',
            'custom_reaction.required_without' => '이모지를 적어 주세요.',
        ]);

        $reaction = $request->input('custom_reaction') ?: $request->input('reaction');
        if (!is_emoji($reaction)) {
            return $this->responseAJAX(422, '다른 사람의 댓글에는 이모지만 달 수 있어요! 뭔가 더 할 말이 있으시다면 \'나도 댓글 달기\'로 전해 보세요.');
        }

        $commentModel = Comment::findOrFail($comment);
        if (!Gate::forUser($request->user)->allows('store-reaction', $commentModel)) {
            return $this->responseAJAX(401, '권한이 없습니다.');
        }

        $data = [
            'user_id' => $request->user->getKey(),
            'comment_id' => $comment,
            'reaction' => $reaction,
        ];
        $created = $commentModel->reactions()->create($data);

        return $this->responseAJAX($created ? 200 : 500, null);
    }
    public function update(Request $request, $comment, $reaction)
    {
        //
    }
    public function destroy(Request $request, $comment, $reaction)
    {
        //
    }
}