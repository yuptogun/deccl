<div class="deccl">
    <div class="deccl-article">
        <div class="deccl-article-container p-3 rounded border">
            <h6 class="mb-0">{!! $comment->article->html_title !!}</h6>
        </div>
    </div>
    <div class="deccl-comment">
        <div class="deccl-comment-container p-3 rounded shadow bg-white">
            <small class="d-block text-muted mb-1">
                <a href="{!! $comment->user->url_profile !!}" class="text-muted">{{ $comment->user->proper_name_html }}</a>, <a href="{{ route('comment.show', compact('comment')) }}" class="text-muted">{{ $comment->created_at->diffForHumans() }}</a>
            </small>
            <div>{!! $comment->summary !!}</div>
            <div class="row mt-2">
                <div class="col text-left">
                    {!! $comment->html_reactions !!}
                    <!-- span class="badge badge-pill badge-light">👍 1</span -->
                </div>
                <div class="col text-right">
                    {!! $comment->html_actions !!}
                </div>
            </div>
        </div>
    </div>
</div>