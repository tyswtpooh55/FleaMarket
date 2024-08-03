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
    public $randomOrder = [];

    public function mount()
    {
        $this->generateRandomOrder();
        $this->loadItems();
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
        $this->generateRandomOrder();
        $this->loadItems();
    }

    public function generateRandomOrder()
    {
        $this->randomOrder = Item::pluck('id')
            ->shuffle()
            ->toArray();
    }

    public function loadItems()
    {
        $user = Auth::user();

        if ($this->activeTab == "recommendation") {
            $this->items = Item::whereIn('id', $this->randomOrder)
                ->orderByRaw('FIELD(id, ' . implode(',' , $this->randomOrder) . ')')
                ->paginate(10);
        } else {
            $this->items = Like::where('user_id', $user->id)
                ->with(['item.itemImages'])
                ->paginate(10)
                ->through(function ($like) {
                    return $like->item;
                });
        }
    }

    public function updatedPage()
    {
        $this->loadItems();
    }

    public function render()
    {
        return view('livewire.item-list', [
            'items' => $this->items,
        ]);
    }
}
