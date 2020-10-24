<?php
namespace App\Listeners\Article;

use App\Models\Article;

/**
 * 특정 기사 모델의 title, summary, thumbnail 을 최신화한다.
 * 
 * 왜 URL을 받지 않고 기사 모델로 받느냐? URL 이 고유키가 아니기 때문.
 */
class Crawling
{
    /**
     * 주어진 $event 에 article 이 있을 경우 그 기사 모델의 url 에 접속해서 데이터를 파싱한다.
     *
     * @param \App\Events\Event $event
     * @return \App\Models\Article|boolean 처리 중단/실패시 false
     */
    public function handle($event)
    {
        if (!$event->article || !$event->article->exists) return false;

        $article = new Article;
        $article->fill([
            'url' => $event->url,
            'title' => $event->url, // 이 필드에 뭐라도 박아야 함
        ]);
        if (!$article->save()) return false;

        return $article;
    }
}