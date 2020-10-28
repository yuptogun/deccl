@extends('comment._')

@section('title', $comment->info)
@section('desc', strip_tags($comment->summary))

@push('head_meta')
<meta property="article:author" content="{{ $comment->user->name }}" />
<meta property="article:published_time" content="{{ $comment->created_at }}" />
@endpush

@push('content')
<div class="container">
    <div class="row mt-3 mb-5">
        @include('comment._deccl.full', compact('comment'))
    </div>
</div>
@endpush