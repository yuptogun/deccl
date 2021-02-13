<div class="{{ isset($inColumns) && $inColumns ? 'col-sm-6 col-md-4' : ''}}">
    <div class="deccl-article">
        {!! $comment->article->view_card !!}
    </div>
</div>
<div class="{{ isset($inColumns) && $inColumns ? 'col-sm-6 col-md-8' : ''}}">
    <div class="deccl-comment">
        <div class="deccl-comment-container p-3 rounded shadow bg-white">
            <small class="d-block text-muted mb-1">
                <a href="{!! $comment->user->url_profile !!}" class="text-muted">{{ $comment->user->proper_name_html }}</a>, <a href="{{ route('comment.show', compact('comment')) }}" class="text-muted">{{ $comment->created_at->diffForHumans() }}</a>
            </small>
            <div>{!! $comment->comment !!}</div>
            <div class="row mt-2">
                <div class="col text-left">
                    {!! $comment->html_reactions !!}
                </div>
                <div class="col text-right">
                    {!! $comment->html_actions !!}
                </div>
            </div>
        </div>
    </div>
</div>