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
    <link rel="apple-touch-icon" sizes="57x57" href="{{ url('images/favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ url('images/favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ url('images/favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ url('images/favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ url('images/favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ url('images/favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ url('images/favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ url('images/favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('images/favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ url('images/favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ url('images/favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('images/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ url('images/favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ url('images/favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">
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