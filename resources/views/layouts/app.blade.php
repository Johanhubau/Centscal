<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Centscal') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <v-app>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    {{ config('app.name', 'Centscal') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false"
                        aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            @if (Auth::user()->isAdmin())
                                <li class="nav-item">
                                    <a class="nav-link"
                                       href="{{ route('admin.associations') }}">{{ __('Associations') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.users') }}">{{ __('Users') }}</a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('associations') }}">{{ __('Associations') }}</a>
                                </li>
                                @if (count(Auth::user()->president_associations) != 0)
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            {{__('My associations')}}<span class="caret"></span>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                            @foreach(Auth::user()->president_associations as $association)
                                                <a class="dropdown-item"
                                                   href="{{ url('/association/'.$association->id) }}">
                                                    {{ $association->name }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </li>
                                    @foreach(Auth::user()->president_associations as $association)
                                        @if (count($association->rents->where('approved', 0)) != 0)
                                            <li class="nav-item dropdown">
                                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                    {{__('Pending Rents')}}<span class="caret"></span>
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                                    @foreach(Auth::user()->president_associations as $association)
                                                        @if (count($association->rents->where('approved', 0)) != 0)
                                                        <a class="dropdown-item"
                                                           href="{{ url('/association/'.$association->id.'/rents') }}">
                                                            {{ $association->name }}
                                                        </a>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </li>
                                            @break
                                        @endif
                                    @endforeach
                                    @foreach(Auth::user()->president_associations as $association)
                                        @if (count($association->occupations->where('approved', 0)) != 0)
                                            <li class="nav-item dropdown">
                                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                    {{__('Pending Occupations')}}<span class="caret"></span>
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                                    @foreach(Auth::user()->president_associations as $association)
                                                        @if (count($association->occupations->where('approved', 0)) != 0)
                                                            <a class="dropdown-item"
                                                               href="{{ url('/association/'.$association->id.'/occupations') }}">
                                                                {{ $association->name }}
                                                            </a>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </li>
                                            @break
                                        @endif
                                    @endforeach
                                @endif
                            @endif
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->first_name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4 fill-height">
            <v-content class="fill-height">
                @yield('content')
            </v-content>
        </main>
    </v-app>
</div>
</body>
</html>
