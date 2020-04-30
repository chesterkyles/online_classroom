<!DOCTYPE html>
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/KaTeX/0.7.1/katex.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @yield('head-scripts')

    <style>
        body { padding-top: 75px; }
    </style>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md fixed-top navbar-light bg-white shadow-sm font-weight-bolder">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @if ($user = Auth::user())
                            <li class="nav-item mx-1">
                                <a class="nav-link btn btn-light rounded-pill px-3 shadow-sm" href="{{ route($user->account_type . '.home', $user->getAccountType()) }}">
                                    <i class="fa fa-home"></i><div class="ml-1 d-none d-lg-inline">{{ __('Home') }}</div>
{{--                                   d-none d-lg-inline--}}
                                </a>
                            </li>
                            <li class="nav-item mx-1">
                                <a class="nav-link btn btn-light rounded-pill px-3 shadow-sm" href="{{ route($user->account_type . '.subject.index', $user->getAccountType()) }}">
                                    <i class="fa fa-users"></i><div class="ml-1 d-none d-lg-inline">{{ __('Classes') }}</div>
                                </a>
                            </li>
                            <li class="nav-item mx-1">
                                <a class="nav-link btn btn-light rounded-pill px-3 shadow-sm" href="{{ route($user->account_type . '.exam.index', $user->getAccountType()) }}">
                                    <i class="fa fa-pencil"></i><div class="ml-1 d-none d-lg-inline">{{ __('Exams') }}</div>
                                </a>
                            </li>
                            <li class="nav-item mx-1">
                                <a class="nav-link btn btn-light rounded-pill px-3 shadow-sm" href="#">
                                    <i class="fa fa-book"></i><div class="ml-1 d-none d-lg-inline">{{ __('Notes') }}</div>
                                </a>
                            </li>
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        @if($user = Auth::user())
                            <li class="nav-item dropdown d-flex mt-2">
                                <div class="dropdown">
                                    <a class="btn px-1" type="button" id="messages" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-envelope fa-lg">
                                            <span class="font-weight-normal badge badge-light badge-pill text-danger">
                                                {{ __('0') }}
                                            </span>
                                        </i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-left" aria-labelledby="messages">
                                        <div class="d-flex bg-light">
                                            <label class="small text-muted ml-4 my-1">{{ __('Messages') }}</label>
                                        </div>
                                        <a class="dropdown-item" href="#" disabled>{{ __('UNDER CONSTRUCTION!') }}</a>
                                    </div>
                                </div>

                                <div class="dropdown mr-3">
                                    <a class="btn px-1" type="button" id="notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-bell fa-lg">
                                            <span class="font-weight-normal badge badge-light badge-pill text-danger">
                                                {{ __('0') }}
                                            </span>
                                        </i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-left" aria-labelledby="notification">
                                        <div class="d-flex bg-light">
                                            <label class="small text-muted ml-4 my-1">{{ __('Notifications') }}</label>
                                        </div>
                                        <a class="dropdown-item" href="#" disabled>{{ __('UNDER CONSTRUCTION!') }}</a>
                                    </div>
                                </div>

                                <label class="navbar-text font-weight-bold">{{ Str::title($user->account_type) }}</label>
                                <div class="dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <strong> {{ $user->account_number }}</strong> <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <div class="d-flex bg-secondary">
                                            <label class="text-light ml-4 my-1 font-weight-bolder">{{ $user->firstname }}</label>
                                        </div>
                                        <a class="dropdown-item" href="{{ route($user->account_type . '.subject.viewAll', $user->getAccountType() ?: '') }}">
                                            {{ __('View All Classes') }}
                                        </a>
{{--                                        <a class="dropdown-item" href="{{ route($user->account_type . '.exam.viewAll', $user->getAccountType() ?: '') }}">--}}
                                        <a class="dropdown-item" href="#">
                                            {{ __('View All Examinations') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </li>
                        <!-- Authentication Links -->
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

{{--        TOAST MESSAGES: --}}
{{--        <div class="position-fixed w-100 d-flex flex-column p-4" style="z-index: 1030; pointer-events: none;">--}}
{{--            <div class="toast ml-auto" role="alert" style="pointer-events: auto;">--}}
{{--                <div class="toast-header">--}}
{{--                    <strong class="mr-auto text-primary">Message</strong>--}}
{{--                    <small class="text-muted">a few seconds ago</small>--}}
{{--                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">--}}
{{--                        <span aria-hidden="true">×</span>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--                <div class="toast-body"> THIS MESSAGE IS FOR NOTIFICATION. UNDER CONSTRUCTION! </div>--}}
{{--            </div>--}}
{{--        </div>--}}

        <main class="py-4">
            @yield('content')
        </main>

    </div>

    <!-- Scripts -->
{{--    <script src="{{ asset('js/app.js') }}"></script> --}}
{{--    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script>
        $(".toast").toast({
            animation: true,
            delay: 10000,
        }).toast('show');
    </script>
    @yield('scripts')
</body>
</html>
