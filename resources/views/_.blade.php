<!DOCTYPE html>
<html lang="en">
<head>
    @stack('head_before')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ (isset($title) ? $title.' :: ' : '').env('APP_NAME') }}</title>
    <meta property="og:site_name" content="{{ env('APP_NAME') }}" />
    <meta property="og:url" content="{{ app('url')->current() }}" />
    <meta property="og:title" content="@yield('title', isset($title) ? $title : env('APP_NAME'))" />
    <meta property="og:description" content="@yield('desc', isset($desc) ? $desc : '여러분의 뉴스 평론 놀이터, '.env('APP_NAME'))" />
@if (isset($image) && $image)
    <meta property="og:image" content="{{ $image }}" />
@endif
    @stack('head_meta')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;700&family=Noto+Sans+KR:wght@300;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ mix('css/deccl.css') }}">
    @stack('styles')
    @stack('scripts')
    @stack('head_after')
</head>
<body>
    @stack('body_before')
    @section('body')
    @show
    <script src="{{ mix('js/deccl.js') }}"></script>
    @stack('body_after')
</body>
</html>