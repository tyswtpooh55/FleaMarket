@extends('layouts.app')


@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase_address.css') }}">
@endsection


@section('header')

@endsection


@section('content')
    <div class="purchase-address__content">
        <div class="purchase-address__heading">
            <h3 class="heading__ttl">住所の変更</h3>
        </div>
        <div class="address__form">
            <form action="{{ route('purchase.address.update') }}" method="POST" class="address__form--form">
                @csrf
                <div class="address__form--item">
                    <label for="postcode" class="address__form--label">郵便番号</label>
                    <input type="text" inputmode="numeric" pattern="\d{3}-?\d{4}" name="postcode" class="address__form--input" value="{{ $profile ? $profile->postcode : '' }}">
                    @error('postcode')
                    <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="address__form--item">
                    <label for="address" class="address__form--label">住所</label>
                    <input type="text" name="address" class="address__form--input" value="{{ $profile ? $profile->address : '' }}">
                    @error('address')
                    <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="address__form--item">
                    <label for="building" class="address__form--label">建物名</label>
                    <input type="text" name="building" class="address__form--input" value="{{ $profile ? $profile->building : '' }}">
                    @error('building')
                    <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <button class="address__form--btn">更新する</button>
            </form>
        </div>
    </div>
@endsection
