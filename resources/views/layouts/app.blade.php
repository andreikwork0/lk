<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">





        <main class="">
            <div class="d-flex">
                @auth
                    @include('inc.sidebar')
                @endauth
                <div class="wrap" style="width: 100%">
                    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm noprint">
                        <div class="container">
                            @guest
                            <a class="navbar-brand" href="{{ url('/') }}">
                                {{ config('app.name', 'Laravel') }}
                            </a>
                            @endguest
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <!-- Left Side Of Navbar -->
                                <ul class="navbar-nav me-auto">
                                </ul>

                                <!-- Right Side Of Navbar -->
                                <ul class="navbar-nav ms-auto">
                                    <!-- Authentication Links -->
                                    @guest
                                        @if (Route::has('login'))
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                            </li>
                                        @endif

                                        @if (Route::has('register'))
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                            </li>
                                        @endif
                                    @else
                                        <li class="nav-item">
                                            <span class="nav-link  " href="" aria-expanded="false">
                                                СНИЛС: {{ Auth::user()->perscode ?  Auth::user()->perscode : 'не найден' }}
                                            </span>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                               data-bs-toggle="dropdown" aria-expanded="false">
                                                {{ Auth::user()->name }}

                                            </a>


                                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                        {{ __('Logout') }}
                                                    </a>
                                                </li>

                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                    @csrf
                                                </form>
                                            </ul>
                                        </li>

                                    @endguest
                                </ul>
                            </div>
                        </div>
                    </nav>

                    @yield('page-title')
                    @include('inc.messages')

                    @auth
                    @if(Auth::user()->perscode)
                        @yield('content')
                    @else
                        <div class="container">
                            <p>В системе не найден Ваш персональный идентификатор.</p>
                            <p>Сообщите о проблеме в отдел сетей и телекоммуникаций УИТ и АСУ по адресу: пр-т Ленина, 38, каб. 146 или по телефону +7(3519)29-84-74.</p>
                        </div>
                    @endif
                    @endauth

                    @guest
                        @yield('content')
                    @endguest
                </div>

            </div>

        </main>
    </div>
    <x-modal-delete />
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" ></script>
</body>
</html>
