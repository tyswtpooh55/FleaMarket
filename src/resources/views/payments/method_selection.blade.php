@extends('layouts.app')


@section('css')
    <link rel="stylesheet" href="{{ asset('css/payments/method_selection.css') }}">
@endsection


@section('header')

@endsection


@section('content')
    <div class="payment-method__content">
        <div class="payment-method__heading">
            <h3 class="heading__ttl">支払い方法の変更</h3>
        </div>
        <div class="method__form">
            <form action="{{ route('payment.method.select') }}" method="GET" class="method__form--form">
                @csrf
                @foreach ($paymentMethods as $method)
                <div class="method__form--item">
                    <input type="radio" name="method_id" id="method{{ $method->id }}" value="{{ $method->id }}" class="method__form--input" @if ($method->id == 1) checked @endif>
                    <label for="method{{ $method->id }}" class="method__form--label">{{ $method->method }}</label>
                </div>
                @endforeach
                <button class="method__form--btn">更新する</button>
            </form>
        </div>
    </div>
@endsection
