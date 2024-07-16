@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage_profile.css') }}">
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
    <div class="profile__content">
        <div class="profile__heading">
            <h3 class="heading__ttl">プロフィール設定</h3>
        </div>
        <div class="profile__form">
            <form action="" class="profile__form--form">
                <div class="profile__img">
                    <div class="profile__img--icon">
                        <img src="" alt="" class="profile__img--icon-img">
                    </div>
                    <div class="profile__img--select">
                        <a href="" class="profile__img--select-link">画像を選択する</a>
                    </div>
                </div>
                <div class="profile__form--item">
                    <label for="name" class="profile__form--label">ユーザー名</label>
                    <input type="text" name="name" class="profile__form--input">
                </div>
                <div class="profile__form--item">
                    <label for="post-code" class="profile__form--label">郵便番号</label>
                    <input type="number" name="post-code" class="profile__form--input">
                </div>
                <div class="profile__form--item">
                    <label for="address" class="profile__form--label">住所</label>
                    <input type="text" name="address" class="profile__form--input">
                </div>
                <div class="profile__form--item">
                    <label for="building" class="profile__form--label">建物名</label>
                    <input type="text" name="building" class="profile__form--input">
                </div>
                <button class="profile__form--btn">更新する</button>
            </form>
        </div>
    </div>
@endsection
