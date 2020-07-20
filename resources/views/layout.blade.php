<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }} | CSWDIS</title>

    <link href="/semantic/dist/semantic.min.css" rel="stylesheet">
    <link href="{{ mix('css/globals.css') }}" rel="stylesheet">
    <style>
        .text_center
        {
            text-align: center !important;
        }

        .block_center
        {
            width: 100%;
            margin: auto;
        }
    </style>
    @yield('custom_css')
</head>
<body>
    @auth
        @php
            if(Auth::user()->is_admin)
                $user_level = '(Admin)';
            elseif(Auth::user()->is_confidential_accessor)
                $user_level = '(Confidential Records User)';
            else
                $user_level = '(Regular User)';
        @endphp

    <div class="ui sidebar inverted vertical menu">
        <a class="item" href="#" title="{{ Auth::user()->username }} {{ $user_level }}">
            <i class="user icon"></i>
            Logged in as...
        </a>

        <a class="item" href="{{ route('home') }}">
            <i class="add icon"></i>
            New Client Record
        </a>

        <a class="item" href="{{ route('client_list') }}">
            <i class="list icon"></i>
            Client List
        </a>

        <a class="item" href="{{ route('stats') }}">
            <i class="chart bar icon"></i>
            Stats
        </a>

        @if(Auth::user()->is_admin)
            <a class="item" href="{{ route('logs') }}">
                <i class="table icon"></i>
                Logs
            </a>

            <a class="item" href="{{ route('users_dashboard') }}">
                <i class="users icon"></i>
                User Dashboard
            </a>
        @endif

        @if(Auth::user()->is_admin || Auth::user()->is_confidential_accessor)
            <a class="item" href="{{ route('services_dashboard') }}">
                <i class="hands helping icon"></i>
                Service Dashboard
            </a>
        @endif

        <a class="item"  href="#" onclick="event.preventDefault(); document.getElementById('logout_form').submit();">
            <i class="sign out icon"></i>
            Log Out
        </a>

        <form id="logout_form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
    @endauth

    <div class="pusher">
        <div class="ui container" style="padding-top: 10px;">
            <div class="ui padded segment">
                <h1 class="ui header" style="margin: 0px 0px 8px 15px">{{ $title }}</h1>
                <div class="ui divider" style="margin-top: 0px;"></div>

                <div id="main" class="ui stackable centered grid">
                    @yield('main_content')
                </div>
            </div>
        </div>
    </div>
</body>

<script src="{{ mix('js/app.js') }}"></script>
<script src="/semantic/dist/semantic.min.js"></script>
@yield('custom_js')
</html>
