@extends('_full')

@push('content')
<div class="container">
    <div class="row">
        <div class="col">
            <h2 class="my-3">{{ $user->name }}님 정보 수정</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            @include('user._update_property', compact('user'))
            @include('user._update_info', compact('user'))
        </div>
        <div class="col-lg-6">
            @include('user._update_password', compact('user'))
        </div>
    </div>
</div>
@endpush