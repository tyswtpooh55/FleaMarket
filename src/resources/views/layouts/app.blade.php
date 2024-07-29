<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Coachtech</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">

    @yield('css')
    @livewireStyles
</head>
<body>
    <header class="header">
        @section('header')
        <div class="header__inner">
            <div class="header__ttl">
                <a href="/" class="header__logo"><img src="{{ asset('images/logo.svg') }}" alt="COACHTECH"></a>
            </div>
            <div class="header__search">
                <form action="/item/search" method="GET" class="header__search-form">
                    <input type="text" name="search" placeholder="なにをお探しですか？" class="search-form__input">
                </form>
            </div>
            <div class="header__nav">
                <ul>
                    @if (Auth::check())
                    <li class="header__nav--li">
                        <form action="/logout" method="POST" class="header__nav--form">
                            @csrf
                            <button class="header__nav--btn">ログアウト</button>
                        </form>
                    </li>
                    <li class="header__nav--li">
                        <form action="{{ route('mypage.index') }}" method="GET" class="heaer__nav--form">
                            <button class="header__nav--btn">マイページ</button>
                        </form>
                    </li>
                    @else
                    <li class="header__nav--li">
                        <form action="/login" method="GET" class="header__nav--form">
                            <button class="header__nav--btn">ログイン</button>
                        </form>
                    </li>
                    <li class="header__nav--li">
                        <form action="/register" method="GET" class="heaeder__nav--form">
                            <button class="header__nav--btn">会員登録</button>
                        </form>
                    </li>
                    @endif
                    <li class="header__nav--li">
                        <form action="{{ route('sell') }}" method="GET" class="header__nav--form">
                            <button class="header__nav--sell-btn">出品</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        @show
    </header>
    <main class="main">
        @yield('content')
        @livewireScripts
    </main>
</body>
</html>
