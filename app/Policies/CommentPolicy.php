<?php
namespace App\Policies;

/**
 * 댓글 관련 보안정책
 * 
 * @author yuptogun <eojin1211@hanmail.net>
 */
class CommentPolicy
{
    /**
     * 어떤 사람이 댓글을 수정할 수 있으려면?
     *
     * @param \App\Models\User $user
     * @param \App\Models\Comment $comment
     * @return boolean 자기가 쓴 댓글이어야 함
     */
    public function update($user, $comment)
    {
        return $user->id === $comment->user_id;
    }

    /**
     * 어떤 사람이 댓글을 삭제할 수 있으려면?
     *
     * @param \App\Models\User $user
     * @param \App\Models\Comment $comment
     * @return boolean update 와 이하동문
     */
    public function destroy($user, $comment)
    {
        return $this->update($user, $comment);
    }
}