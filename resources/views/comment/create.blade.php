@extends('comment._')

@push('body_after')
<script>
(function ($) {
    let articleRadioContainer = $('#article_radio');
    let articleSearchInput = $('#article_url');
    let commentInput = $('#comment');
    let findOrNewArticle = "{{ route('api.article.findOrNew') }}";
    let articleUrlRequested = "{{ request()->input('url') }}";

    let getArticleOptions = function () {
        let searchValue = articleSearchInput.val(); // 의도적으로 길이 체크를 하지 않음.
        let ajaxConfig = getAJAXConfig(findOrNewArticle, 'POST', {search: searchValue});
        articleRadioContainer.slideUp().html('');
        $.ajax(ajaxConfig)
        .done(function (data) {
            if (data && data.articles) {
                data.articles.forEach(article => {
                    articleRadioContainer.append($(article));
                });
                articleRadioContainer.slideDown();
            }
        });
    };

    articleSearchInput.on('change', function () {
        getArticleOptions();
    });
    if (articleUrlRequested) {
        getArticleOptions();
    }
    commentInput.summernote({
        height: 240,
        placeholder: '이 기사에 대해 한마디 해 주세요.',
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
            ['etc', ['codeview']]
        ]
    }).on("summernote.enter", function (we, e) {
        $(this).summernote("pasteHTML", "<br>");
        e.preventDefault();
    });
})(jQuery);
</script>
@endpush

@push('content')
<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="my-3">새 댓글 쓰기</h1>
            <form class="ajax" data-method="POST" data-action="{{ route('api.comment.store') }}">
                <div class="form-group row">
                    <label class="col-md-3 col-lg-2 col-form-label">기사</label>
                    <div class="col-md-9 col-lg-10">
                        <input type="text" id="article_url" name="url" class="form-control" placeholder="기사 제목 또는 URL로 검색" value="{!! request()->input('url') !!}" />
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-9 offset-md-3 col-lg-10 offset-lg-2">
                        <div id="article_radio">
@if (isset($article) && $article)
@include('comment._radio_article', ['article' => $article, 'checked' => true])
@endif
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-lg-2 col-form-label">댓글</label>
                    <div class="col-md-9 col-lg-10">
                        <textarea id="comment" name="comment" rows="5" class="form-control" placeholder="이 기사에 대해 한마디 해주세요."></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col text-right">
                        <button type="submit" class="btn btn-primary">댓글달기</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endpush