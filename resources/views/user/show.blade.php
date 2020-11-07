@extends('_full')

@push('content')
<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="my-3 d-inline-block">
                {{ $user->proper_name }}
            </h1>
@if (request()->user == $user)
            <a href="{{ route('user.edit', compact('user')) }}">정보 수정</a>
@endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="row">
@if ($user->profile_picture)
                <div class="col-md-4">
                    <img src="{{ $user->profile_picture }}" class="img-thumbnail" />
                </div>
@endif
                <div class="col{{ $user->profile_picture ? '-md-8' : '0' }}">
                    <ul>
                        <li>가입일: {{ $user->created_at->toDateString() }}</li>
                        <li>그동안 쓴 댓글: {{ $user->comments->count() }}개</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
@foreach ($user->comments as $comment)
@include('comment._deccl.full', compact('comment'))
@endforeach
        </div>
    </div>
</div>
@endpush