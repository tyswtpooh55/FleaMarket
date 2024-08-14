@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/user_management.css') }}">
@endsection

@section('header')
    <div class="header__inner">
        <div class="header__ttl">
            <a href="/" class="header__logo"><img src="{{ asset('images/logo.svg') }}" alt="COACHTECH"></a>
        </div>
        <div class="header__nav">
            <ul>
                <li class="header__nav--li">
                    <form action="/logout" method="POST" class="header__nav--form">
                        @csrf
                        <button class="header__nav--btn">ログアウト</button>
                    </form>
                </li>
                <li class="header__nav--li">
                    <form action="{{ route('mypage.index') }}" method="GET" class="heaer__nav--form">
                        <button class="header__nav--btn">マイページ</button>
                    </form>
                </li>
                <li class="header__nav--li">
                    <form action="{{ route('admin.index') }}" method="GET" class="heaeder__nav--form">
                        <button class="header__nav--btn">管理TOP</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="user-manage__content">
        <div class="user-manage__header">
            <h3 class="user-manage__header--ttl">利用者一覧</h3>
        </div>
        <div class="users__table">
            <table class="users__table--table">
                <tr class="users__row">
                    <th class="user__label">
                        ユーザー名
                    </th>
                    <th class="user__label">
                        メールアドレス
                    </th>
                    <th class="user__label">
                        出品数
                    </th>
                    <th class="user__label">
                        売却品数
                    </th>
                    <th class="user__label">
                        購入数
                    </th>
                    <th class="user__label">
                        会員登録日
                    </th>
                    <th class="user__label">
                        {{-- 削除ボタン --}}
                    </th>
                </tr>
                @foreach ($users as $user)
                <tr class="users__row">
                    <td class="user__data">
                        {{ $user->name }}
                    </td>
                    <td class="user__data">
                        {{ $user->email }}
                    </td>
                    <td class="user__data">
                        {{ $user->items->count() }}
                    </td>
                    <td class="user__data">
                        {{ $user->items->filter(function($item) { return $item->transaction->count() > 0; })->count() }}
                    </td>
                    <td class="user__data">
                        {{ $user->transactions->count() }}
                    </td>
                    <td class="user__data">
                        {{ $user->created_at->format('Y-m-d') }}
                    </td>
                    <td class="user__data">
                        <form action="{{ route('admin.delete.user', $user->id) }}" method="post" class="user__delete--form">
                            @csrf
                            <button class="user__delete--btn">削除</button>
                        </form>
                    </td>
                </tr>
                @endforeach

            </table>
        </div>
        <div class="pagination">
            {{ $users->links('vendor.pagination.default') }}
        </div>
    </div>
@endsection
