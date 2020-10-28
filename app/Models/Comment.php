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
        $firstLine = explode('<br>', $this->comment)[0];
        return str_replace('</p>', '', str_replace('<p>', '', $firstLine));
    }
    public function getInfoAttribute()
    {
        $name = $this->user->name;
        $ago = $this->created_at->diffForHumans();
        return trans('comment.attr.info', get_defined_vars());
    }
    public function getSummaryWithInfoAttribute()
    {
        $name = $this->user->name;
        $ago = $this->created_at->diffForHumans();
        $summary = $this->summary;
        $info = $this->info;
        return trans('comment.attr.summary_with_info', get_defined_vars());
    }
}