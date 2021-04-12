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
    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    public function getSummaryAttribute()
    {
        preg_match_all('/(?!<.*blockquote.*>)<p>(((?!<\/p>).)*)<\/p>/m', $this->comment, $paragraphs, PREG_SET_ORDER, 0);
        if (!$paragraphs || !isset($paragraphs[0]) || !isset($paragraphs[0][1])) return $this->comment;
        return $paragraphs[0][1];
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
    public function getHtmlReactionsAttribute()
    {
        $user = auth()->user();
        $reactions = $this->reactions->groupBy('reaction')->map(function ($rows, $reaction) {
            return $reaction.' <span class="badge badge-light">'.$rows->count().'</span>';
        })->implode(' ');
        if (empty($reactions)) $reactions = '👍 <span class="badge badge-light">0</span>';
        if ($user && Gate::forUser($user)->allows('store-reaction', $this)) {
            $reactionModel = $this->reactions()->exists() ? $this->reactions->first() : new Reaction;
            return '<div class="dropdown"><a href="#" role="button" class="btn btn-sm btn-light dropdown-toggle" type="button" id="reaction_dropdown_'.$this->getKey().'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$reactions.'</a><div class="dropdown-menu" aria-labelledby="reaction_dropdown_'.$this->getKey().'">'.
            '<form class="ajax form-reaction px-2" data-method="POST" data-action="'.route('api.reaction.store', ['comment' => $this->getKey()]).'" data-redirect="#"><div class="form-group mb-0">'.($reactionModel->html_radio_options).'<input type="text" name="custom_reaction" class="form-control" placeholder="이모지 1개만 가능" /><div class="text-right"><button type="submit" class="btn btn-primary">보내기</button></div></div></form>'.
            '</div></div>';
        } else {
            return '<a href="'.($user ? '#' : route('auth.login')).'" class="btn btn-sm btn-light">'.$reactions.'</a>';
        }
    }
    public function getHtmlActionsAttribute()
    {
        $user = auth()->user();
        $html = '<ul class="small list-inline mb-0">';

        if ($user && Gate::forUser($user)->allows('destroy-comment', $this)) {
            $html .= '<li class="list-inline-item mr-0 ml-2"><a href="#" class="btn btn-sm btn-link text-danger ajax" data-method="DELETE" data-action="'.route('api.comment.destroy', ['comment' => $this]).'" data-confirm="정말 이 글을 삭제할까요?" data-redirect="#">삭제</a></li>';
        }
        if ($user && Gate::forUser($user)->allows('update-comment', $this)) {
            $html .= '<li class="list-inline-item mr-0 ml-2"><a href="'.route('comment.edit', ['comment' => $this]).'" class="btn btn-sm btn-link">수정</a></li>';
        } else {
            $html .= '<li class="list-inline-item mr-0 ml-2"><a href="'.route('comment.create', ['article' => $this->article]).'" class="btn btn-link btn-sm">나도 댓글 달기</a></li>';
        }

        return $html .= '</ul>';
    }
}