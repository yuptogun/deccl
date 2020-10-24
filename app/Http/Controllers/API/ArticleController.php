<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Models\Article;
use App\Events\Article\ShouldBeCreated;

use App\Http\Controllers\APIController;

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

        if (empty($articles)) return $this->responseAJAX(416, '제목으로 검색하지 못했습니다. URL을 입력해 주시면 추가해 드리겠습니다.');

        $articles->transform(function ($article) {
            return view('comment._radio_article', compact('article'))->render();
        });

        return response()->json(compact('articles'));
    }

    /**
     * 실제로 기사를 찾거나 하나 만드는 소스.
     *
     * @param string $search 기사 제목 또는 URL
     * @return \Illuminate\Support\Collection 생성을 못했거나 못하는 상황이면 빈 콜렉션
     */
    private function searchArticlesOrCreateOne($search)
    {
        $articles = Article::where(function ($a) use ($search) {
            $a->where('url', 'like', "%$search%")
            ->orWhere('title', 'like', "%$search%");
        })->get();

        if (!$articles) {
            if (is_valid_url($search)) {
                event(new ShouldBeCreated($search));
                return $this->searchArticlesOrCreateOne($search);
            }
        }

        return $articles;
    }
}