<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">

        <nav class="nav">
            <div class="nav__wrapper">
                <div class="nav__brand"><a href="{{ url('/') }}">{{ config('app.name') }}</a></div>
                <div class="nav__navicon"></div>
                <div class="nav__links__wrapper nav__links--right">
                    <ul class="nav__links">
                    @guest
                        <li class="nav__links__item"><a href="{{ route('login') }}">{{ __('Login') }}</a></li>
                        <li class="nav__links__item"><a href="{{ route('register') }}">{{ __('Register') }}</a></li>

                    @else
                        <li class="nav__links__item nav__links__item--dropdown">
                        <a href="#">{{ Auth::user()->name }}</a>
                        <ul class="nav__links">
                            <li class="nav__links__item"><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a></li>
                        </ul>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>

                    @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="main">
            @yield('content')
        </main>


    </div><!-- #app -->
</body>
</html>
