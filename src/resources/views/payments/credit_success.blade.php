@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/payments/credit.css') }}">
@endsection

@section('content')
    <div class="credit__content">
        <h3 class="credit__ttl">購入が完了しました</h3>
        <p class="credit__msg">出品者の発送通知をお待ちください</p>
        <a href="{{ route('index') }}" class="credit__link--top">トップ画面に戻る</a>
    </div>
@endsection
