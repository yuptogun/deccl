<?php
namespace App\Services\Crawler;

use Illuminate\Support\Facades\Log;

use App\Models\Article;
use App\Services\BaseCrawler;
use App\Interfaces\CrawlerInterface;

/**
 * articles 테이블에 INSERT 하기 위한 크롤러
 */
class ArticleCrawler extends BaseCrawler implements CrawlerInterface
{
    public function __construct($model = null)
    {
        if (!$model) $model = new Article;
        $this->model = $model;
    }

    /**
     * 크롤링을 한다.
     *
     * @param string $url
     * @return \Illuminate\Database\Eloquent\Model|boolean 성공시 저장된 모델, 실패시 `false`
     */
    public function crawl($url)
    {
        $url = $this->setURL($url);
        $this->setDOM($url);

        $this->setModelAttribute('url', $url);
        $this->setModelAttribute('title', function ($dom) {
            $meta = $dom->find('meta[property="og:title"]');
            if (count($meta) > 0) return $this->getAttribute($meta[0], 'content');

            $title = $dom->find('title');
            if (count($title) > 0) return $this->getText($title[0]);

            return null;
        });
        $this->setModelAttribute('thumbnail', function ($dom) {
            $meta1 = $dom->find('meta[property="twitter:image"]');
            if (count($meta1) > 0) return $this->getAttribute($meta1[0], 'content');

            $meta2 = $dom->find('meta[property="og:image"]');
            if (count($meta2) > 0) return $this->getAttribute($meta2[0], 'content');

            return null;
        });
        $this->setModelAttribute('summary', function ($dom) {
            $meta = $dom->find('meta[property="og:description"]');
            if (count($meta) > 0) return $this->getAttribute($meta[0], 'content');

            return null;
        });

        return $this->saveModel();
    }

    public function isModelReady()
    {
        Log::debug([$this->model->url, $this->model->title]);
        // url, title 2개는 필수
        return $this->model
            && $this->model->url
            && $this->model->title;
    }
}