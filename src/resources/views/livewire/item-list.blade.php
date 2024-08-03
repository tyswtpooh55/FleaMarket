<div>
    <div class="index__content">
        <div class="index__heading">
            <div class="heading__tab">
                <button class="heading__tab--ttl {{ $activeTab == 'recommendation' ? 'active' : '' }}" wire:click.prevent="setTab('recommendation')">おすすめ</button>
                @if (Auth::check())
                <button class="heading__tab--ttl {{ $activeTab == 'mylist' ? 'active' : '' }}" wire:click.prevent="setTab('mylist')">マイリスト</button>
                @endif

            </div>
            <div class="heading__line"></div>
        </div>
        <div class="index__item">
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
</div>
