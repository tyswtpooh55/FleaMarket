@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase_address.css') }}">
@endsection

@section('content')
    <div class="purchase-address__content">
        <div class="purchase-address__heading">
            <h3 class="heading__ttl">住所の変更</h3>
        </div>
        <div class="address__form">
            <form action="" class="address__form--form">
                @csrf
                <div class="address__form--item">
                    <label for="post-code" class="address__form--label">郵便番号</label>
                    <input type="number" name="post-code" class="address__form--input">
                    @error('post-code')
                    <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="address__form--item">
                    <label for="address" class="address__form--label">住所</label>
                    <input type="text" name="address" class="address__form--input">
                    @error('address')
                    <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="address__form--item">
                    <label for="building" class="address__form--label">建物名</label>
                    <input type="text" name="building" class="address__form--input">
                    @error('building')
                    <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <button class="address__form--btn">更新する</button>
            </form>
        </div>
    </div>
@endsection
