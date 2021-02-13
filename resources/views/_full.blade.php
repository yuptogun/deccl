@extends('_')

@push('body_before')
@include('_layout/gnb')
@endpush

@section('body')
@stack('content')
@include('_layout/footer_simple')
@if (!(request()->is('comment/create') || request()->is('comment/*/edit')))
    @include('_layout/button_create_comment')
@endif
@endsection