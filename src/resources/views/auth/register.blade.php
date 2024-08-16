@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('header')
    <div class="header__inner">
        <div class="header__ttl">
            <a href="/" class="header__logo"><img src="{{ asset('images/logo.svg') }}" alt="COACHTECH"></a>
        </div>
    </div>
@endsection

@section('content')
    <div class="auth__content">
            <h2 class="heading__ttl">会員登録</h2>
        <div class="auth__form">
            <form action="/register" method="POST" class="auth__form-form">
                @csrf
                <div class="auth__form--item">
                    <label for="email" class="auth__form--label">メールアドレス</label>
                    <input type="email" name="email" class="auth__form--input">
                    @error('email')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="auth__form--item">
                    <label for="password" class="auth__form--label">パスワード</label>
                    <input type="password" name="password" class="auth__form--input">
                    @error('password')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <button class="auth__form--btn">登録する</button>
            </form>
            <a href="/login" class="auth__link">ログインはこちら</a>
        </div>
    </div>
@endsection
