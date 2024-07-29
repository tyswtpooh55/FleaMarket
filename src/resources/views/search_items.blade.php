@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/search_items.css') }}">
@endsection


@section('content')
    <div class="search__heading">
        <h3 class="heading__ttl">"{{ $keyword }}"の検索結果 ({{ $countItems }}件)</h3>
    </div>
    <div class="search__item">
        <ul class="item__ul">
            @if ($countItems > 0)
            @foreach ($searchItems as $item)
            <li class="item__li">
                <div class="item__img">
                    <a href="{{ route('item', ['item_id' => $item->id]) }}" class="item__link">
                        @if ($item->itemImages->isNotEmpty())
                        <img src="{{ Storage::url($item->itemImages->first()->img_url) }}" alt="{{ $item->name }}"
                            class="item__img--pic">
                        @else
                        <div class="item__img--none"><span class="item__img--none-name">{{ $item->name }}</span></div>
                        @endif
                    </a>
                </div>
            </li>
            @endforeach
            {{ $searchItems->links() }}
            @else
            <div class="result__none">
                <p class="result__none--msg">該当する商品はありません</p>
            </div>
            @endif

        </ul>
    </div>
@endsection
