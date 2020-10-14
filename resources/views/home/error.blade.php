@extends('_full')

@push('styles')
<style>
html, body {
    width: 100%;
    height: 100%;
}
</style>
@endpush

@section('body')
<div class="d-flex h-100 justify-content-center align-items-center">
    <div class="text-center">
        <h2 class="display-4">{{ $error }}</h2>
    </div>
</div>
@endsection