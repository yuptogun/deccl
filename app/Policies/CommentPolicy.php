<?php
namespace App\Policies;

/**
 * 댓글 관련 보안정책
 * 
 * @author yuptogun <eojin1211@hanmail.net>
 */
class CommentPolicy
{
    public function update($user, $comment)
    {
        return $user->id === $comment->user_id;
    }
    public function destroy($user, $comment)
    {
        return $this->update($user, $comment);
    }
}