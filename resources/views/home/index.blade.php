@extends('_full')

@push('content')
<div class="container my-3">
    <div class="row">
        <div class="col">
            <div id="home-deccl">
                <h4>{{ '최근 '.(env('COMMENT_RECENT_DAYS') ? env('COMMENT_RECENT_DAYS').'일간 ' : '') }}올라온 뉴스 + 댓글</h4>
@if ($recentComments->isEmpty())
                    <div class="text-center py-3">
                        <p>최근 올라온 댓글이 없습니다.</p>
                        <p><a href="{{ route('comment.create') }}" class="btn btn-primary">내가 하나 쓰기</a></p>
                    </div>
@else
                <div class="masonry">
    @foreach ($recentComments as $comment)
                    <div class="masonry-item">
        @include('comment._deccl.compact', compact('comment'))
                    </div>
    @endforeach
                </div>
@endif
            </div>
        </div>
    </div>
</div>
<div class="jumbotron">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>여러분의 뉴스 평론 놀이터, {{ env('APP_NAME') }}</h1>
                <p class="lead">뉴스의 댓글만 모아서 보고, 공유하고, 직접 씁니다. 내가 오늘 쓴 댓글이 내일의 뉴스가 되는 곳, {{ env('APP_NAME') }}입니다.</p>
            </div>
        </div>
    </div>
</div>
@endpush