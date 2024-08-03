@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection


@section('content')
    <div class="mypage__content">
        <div class="mypage__heading">
            <div class="user__info">
                <div class="user__img">
                    @if ($user->img_url)
                    <img src="{{ Storage::url($user->img_url) }}" alt="" class="user__img--img">
                    @endif
                </div>
                <div class="user__name">
                    <h3 class="user__name--name">{{ $user->name }}</h3>
                </div>
            </div>
            <div class="edit__profile">
                <a href="{{ route('mypage.profile') }}" class="edit__profile--btn">プロフィールを編集</a>
            </div>
        </div>

        @livewire('mypage')

    </div>
@endsection
