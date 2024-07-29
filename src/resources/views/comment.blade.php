@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/comment.css') }}">
@endsection

@section('content')
    <div class="comment__content">
        <div class="item__img">




{{--
            @if ($item->itemImages->isNotEmpty())
                @foreach ($item->itemImages as $image)
                    <img src="{{ Storage::url($image->img_url) }}" alt="{{ $item->name }}" class="item__img--img">
                @endforeach
            @else
            <div class="item__img--none">
                <span class="item__img--none-txt">No Image</span>
            </div>
            @endif
 --}}


        </div>
        <div class="item__data">
            <div class="item__data--name">
                <h3 class="data__name--txt">{{ $item->name }}</h3>
                <p class="data__brand--txt">{{ $item->brand }}</p>
                <p class="data__price--txt">¥{{ number_format($item->price) }}</p>
            </div>
            <div class="item__data--btn">
                @if (Auth::check())

                @livewire('like-toggle', ['itemId' => $item->id])

                @else

                <div class="item__data--btn-like">
                    <img src="/images/star.png" alt="like" class="like__img">
                    <p class="like-count">{{ $countLikes }}</p>
                </div>

                @endif
                <div class="item__data--btn-comment">
                    <a href="{{ route('comment', $item->id) }}">
                        <button class="comment-btn"><img src="/images/comment.png" alt="comment" class="comment__img"></button>
                    </a>
                    <p class="comment-count">{{ $countComments }}</p>
                </div>
            </div>
            <div class="comment__box">
                @if ($comments->isNotEmpty())
                    @foreach ($comments as $comment)
                        @if ($comment->user_id == $item->seller_id)
                        {{-- アイコン右 --}}
                        <div class="comment__item">
                            <div class="comment__seller">
                                @if ($comment->user->name)
                                <span class="comment__user-name">{{ $comment->user->name }}</span>
                                @else
                                <span class="comment__user-name">Unknown</span>
                                @endif
                                @if ($comment->user->img_url)
                                <img src="{{ Storage::url($comment->user->img_url)}}" alt="icon" class="comment__user-img">
                                @else
                                <img src="/images/person.png" alt="icon" class="comment__user-img">
                                @endif
                            </div>
                            <div class="comment__comment">
                                <p class="comment__writen">{{ $comment->comment }}</p>
                            </div>
                        </div>
                        @else
                        {{-- アイコン左 --}}
                        <div class="comment__item">
                            <div class="comment__user">
                                @if ($comment->user->img_url)
                                <img src="{{ Storage::url($comment->user->img_url)}}" alt="icon" class="comment__user-img">
                                @else
                                <img src="/images/person.png" alt="icon" class="comment__user-img">
                                @endif
                                @if ($comment->user->name)
                                <span class="comment__user-name">{{ $comment->user->name }}</span>
                                @else
                                <span class="comment__user-name">Unknown</span>
                                @endif
                            </div>
                            <div class="comment__comment">
                                <p class="comment__writen">{{ $comment->comment }}</p>
                            </div>
                        </div>
                        @endif
                    @endforeach
                @else
                    <div class="comment__none">
                        <p class="comment__none--msg">コメントはありません</p>
                    </div>
                @endif
            </div>
            <div class="comment__form">
                @if (Auth::check())
                <form action="{{ route('comment.create', $item->id) }}" method="POST" class="comment__form--form">
                    @csrf
                    <label for="comment" class="comment__form--label">商品へのコメント</label>
                    <textarea name="comment" class="comment__form--textarea"></textarea>
                    </div>
                    <button type="submit" class="comment__form--btn">コメントを送信する</button>
                </form>
                @else
                <div class="comment__login">
                    <p class="comment__login--msg">コメントは<a href="/login" class="comment__login--link">ログイン</a>が必要です</p>
                </div>
                @endif

            </div>
        </div>
    </div>
@endsection
