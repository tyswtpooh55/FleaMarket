@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage_profile.css') }}">
@endsection


@section('content')
    <div class="profile__content">
        <div class="profile__heading">
            <h3 class="heading__ttl">プロフィール設定</h3>
        </div>
        <div class="profile__form">
            <form action="{{ route('mypage.profile.update') }}" method="POST" enctype="multipart/form-data" class="profile__form--form">
                @csrf

                @livewire('profile-img', ['nowImgUrl' => $profile ? $profile->img_url : null])

                <div class="profile__form--item">
                    <label for="name" class="profile__form--label">ユーザー名</label>
                    <input type="text" name="name" class="profile__form--input" value="{{ $user->name ?? '' }}">
                </div>
                <div class="profile__form--item">
                    <label for="postcode" class="profile__form--label">郵便番号</label>
                    <input type="text" inputmode="numeric" pattern="\d{3}-?\d{4}" name="postcode" class="profile__form--input" value="{{ $profile ? $profile->postcode : '' }}">
                </div>
                <div class="profile__form--item">
                    <label for="address" class="profile__form--label">住所</label>
                    <input type="text" name="address" class="profile__form--input" value="{{ $profile ? $profile->address : '' }}">
                </div>
                <div class="profile__form--item">
                    <label for="building" class="profile__form--label">建物名</label>
                    <input type="text" name="building" class="profile__form--input" value="{{ $profile ? $profile->building : '' }}">
                </div>
                <button class="profile__form--btn">更新する</button>
            </form>
        </div>
    </div>
@endsection
