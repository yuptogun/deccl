<?php
namespace App\Events\Article;

use App\Events\Event;

/**
 * "앗! 이 URL 을 갖는 Article 자료 하나 빨리 만들어야해요" 하는 이벤트
 */
class ShouldBeCreated extends Event
{
    /**
     * 기사 URL
     *
     * @var string
     */
    public $url;

    public function __construct($url)
    {
        $this->url = $url;
    }
}