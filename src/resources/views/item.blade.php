@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item.css') }}">
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
    <div class="item__content">
        <div class="item__img">
            <img src="{{-- Storage::url($item->image_path) --}}" alt="{{-- $item->name --}}">
        </div>
        <div class="item__data">
            <div class="item__data--name">
                <h3 class="data__name--txt">商品名{{-- $item->name --}}</h3>
                <p class="data__brand--txt">ブランド名</p>
                <p class="data__price--txt">¥47,000{{-- $item->price --}}(値段)</p>
            </div>
            <div class="item__data--btn">
                <div class="item__data--btn-like">
                    <form action="" method="POST">
                        @csrf
                        <button class="like-btn"><img src="/images/star.png" alt="like"></button>
                    </form>
                    <p class="like-count">3{{-- count($likes) --}}</p>
                </div>
                <div class="item__data--btn-comment">
                    <form action="" method="POST">
                        @csrf
                        <button class="comment-btn"><img src="/images/comment.png" alt="comment"></button>
                    </form>
                    <p class="comment-count">14{{-- count($comments) --}}</p>
                </div>
            </div>
            <div class="item__data--purchase-btn">
                <form action="" method="POST">
                    @csrf
                    <button type="submit" class="data__purchase--btn-btn">購入する</button>
                </form>
            </div>
            <div class="item__data--detail">
                <h4 class="data__detail--ttl">商品説明</h4>
                <p class="data__detail--detail">カラー：グレー<br>
                    <br>
                新品<br>
                商品の状態は良好です。傷もありません。<br>
                    <br>
                購入後、即発送いたします。{{-- $item->detail --}}</p>
            </div>
            <div class="item__data--info">
                <h4 class="data__info--ttl">商品の情報</h4>
                <div class="data__info--table">
                    <table>
                        <tr class="info__row">
                            <th class="info__label">カテゴリー</th>
                            <td class="info__data"><span class="category"> 洋服{{-- $item->category->name --}}</span><span class="category"> メンズ{{-- $item->category->name --}}</span></td>
                        </tr>
                        <tr class="info__row">
                            <th class="info__label">商品の状態</th>
                            <td class="info__data">良好{{-- $item->condition --}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
