@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/payments/credit.css') }}">
@endsection

@section('content')
    <div class="credit__content">
        <p class="credit__msg">支払いがキャンセルされました。</p>
        <p class="credit__msg">はじめからやり直してください。</p>
        <a href="{{ route('index') }}" class="credit__link--top">トップ画面に戻る</a>
    </div>
@endsection

