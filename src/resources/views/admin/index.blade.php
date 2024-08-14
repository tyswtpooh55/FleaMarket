@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/index.css') }}">
@endsection

@section('header')
    <div class="header__inner">
        <div class="header__ttl">
            <a href="/" class="header__logo"><img src="{{ asset('images/logo.svg') }}" alt="COACHTECH"></a>
        </div>
        <div class="header__nav">
            <ul>
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
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="admin__content">
        <div class="admin__header">
            <h3 class="admin__header--ttl">管理者ページ</h3>
        </div>
        <div class="admin__index">
            <ul>
                <li class="admin__li">
                    <form action="{{ route('admin.users') }}" method="GET" class="admin__form">
                        <button type="submit" class="admin__btn">
                            ユーザー管理
                        </button>
                    </form>
                </li>
                <li class="admin__li">
                    <form action="{{ route('admin.write.email') }}" method="GET" class="admin__form">
                        <button type="submit" class="admin__btn">メール送信</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
@endsection
