@extends('comment._')

@push('content')
<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="my-3">댓글 수정</h1>
            <form class="ajax" data-method="PUT" data-action="{{ route('api.comment.update', compact('comment')) }}">
                <div class="form-group row">
                    <label class="col-md-3 col-lg-2 col-form-label">기사</label>
                    <div class="col-md-9 col-lg-10">
                        <span class="form-control-plaintext">{!! $comment->article->html_title !!}</span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-lg-2 col-form-label">댓글</label>
                    <div class="col-md-9 col-lg-10">
                        <textarea id="comment" name="comment" rows="5" class="form-control" placeholder="이 기사에 대해 한마디 해주세요.">{!! $comment->comment !!}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col text-right">
                        <button type="submit" class="btn btn-primary">수정</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endpush