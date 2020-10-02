@extends('_full')

@section('body')
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
<div class="container">
    <div class="row">
        <div class="col">
            지금 올라온 뉴스 + 댓글
        </div>
    </div>
</div>
@endsection