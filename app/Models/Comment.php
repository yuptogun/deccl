<?php
namespace App\Models;

use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\IsEntryModel;

use Illuminate\Database\Eloquent\Model;

/**
 * comments
 * 
 * 댓글 하나하나
 */
class Comment extends Model
{
    use SoftDeletes;
    use IsEntryModel;

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

    public function getHtmlActionsAttribute()
    {
        $user = auth()->user();
        $html = '<ul class="small list-inline mb-0">';

        if ($user && Gate::forUser($user)->allows('destroy-comment', $this)) {
            $html .= '<li class="list-inline-item mr-0 ml-2"><a href="#" class="text-danger ajax" data-method="DELETE" data-action="'.route('api.comment.destroy', ['comment' => $this]).'" data-confirm="정말 이 글을 삭제할까요?" data-redirect="#">삭제</a></li>';
        }
        if ($user && Gate::forUser($user)->allows('update-comment', $this)) {
            $html .= '<li class="list-inline-item mr-0 ml-2"><a href="'.route('comment.edit', ['comment' => $this]).'">수정</a></li>';
        } else {
            $html .= '<li class="list-inline-item mr-0 ml-2"><a href="'.route('comment.create', ['article' => $this->article]).'">나도 댓글 달기</a></li>';
        }

        return $html .= '</ul>';
    }
}