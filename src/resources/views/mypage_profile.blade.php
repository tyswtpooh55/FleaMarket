@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage_profile.css') }}">
@endsection


@section('content')
    <div class="profile__content">
        <h3 class="heading__ttl">プロフィール設定</h3>
        <div class="profile__form">
            <form action="{{ route('mypage.profile.update') }}" method="POST" enctype="multipart/form-data" class="profile__form--form">
                @csrf

                @livewire('profile-img', ['nowImgUrl' => $user->img_url ?? null])

                <div class="profile__form--item">
                    <label for="name" class="profile__form--label">ユーザー名</label>
                    <input type="text" name="name" class="profile__form--input" value="{{ $user->name ?? '' }}">
                    @error('name')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="profile__form--item">
                    <label for="postcode" class="profile__form--label">郵便番号</label>
                    <input type="text" inputmode="numeric" pattern="\d{3}-?\d{4}" name="postcode" class="profile__form--input" value="{{ $profile ? $profile->postcode : '' }}">
                    @error('postcode')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="profile__form--item">
                    <label for="address" class="profile__form--label">住所</label>
                    <input type="text" name="address" class="profile__form--input" value="{{ $profile ? $profile->address : '' }}">
                    @error('address')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="profile__form--item">
                    <label for="building" class="profile__form--label">建物名</label>
                    <input type="text" name="building" class="profile__form--input" value="{{ $profile ? $profile->building : '' }}">
                    @error('building')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <button class="profile__form--btn">更新する</button>
            </form>
        </div>
    </div>
@endsection
