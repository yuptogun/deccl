<div class="col-sm-6 col-md-4">
    <div class="deccl-article">
        {!! $comment->article->view_card !!}
    </div>
</div>
<div class="col-sm-6 col-md-8">
    <div class="deccl-comment">
        <div class="deccl-comment-container p-3 rounded shadow bg-white">
            <small class="d-block text-muted mb-1">
                {{ $comment->user->name }}, <a href="{{ route('comment.show', compact('comment')) }}" class="text-muted">{{ $comment->created_at->diffForHumans() }}</a>
            </small>
            <div>{!! $comment->comment !!}</div>
            <div class="row">
                <div class="col text-left">
                    👍 <span class="badge badge-pill badge-light">1</span>
                </div>
                <div class="col text-right">
                    <a href="#"><small>나도 댓글 달기</small></a>
                </div>
            </div>
        </div>
    </div>
</div>