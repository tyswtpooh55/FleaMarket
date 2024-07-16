@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/comment.css') }}">
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
    <div class="comment__content">
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
            <div class="comment__box">

                <div class="comment__item">
                    <div class="comment__user">
                        <img src="{{-- $comment->user->image_path --}}" alt="" class="comment__user-img">
                        <span class="comment__user-name">名前{{-- $comment->user->name --}}</span>
                    </div>
                    <div class="comment__comment">
                        <p class="comment__writen">コメント{{-- $comment->commnet --}}</p>
                    </div>
                </div>
                <div class="comment__item">
                    <div class="comment__user">
                        <img src="{{-- $comment->user->image_path --}}" alt="" class="comment__user-img">
                        <span class="comment__user-name">名前{{-- $comment->user->name --}}</span>
                    </div>
                    <div class="comment__comment">
                        <p class="comment__written">コメント{{-- $comment->commnet --}}</p>
                    </div>
                </div>


                <div class="comment__item">
                    <div class="comment__auth">
                        <span class="comment__user-name">名前{{-- $comment->user->name --}}</span><img src="{{-- $comment->user->image_path --}}" alt="" class="comment__user-img">
                    </div>
                    <div class="comment__comment">
                        <p class="comment__writen">コメント{{-- $comment->commnet --}}</p>
                    </div>
                </div>


            </div>
            <div class="comment__form">
                <form action="" method="POST" class="comment__form--form">
                    <label for="comment" class="comment__form--label">商品へのコメント</label>
                    <textarea name="comment" class="comment__form--textarea"></textarea>
                    </div>
                    <button type="submit" class="comment__form--btn">コメントを送信する</button>
                </form>
            </div>
        </div>
    </div>
@endsection
