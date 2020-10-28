<div class="deccl deccl-full position-relative">
    <div class="col-md-6">
        <div class="deccl-article position-relative mr-5">
            {!! $comment->article->view_card !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="deccl-comment position-relative ml-3 mt-3">
            <div class="deccl-comment-container p-3 rounded shadow bg-white">
                {!! $comment->comment !!}
                <p class="mb-0">
                    <small class="text-muted">
                        {{ $comment->user->name }}, {{ $comment->created_at->diffForHumans() }}
                    </small>
                    <a href="#" class="float-right"><small>나도 댓글 달기</small></a>
                </p>
            </div>
        </div>
    </div>
</div>