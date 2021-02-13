<div class="{{ isset($inColumns) && $inColumns ? 'col-sm-6 col-md-4' : ''}}">
    <div class="deccl-article">
        {!! $comment->article->view_card !!}
    </div>
</div>
<div class="{{ isset($inColumns) && $inColumns ? 'col-sm-6 col-md-8' : ''}}">
    <div class="deccl-comment">
        <div class="deccl-comment-container p-3 rounded shadow bg-white">
            <small class="d-block text-muted mb-1">
                <a href="{{ route('user.show', ['user' => $comment->user]) }}" class="text-muted">{{ $comment->user->name }}</a>, <a href="{{ route('comment.show', compact('comment')) }}" class="text-muted">{{ $comment->created_at->diffForHumans() }}</a>
            </small>
            <div>{!! $comment->comment !!}</div>
            <div class="row">
                <div class="col text-left">
                    👍 <span class="badge badge-pill badge-light">1</span>
                </div>
                <div class="col text-right">
                    <ul class="list-inline mb-0">
@if (Gate::forUser($user)->allows('update-comment', $comment))
                        <li class="list-inline-item">
                            <a href="{{ route('comment.edit', compact('comment')) }}"><small>수정</small></a>
                        </li>
@endif
                        <li class="list-inline-item">
                            <a href="#"><small>나도 댓글 달기</small></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>