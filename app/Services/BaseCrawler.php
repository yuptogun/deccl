<?php
namespace App\Services;

use PHPHtmlParser\Dom;
use PHPHtmlParser\Options;
use Illuminate\Support\Facades\Log;

/**
 * 크롤링 서비스 공통클래스
 */
class BaseCrawler
{
    /**
     * 크롤링해서 얻은 DOM 파싱데이터
     *
     * @var \PHPHtmlParser\Dom
     */
    protected $dom;

    /**
     * 크롤링하는 URL 의 charset
     *
     * @var string
     */
    public $charset = 'UTF-8';

    /**
     * 크롤링 결과를 INSERT 할 모델
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $model;

    /**
     * URL 을 받아서 불필요한 get 변수를 날리고 정돈한다.
     *
     * * fbclid, utm-* 변수를 날림 (그밖에도 각종 트래킹 코드는 알아내서 없애야 함)
     * * 각 언론사별로 꼭 필요한 변수값만 남기고 다 삭제하는 로직 구현해야 함
     *
     * @param string $url
     * @return string
     */
    public function setURL($url)
    {
        $parsed_url = parse_url($url);
        Log::debug($parsed_url);

        $newquery = '';
        if (isset($parsed_url['query'])) {
            parse_str($parsed_url['query'], $query);
            foreach ($query as $key => $value) {
                if (str_starts_with($key, 'fbclid') || str_starts_with($key, 'utm_')) {
                    unset($query[$key]);
                }
            }
            $newqueries = [];
            foreach ($query as $key => $value) {
                $newqueries[] = "$key=$value";
            }
            $newquery = implode('&', $newqueries);
        }
        Log::debug($newquery);

        // https://www.php.net/manual/en/function.parse-url.php#106731
        $scheme   = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : '';
        $host     = isset($parsed_url['host']) ? $parsed_url['host'] : '';
        $port     = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : '';
        $user     = isset($parsed_url['user']) ? $parsed_url['user'] : '';
        $pass     = isset($parsed_url['pass']) ? ':' . $parsed_url['pass']  : '';
        $pass     = ($user || $pass) ? "$pass@" : '';
        $path     = isset($parsed_url['path']) ? $parsed_url['path'] : '';
        $fragment = isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : '';
        return "$scheme$user$pass$host$port$path$newquery$fragment";
    }

    /**
     * URL 을 받아서 DOM 파싱해 프로퍼티로 꽂아놓는다.
     *
     * @param string $url
     * @return void
     */
    public function setDOM($url)
    {
        if (!$this->isDOMReady()) {
            $html = @file_get_contents($url);
            preg_match_all('/<meta charset="([^"]+)".*>/mi', $html, $matches, PREG_SET_ORDER, 0);
            if (count($matches) > 0) {
                $charset = $matches[0][1];
                $this->charset = $charset;
                $html = iconv($this->charset, 'UTF-8', $html);
            }
            $dom = new Dom;
            $dom->loadStr($html, (new Options)->setEnforceEncoding('UTF-8'));
            $this->dom = $dom;
        }
    }

    /**
     * protected 되어있는 dom 을 돌려준다.
     *
     * @return \PHPHtmlParser\Dom
     */
    public function getDOM()
    {
        return $this->dom;
    }

    /**
     * DOM 이 준비되었는가?
     *
     * @return boolean
     */
    public function isDOMReady()
    {
        return !! $this->dom;
    }

    /**
     * 주어진 모델의 특정 속성에 값을 넣기 위해 콜백을 실행해 준다.
     *
     * @param string $attr 속성명 (즉 컬럼명)
     * @param mixed $callbackOrValue 익명함수는 `function ($dom) use ($foo) { ... };` 형식. 넣을 값을 바로 넣어도 됨
     * @return void
     */
    public function setModelAttribute($attr, $callbackOrValue)
    {
        $model = $this->model;
        $dom = $this->getDOM();
        $value = is_callable($callbackOrValue) ? $callbackOrValue($dom) : $callbackOrValue;
        if ($value) $model->{$attr} = $value;
    }

    /**
     * 지금 모델을 저장해도 좋은가?
     *
     * 기본적으로 모델이 존재하며 속성들에 값이 주입돼 있는지 체크한다.
     * 각 자식크롤러에서 필요한 추가 validation 실행할 것
     *
     * @return boolean 이게 true 일 때만 saveModel() 이 동작함
     */
    public function isModelReady()
    {
        return $this->model && $this->model->isDirty();
    }

    /**
     * 현재의 모델 인스턴스에 save() 를 실행한다.
     *
     * @return \Illuminate\Database\Eloquent\Model|boolean 성공시 저장된 모델, 실패시 `false`
     */
    public function saveModel()
    {
        return $this->isModelReady() && $this->model->save() ? $this->model : false;
    }

    public function getText($element)
    {
        return $element->text;
    }
    public function getAttribute($element, $attr)
    {
        return $element->getAttribute($attr);
    }
}