@extends('_full')

@push('content')
<div class="container my-3">
    <div class="row">
        <div class="col">
            <div id="home-deccl">
                <h4>지금 올라온 뉴스 + 댓글</h4>
                <div class="masonry">
@foreach ($recentComments as $comment)
                    <div class="masonry-item">
@include('comment._deccl', compact('comment'))
                    </div>
@endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<div class="jumbotron">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>뉴스를 읽는 가장 기발한 방법, {{ env('APP_NAME') }}</h1>
                <p class="lead">뉴스의 댓글만 모아서 보고, 공유하고, 직접 씁니다. 내가 오늘 쓴 댓글이 내일의 뉴스가 되는 곳, {{ env('APP_NAME') }}입니다.</p>
            </div>
        </div>
    </div>
</div>
@endpush