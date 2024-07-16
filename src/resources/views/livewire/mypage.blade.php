<div>
    <div class="mypage__item-list__heading">
        <div class="heading__tab">
            <button class="heading__tab--ttl {{ $activeTab == 'sold' ? 'active' : '' }}" wire:click.prevent="setTab('sold')">出品した商品</button>
            <button class="heading__tab--ttl {{ $activeTab == 'bought' ? 'active' : '' }}"
                wire:click.prevent="setTab('bought')">購入した商品</button>
        </div>
        <div class="heading__line"></div>
    </div>
    <div class="mypage__item">
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
