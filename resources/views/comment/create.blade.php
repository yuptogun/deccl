@extends('comment._')

@push('body_after')
<script>
(function ($) {
    let findOrNew = "{{ route('api.article.findOrNew') }}";
    $('#article_url').on('change keydown blur', function (e) {
        let searchValue = $(e.target).val();
        let result = doAJAX(findOrNew, 'POST', {search: searchValue});
        console.log(result);
    });
})(jQuery);
</script>
@endpush

@section('body')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3">
            <h1 class="my-3">새 댓글 작성</h1>
            <form method="POST" action="{{ route('api.comment.store') }}">
                <div class="form-group row">
                    <label class="col-md-3 col-lg-2 col-form-label">기사</label>
                    <div class="col-md-9 col-lg-10">
                        <input type="url" id="article_url" name="url" class="form-control" placeholder="기사 제목 또는 URL 입력하여 검색" />
                    </div>
                    <div class="col">
                        <div id="article_preview"></div>
                        <input type="hidden" name="article_id" value="" onload="this.value = '';" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-lg-2 col-form-label">댓글</label>
                    <div class="col-md-9 col-lg-10">
                        <textarea name="comment" rows="5" class="form-control" placeholder="이 기사에 대해 한마디 해주세요." required></textarea>
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
@endsection