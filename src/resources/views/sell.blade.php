@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('header')

@endsection

@section('content')
    <div class="sell__content">
        <div class="sell__heading">
            <h2 class="sell__heading--ttl">商品の出品</h2>
        </div>
        <div class="sell__form">
            <form action="{{ route('sale') }}" method="POST" enctype="multipart/form-data" class="sell__form--form">
                @csrf

                @livewire('item-img')

                <div class="sell__form--ttl">
                    <h3>商品の詳細</h3>
                    <div class="sell__form--line"></div>
                </div>

                @livewire('select-categories')

                <div class="sell__form--item">
                    <label for="condition" class="sell__form--label">商品の状態</label>
                    <select name="condition_id" class="sell__form--select">
                        <option value="">-- 選択してください --</option>
                        @foreach ($conditions as $condition)
                        <option value="{{ $condition->id }}">{{ $condition->condition }}</option>
                        @endforeach
                    </select>
                    @error('condition_id')
                    <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="sell__form--ttl">
                    <h3>商品名と説明</h3>
                    <div class="sell__form--line"></div>
                </div>
                <div class="sell__form--item">
                    <label for="name" class="sell__form--label">商品名</label>
                    <input type="text" name="name" class="sell__form--input" value="{{ old('name') }}">
                    @error('name')
                    <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="sell__form--item">
                    <label for="brand" class="sell__form--label">ブランド名</label>
                    <input type="text" name="brand" class="sell__form--input" value="{{ old('brand') }}">
                    @error('brand')
                    <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="sell__form--item">
                    <label for="description" class="sell__form--label">商品の説明</label>
                    <textarea name="description" class="sell__form--textarea">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="sell__form--ttl">
                    <h3>販売価格</h3>
                    <div class="sell__form--line"></div>
                </div>
                <div class="sell__form--item">
                    <label for="price" class="sell__form--label">販売価格</label>
                    <div class="sell__form--price">
                        <input type="text" inputmode="numeric" name="price" class="sell__form--input" value="{{ old('price') }}">
                    </div>
                    @error('price')
                    <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <button class="sell__form--btn">出品する</button>
            </form>
        </div>
    </div>
@endsection
