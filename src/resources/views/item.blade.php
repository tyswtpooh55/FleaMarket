@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item.css') }}">
@endsection


@section('content')
    <div class="item__content">

        @if ($itemImages->isNotEmpty())
        <div class="item__img">

            @if (count($itemImages) == 1)
                        <img src="{{ Storage::url($item->itemImages->first()->img_url) }}" alt="{{ $item->name }}" class="item__img--img">
            @else
                @livewire('image-carousel', ['images' => $itemImages])
            @endif

        </div>
        @else
            <div class="item__img--none">
                <span class="item__img--none-txt">No Image</span>
            </div>
        @endif

        <div class="item__data">
            <div class="item__data--name">
                <h3 class="data__name--txt">{{ $item->name }}</h3>
                <p class="data__brand--txt">{{ $item->brand }}</p>
                <p class="data__price--txt">¥{{ number_format($item->price) }}</p>
            </div>
            <div class="item__data--btn">
                @if (Auth::check() && $item->transactions->isEmpty())

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
            <div class="item__data--purchase-btn">
                @if ($item->transactions->isNotEmpty())
                <button disabled="disabled" class="data__purchase-btn--btn data__purchase--btn--sold-out">Sold Out</button>
                @else
                <form action="{{ route('purchase', $item->id) }}" method="GET">
                    @csrf
                    <button type="submit" class="data__purchase-btn--btn">購入する</button>
                </form>
                @endif
            </div>
            <div class="item__data--detail">
                <h4 class="data__detail--ttl">商品説明</h4>
                <p class="data__detail--detail">{!! nl2br(e($item->description)) !!}</p>
            </div>
            <div class="item__data--info">
                <h4 class="data__info--ttl">商品の情報</h4>
                <div class="data__info--table">
                    <table>
                        <tr class="info__row">
                            <th class="info__label">カテゴリー</th>
                            <td class="info__data">
                                @foreach ($categories as $category)
                                <span class="category"> {{ $category->name }}</span>
                                @endforeach
                            </td>
                        </tr>
                        <tr class="info__row">
                            <th class="info__label">商品の状態</th>
                            <td class="info__data">{{ $item->condition->condition }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
