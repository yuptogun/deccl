<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Models\Article;
use App\Events\Article\ShouldBeCreated;

use App\Http\Controllers\APIController;
use Illuminate\Support\Facades\Log;

/**
 * 기사 관련 API
 */
class ArticleController extends APIController
{
    /**
     * 기사들을 찾거나 만들어냅니다.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function findOrNew(Request $request)
    {
        if (!$request->ajax()) return $this->alertAndGoBack();

        $this->validate($request, [
            'search' => 'required',
        ]);

        $search = $request->input('search');
        $articles = $this->searchArticlesOrCreateOne($search);

        if ($articles->isEmpty()) return $this->responseAJAX(416, '제목으로 검색하지 못했습니다. URL을 입력해 주시면 추가해 드리겠습니다.');

        $articles->transform(function ($article) {
            return view('comment._radio_article', compact('article'))->render();
        });

        return response()->json(compact('articles'));
    }

    /**
     * 실제로 기사를 찾거나 하나 만드는 소스.
     *
     * 원래는 URL 이 주어졌을 경우 그 URL 그대로 저장한 다음 다시 검색을 돌렸다.
     * #46 처리 과정에서 이 부분 제거함. (크롤링이 성공하면 그걸 그대로 반환)
     *
     * @param string $search 기사 제목 또는 URL
     * @return \Illuminate\Support\Collection 생성을 못했거나 못하는 상황이면 빈 콜렉션
     */
    private function searchArticlesOrCreateOne($search)
    {
        $articles = Article::search($search)->get();

        if (!$articles->isEmpty()) {
            return $articles;
        }
        if (!is_valid_url($search)) {
            Log::error("$search : invalid");
            return collect();
        }

        $created = event(new ShouldBeCreated($search));
        if (!$created || !isset($created[0]) || !$created[0]) {
            Log::error("$search : uncrawled");
            return collect();
        }

        $article = $created[0];
        return collect([$article]);
    }
}