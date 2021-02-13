<?php
namespace App\Policies;

/**
 * 댓글 반응 관련 보안정책
 * 
 * @author yuptogun <eojin1211@hanmail.net>
 */
class ReactionPolicy
{
    /**
     * 어떤 사용자가 어떤 댓글에 반응하려면?
     *
     * @param \App\Models\User $user
     * @param \App\Models\Comment $comment
     * @return boolean 그 사용자는 그 댓글을 쓴 적이 없어야 함
     */
    public function store($user, $comment)
    {
        return $user->id != $comment->user_id;
    }

    /**
     * 어떤 사용자가 어떤 댓글의 반응을 수정하려면?
     *
     * @param \App\Models\User $user
     * @param \App\Models\Comment $comment
     * @param \App\Models\Reaction $reaction
     * @return boolean 그 사용자는 그 댓글을 쓴 적은 없고 그 반응은 한 적이 있어야 함
     */
    public function update($user, $comment, $reaction)
    {
        return $this->store($user, $comment)
            && $user->id === $reaction->user_id;
    }

    /**
     * 어떤 사람이 어떤 댓글의 반응을 삭제할 수 있으려면?
     *
     * @param \App\Models\User $user
     * @param \App\Models\Comment $comment
     * @param \App\Models\Reaction $reaction
     * @return boolean update 와 이하동문
     */
    public function destroy($user, $comment, $reaction)
    {
        return $this->update($user, $comment, $reaction);
    }
}