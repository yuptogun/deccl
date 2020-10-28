<div class="deccl position-relative">
    <div class="deccl-article position-relative mr-5">
        <div class="deccl-article-container p-3 rounded border">
            <h6 class="mb-0">{!! $comment->article->html_title !!}</h6>
        </div>
    </div>
    <div class="deccl-comment position-relative ml-3 mt-3">
        <div class="deccl-comment-container p-3 rounded shadow bg-white">
            {!! $comment->summary !!}
            <p class="mb-0">
                <small class="text-muted">
                    {{ $comment->user->name }}, <a href="{{ route('comment.show', compact('comment')) }}" class="text-muted">{{ $comment->created_at->diffForHumans() }}</a>
                </small>
                <a href="#" class="float-right"><small>나도 댓글 달기</small></a>
            </p>
        </div>
    </div>
</div>