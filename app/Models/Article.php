<?php
namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\IsEntryModel;
use App\Traits\IsSearchableModel;
use Illuminate\Database\Eloquent\Model;

/**
 * articles
 * 
 * 기사 (URL) 콘텐츠 하나하나
 */
class Article extends Model
{
    use SoftDeletes;
    use IsEntryModel, IsSearchableModel;

    protected $fillable = [
        'url', 'title', 'summary', 'thumbnail',
    ];
    public $searchable = [
        'url', 'title', 'summary',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function vendor()
    {
        return $this->hasManyThrough(Vendor::class, VendorArticle::class, 'vendor_id');
    }

    /**
     * title 값에 적당히 링크 붙여서 제공한다.
     * 
     * 메소드명이 getHtmlFoo 인 것은 'foo' 필드 값을 html 로 포맷팅하는 것.
     *
     * @return string
     */
    public function getHtmlTitleAttribute()
    {
        $title = $this->title;
        $url = $this->url;
        $icon = '<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-link-45deg" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M4.715 6.542L3.343 7.914a3 3 0 1 0 4.243 4.243l1.828-1.829A3 3 0 0 0 8.586 5.5L8 6.086a1.001 1.001 0 0 0-.154.199 2 2 0 0 1 .861 3.337L6.88 11.45a2 2 0 1 1-2.83-2.83l.793-.792a4.018 4.018 0 0 1-.128-1.287z"/><path d="M6.586 4.672A3 3 0 0 0 7.414 9.5l.775-.776a2 2 0 0 1-.896-3.346L9.12 3.55a2 2 0 0 1 2.83 2.83l-.793.792c.112.42.155.855.128 1.287l1.372-1.372a3 3 0 0 0-4.243-4.243L6.586 4.672z"/></svg>';

        return "$title <a href=\"$url\" target=\"_blank\">$icon</a>";
    }
    /**
     * comment._article_card 뷰에 데이터를 부어서 카드 html 반환한다.
     * 
     * 메소드명이 getViewFoo 인 것은 'foo' 가 포함된 뷰파일을 사용하는 것.
     *
     * @return string 1개의 div.card 를 갖는 html
     */
    public function getViewCardAttribute()
    {
        return view('comment._article_card', ['article' => $this])->render();
    }
}