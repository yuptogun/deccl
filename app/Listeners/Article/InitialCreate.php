<?php
namespace App\Listeners\Article;

use App\Services\Crawler\ArticleCrawler;

/**
 * URL 을 받아서 기사 데이터 입력하는 리스너
 */
class InitialCreate
{
    /**
     * 주어진 $event 에 url 이 있을 경우 그 URL 을 가지고 Article 모델 하나를 새로 생성한다.
     *
     * @param \App\Events\Event $event
     * @return \App\Models\Article|boolean 처리 중단/실패시 false
     */
    public function handle($event)
    {
        if (!$event->url || !is_valid_url($event->url)) return false;

        $cralwer = new ArticleCrawler;
        $article = $cralwer->crawl($event->url);
        return $article ?: false;
    }
}