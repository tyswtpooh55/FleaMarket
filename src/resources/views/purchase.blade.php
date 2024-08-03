@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection


@section('content')
    <div class="purchase__content">
        <div class="purchase__order">
            <div class="purchase__item">
                <div class="item__img">
                    @if ($item->itemImages->isNotEmpty())
                    <img src="{{ Storage::url($item->itemImages->first()->img_url) }}" alt="{{ $item->name }}" class="item__img--img">
                    @else
                    <div class="item__img--none">
                        <span class="item__img--none-txt">No Image</span>
                    </div>
                    @endif
                </div>
                <div class="item__data">
                    <p class="item__name">{{ $item->name }}</p>
                    <p class="item__price">¥{{ number_format($item->price) }}</p>
                </div>
            </div>
            <div class="purchase__option">
                <p class="option__ttl">支払い方法</p>
                <a href="{{ route('payment.method') }}" class="option__link">変更する</a>
            </div>
            <div class="purchase__option">
                <p class="option__ttl">配送先</p>
                <a href="{{ route('purchase.address') }}" class="option__link">変更する</a>
            </div>
        </div>
        <div class="purchase__payment">
            <div class="payment__box">
                <table class="payment__table">
                    <tr class="payment__row">
                        <th class="payment__label">商品代金</th>
                        <td class="payment__data">¥{{ number_format($item->price) }}</td>
                    </tr>
                    <tr class="payment__row">
                        <th class="payment__label"></th>
                        <td class="payment__data"></td>
                    </tr>
                    <tr class="payment__row">
                        <th class="payment__label">支払い金額</th>
                        <td class="payment__data">¥{{ number_format($item->price) }}</td>
                    </tr>
                    <tr class="payment__row">
                        <th class="payment__label">支払い方法</th>
                        <td class="payment__data">{{ $method->method }}</td>
                    </tr>
                </table>
            </div>
            <div class="payment__form">
                <form action="{{ route('payment.stripe') }}" method="POST">
                    @csrf
                    <button type="submit" class="payment__btn">購入する</button>
                </form>
            </div>
        </div>
    </div>
@endsection
