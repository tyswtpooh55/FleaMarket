<div>
    <div class="mypage__item-list__heading">
        <div class="heading__tab">
            <button class="heading__tab--ttl {{ $activeTab == 'exhibit' ? 'active' : '' }}" wire:click.prevent="setTab('exhibit')">出品した商品</button>
            <button class="heading__tab--ttl {{ $activeTab == 'bought' ? 'active' : '' }}"
                wire:click.prevent="setTab('bought')">購入した商品</button>
        </div>
        <div class="heading__line"></div>
    </div>
    <div class="mypage__item">
        <ul class="item__ul">
            @if (count($items) > 0)

                @foreach ($items as $item)
                <li class="item__li">
                    <div class="item__img">
                        <a href="{{ route('item', ['item_id' => $item->id]) }}" class="item__link">
                            @if ($item->itemImages->isNotEmpty())
                            <img src="{{ Storage::url($item->itemImages->first()->img_url) }}" alt="{{ $item->name }}" class="item__img--pic">
                            @else
                            <div class="item__img--none"><span class="item__img--none-name">{{ $item->name }}</span></div>
                            @endif
                        </a>
                    </div>
                </li>
                @endforeach

                @for ($i = count($items); $i < 10; $i++)
                <li class="item__li">
                    <div class="item__img--none"><span class="item__img--none-txt">No Item</span></div>
                </li>
                @endfor

            @else

                @for ($i = count($items); $i < 10; $i++)
                <li class="item__li">
                    <div class="item__img--none"><span class="item__img--none-txt">No Item</span></div>
                </li>
                @endfor

            @endif
        </ul>
    </div>
    <div class="pagination">
        {{ $items->links('vendor.pagination.default') }}
    </div>
</div>
