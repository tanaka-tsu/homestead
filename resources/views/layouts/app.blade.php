<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>勤怠管理</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                @if($authGroup === 'admin')
                    <a class="navbar-brand" href="{{ route('index.admin') }}">
                @elseif($authGroup === 'user')
                    <a class="navbar-brand" href="{{ route('create.kintais') }}">
                @else
                    <a class="navbar-brand" href="{{ route('login') }}">
                @endif
                        勤怠管理
                    </a>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @if(!Auth::check() && (!isset($authgroup) || !Auth::guard($authgroup)->check()))
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">
                                        新規登録
                                    </a>
                                </li>
                            @endif
                            @if (Route::has('login'))
                                <li>
                                    <a class="nav-link" href="{{ route('login') }}">
                                        ログイン
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login.admin') }}">
                                        ＊
                                    </a>
                                </li>
                            @endif
                        @elseif(Auth::check() && $authGroup === 'user')
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="{{ route('create.kintais') }}">
                                    打刻
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="{{ route('show.kintais', Auth::id()) }}">
                                    勤怠表
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="{{ route('show.user', Auth::id()) }}">
                                    マイページ
                                </a>
                            </li>
                            <li>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>

                        @elseif(Auth::check() && $authGroup === 'admin')
                            <li>
                                <a class="nav-link" href="{{ route('index.admin') }}">
                                    社員一覧
                                </a>
                                <a class="nav-link" href="{{ route('show.admin', ['id' => Auth::guard('admin')->user()->id]) }}">
                                    管理者情報
                                </a>
                                <a class="nav-link" href="{{ route('register.admin') }}">
                                    管理者追加
                                </a>
                            </li>
                            <li>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                    Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout.admin') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
