<div>
    <div class="index__content">
        <div class="index__heading">
            <div class="heading__tab">
                <button class="heading__tab--ttl {{ $activeTab == 'recommendation' ? 'active' : '' }}" wire:click.prevent="setTab('recommendation')">おすすめ</button>
                <button class="heading__tab--ttl {{ $activeTab == 'mylist' ? 'active' : '' }}" wire:click.prevent="setTab('mylist')">マイリスト</button>
            </div>
            <div class="heading__line"></div>
        </div>
        <div class="index__item">
            <ul class="item__ul">
                @if (count($products) > 0)

                    @foreach ($products as $product)
                    <li class="item__li">
                        <div class="item__img">
                            <a href="" class="item__link"><img src="{{ $product->image_path }}" alt="{{ $product->name }}" class="item__img--pic"></a>
                        </div>
                    </li>
                    @endforeach

                    @for ($i = count($products); $i < 10; $i++)
                    <li class="item__li">
                        <div class="item__img--none"></div>
                    </li>
                    @endfor

                @else

                    @for ($i = count($products); $i < 10; $i++)
                    <li class="item__li">
                        <div class="item__img--none"></div>
                    </li>
                    @endfor

                @endif
            </ul>
        </div>
    </div>
</div>
