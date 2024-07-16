@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
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
    <div class="purchase__content">
        <div class="purchase__order">
            <div class="purchase__item">
                <div class="item__img">
                    <img src="{{-- Storage::url($item->image_path) --}}" alt="{{-- $item->name --}}">
                </div>
                <div class="item__data">
                    <p class="item__name">商品名{{-- $item->name --}}</p>
                    <p class="item__price">¥47,000{{-- $item->price --}}</p>
                </div>
            </div>
            <div class="purchase__option">
                <p class="option__ttl">支払い方法</p>
                <a href="" class="option__link">変更する</a>
            </div>
            <div class="purchase__option">
                <p class="option__ttl">配送先</p>
                <a href="" class="option__link">変更する</a>
            </div>
        </div>
        <div class="purchase__payment">
            <div class="payment__box">
                <table class="payment__table">
                    <tr class="payment__row">
                        <th class="payment__label">商品代金</th>
                        <td class="payment__data">¥47,000{{-- $item->price --}}</td>
                    </tr>
                    <tr class="payment__row">
                        <th class="payment__label"></th>
                        <td class="payment__data"></td>
                    </tr>
                    <tr class="payment__row">
                        <th class="payment__label">支払い金額</th>
                        <td class="payment__data">¥47,000{{-- $item->price --}}</td>
                    </tr>
                    <tr class="payment__row">
                        <th class="payment__label">支払い方法</th>
                        <td class="payment__data">コンビニ払い</td>
                    </tr>
                </table>
            </div>
            <div class="payment__form">
                <form action="" method="POST">
                    @csrf
                    <button type="submit" class="payment__btn">購入する</button>
                </form>
            </div>
        </div>
    </div>
@endsection
