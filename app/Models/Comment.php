<?php
namespace App\Models;

use Carbon\Carbon;
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
        return $this->hasOne(Article::class, 'id');
    }

    /**
     * 대략 최근 5일간의 것으로 제한하는 스코프
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeRecent($query)
    {
        return $query->where('created_at', '>=', Carbon::now()->subDay(5)->startOfDay());
    }

    public function getSummaryAttribute()
    {
        return explode('<br>', $this->comment)[0];
    }
}