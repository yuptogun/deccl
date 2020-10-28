@extends('_')

@push('body_before')
@include('_layout/gnb')
@endpush

@section('body')
@stack('content')
@include('_layout/footer_simple')
@endsection