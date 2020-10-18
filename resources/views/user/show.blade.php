@extends('_full')

@section('body')
<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="my-3">안녕하세요, {{ $user->name }}님!</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            @include('user._update_info', compact('user'))
        </div>
        <div class="col-lg-6">
            @include('user._update_password', compact('user'))
        </div>
    </div>
</div>
@endsection