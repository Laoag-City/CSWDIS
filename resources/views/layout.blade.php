<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    <link href="/semantic/dist/semantic.min.css" rel="stylesheet">
    <link href="{{ mix('css/globals.css') }}" rel="stylesheet">
    @yield('custom_css')
</head>
<body>
    @auth

    @endauth

    <div class="ui sidebar inverted vertical menu">
        <a class="item">
            1
        </a>
        <a class="item">
            2
        </a>
        <a class="item">
            3
        </a>
    </div>

    <div class="pusher">
        <p>awef</p>
    </div>

    @yield('main_content')
</body>

<script src="{{ mix('js/app.js') }}"></script>
<script src="/semantic/dist/semantic.min.js"></script>
@yield('custom_js')
</html>
