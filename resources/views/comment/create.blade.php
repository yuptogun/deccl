@extends('comment._')

@push('body_after')
<script>
(function ($) {
    let findOrNew = "{{ route('api.article.findOrNew') }}";
    let articleRadioContainer = $('#article_radio');
    let articleSearchInput = $('#article_url');
    let commentInput = $('#comment');

    articleSearchInput.on('change', function (e) {
        let searchValue = $(e.target).val();
        let ajaxConfig = getAJAXConfig(findOrNew, 'POST', {search: searchValue});
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
    });

    commentInput.summernote({
        height: 240,
        placeholder: '이 기사에 대해 한마디 해주세요.',
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'strikethrough', 'clear']]
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
            <h1 class="my-3">새 댓글 작성</h1>
            <form class="ajax" data-method="POST" data-action="{{ route('api.comment.store') }}">
                <div class="form-group row">
                    <label class="col-md-3 col-lg-2 col-form-label">기사</label>
                    <div class="col-md-9 col-lg-10">
                        <input type="url" id="article_url" name="url" class="form-control" placeholder="기사 제목 또는 URL 입력하여 검색" />
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-9 offset-md-3 col-lg-10 offset-lg-2">
                        <div id="article_radio"></div>
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