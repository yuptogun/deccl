<?php
namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

/**
 * reactions
 * 
 * 댓글에 달리는 반응 하나하나
 */
class Reaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'comment_id', 'reaction',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}