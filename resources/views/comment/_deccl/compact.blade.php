<div class="deccl">
    <div class="deccl-article">
        <div class="deccl-article-container p-3 rounded border">
            <h6 class="mb-0">{!! $comment->article->html_title !!}</h6>
        </div>
    </div>
    <div class="deccl-comment">
        <div class="deccl-comment-container p-3 rounded shadow bg-white">
            <small class="d-block text-muted mb-1">
                {{ $comment->user->name }}, <a href="{{ route('comment.show', compact('comment')) }}" class="text-muted">{{ $comment->created_at->diffForHumans() }}</a>
            </small>
            <div>{!! $comment->summary !!}</div>
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