@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
    <div class="sell__content">
        <div class="sell__heading">
            <h2 class="sell__heading--ttl">商品の出品</h2>
        </div>
        <div class="sell__form">
            <form action="" method="POST" class="sell__form--form">
                @csrf
                <div class="sell__form--item">
                    <label for="image_path" class="sell__form--label">商品の画像</label>
                    <div class="sell__form--img">
                        <button class="sell__form--img-btn">画像を選択する</button>
                    </div>
                </div>
                <div class="sell__form--ttl">
                    <h3>商品の詳細</h3>
                    <div class="sell__form--line"></div>
                </div>
                <div class="sell__form--item">
                    <label for="category" class="sell__form--label">カテゴリー</label>
                    <input type="text" name="category" class="sell__form--input">
                </div>
                <div class="sell__form--item">
                    <label for="condition" class="sell__form--label">商品の状態</label>
                    <input type="text" name="condition" class="sell__form--input">
                </div>
                <div class="sell__form--ttl">
                    <h3>商品名と説明</h3>
                    <div class="sell__form--line"></div>
                </div>
                <div class="sell__form--item">
                    <label for="name" class="sell__form--label">商品名</label>
                    <input type="text" name="name" class="sell__form--input">
                </div>
                <div class="sell__form--item">
                    <label for="detail" class="sell__form--label">商品の説明</label>
                    <textarea name="detail" class="sell__form--textarea"></textarea>
                </div>
                <div class="sell__form--ttl">
                    <h3>販売価格</h3>
                    <div class="sell__form--line"></div>
                </div>
                <div class="sell__form--item">
                    <label for="price" class="sell__form--label">販売価格</label>
                    <div class="sell__form--price">
                        <input type="number" name="price" class="sell__form--input">
                    </div>
                </div>
                <button class="sell__form--btn">出品する</button>
            </form>
        </div>
    </div>
@endsection
