@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('header')
<div class="header__inner">
    <div class="header__ttl">
        <a href="/" class="header__logo"><img src="{{ asset('images/logo.svg') }}" alt="COACHTECH"></a>
    </div>
    <div class="header__search">
        <input type="text" placeholder="なにをお探しですか？" class="search-form__input">
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
                <form action="/mypage" method="GET" class="heaer__nav--form">
                    @csrf
                    <button class="header__nav--btn">マイページ</button>
                </form>
            </li>
            @else
            <li class="header__nav--li">
                <form action="/login" method="GET" class="header__nav--form">
                    @csrf
                    <button class="header__nav--btn">ログイン</button>
                </form>
            </li>
            <li class="header__nav--li">
                <form action="/register" method="GET" class="heaeder__nav--form">
                    @csrf
                    <button class="header__nav--btn">会員登録</button>
                </form>
            </li>
            @endif
            <li class="header__nav--li">
                <form action="/sell" method="GET" class="header__nav--form">
                    @csrf
                    <button class="header__nav--sell-btn">出品</button>
                </form>
            </li>
        </ul>
    </div>
</div>
@endsection

@section('content')
    <div class="mypage__content">
        <div class="mypage__heading">
            <div class="user__info">
                <div class="user__img">
                    <img src="/images/star.png" alt="" class="user__img--img"></div>
                <div class="user__name">
                    <h3 class="user__name--name">ユーザー名{{-- $user->name --}}</h3>
                </div>
            </div>
            <div class="edit__profile">
                <a href="" class="edit__profile--btn">プロフィールを編集</a>
            </div>
        </div>

        @livewire('mypage')

    </div>
@endsection
