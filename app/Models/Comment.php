<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
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
        return $this->hasOne(Article::class, 'id', 'article_id');
    }

    /**
     * 최근 $days 일간의 것으로 제한하는 스코프
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @param integer $days 값을 주지 않으면 COMMENT_RECENT_DAYS 환경값 사용. 그마저도 없으면 적용안함
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeRecent($query, $days = null)
    {
        if (!$days) $days = (int) env('COMMENT_RECENT_DAYS');
        Log::debug($days);

        return (int) $days > 0
            ? $query->where('created_at', '>=', Carbon::now()->subDays($days)->startOfDay())
            : $query;
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