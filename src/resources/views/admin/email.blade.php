@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/email.css') }}">
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
            <li class="header__nav--li">
                <form action="{{ route('admin.index') }}" method="GET" class="heaeder__nav--form">
                    <button class="header__nav--btn">管理TOP</button>
                </form>
            </li>
        </ul>
    </div>
</div>
@endsection

@section('content')
<div class="admin-email__content">
    <h3 class="admin-email__header--ttl">メール送信</h3>
    <div class="alert">
        @if (session('success'))
        <p class="success">{{ session('success') }}</p>
        @endif
        @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
            <li class="error">{{ $error }}</li>
            @endforeach
        </ul>
        @endif
    </div>
    <form action="{{ route('admin.send.email') }}" method="POST" class="email__form">
        @csrf
        <div class="email__content">
            @livewire('email-recipients-select')

            <div class="writing__box">
                <label for="subject" class="email__label">Subject</label>
                <input type="text" name="subject" id="subject" class="email__sub--input">
            </div>
            <div class="writing__box">
                <label for="message" class="email__label">Message</label>
                <textarea name="message" id="message" class="email__msg--textarea"></textarea>
            </div>
            <div class="sending__btn">
                <button type="submit" class="sending__btn--btn">送 信</button>
            </div>
        </div>
    </form>

</div>
@endsection
