<?php

namespace App\Http\Livewire;

use App\Models\Item;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ItemList extends Component
{
    use WithPagination;

    public $activeTab = 'recommendation';
    protected $items;
    protected $likedItems;

    public function mount()
    {
        $this->loadItems();
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->loadItems();
    }

    public function loadItems()
    {
        $user = Auth::user();

        if ($this->activeTab == "recommendation") {
            $this->items = Item::paginate(10);
        } else {
            $likedItems = Like::where('user_id', $user->id)
                ->with('item.itemImages')
                ->paginate(10);

            $this->items = $likedItems->getCollection()->map(fn($likedItem) => $likedItem->item);

            $this->likedItems = $likedItems;
        }
    }

    public function render()
    {
        return view('livewire.item-list', [
            'items' => $this->items,
            'likedItems' => $this->likedItems ?? null,
        ]);
    }
}
