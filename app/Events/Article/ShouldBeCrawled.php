<?php
namespace App\Events\Article;

use App\Events\Event;

/**
 * "앗! 이 Article 자료는 title, summary, thumbnail 을 최신화해야 해요" 라는 이벤트
 */
class ShouldBeCrawled extends Event
{
    /**
     * Article 모델
     *
     * @var \App\Models\Article
     */
    public $article;

    public function __construct($article)
    {
        $this->article = $article;
    }
}