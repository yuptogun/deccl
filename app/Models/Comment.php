<?php
namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

/**
 * comments
 * 
 * 댓글 하나하나
 */
class Comment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'article_id', 'comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function article()
    {
        return $this->hasOne(Article::class);
    }
}