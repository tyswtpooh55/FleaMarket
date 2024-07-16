<?php

namespace App\Http\Livewire;

use App\Models\Item;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ItemList extends Component
{
    public $activeTab = 'recommendation';
    public $products;

    public function mount()
    {
        $this->loadProducts();
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->loadProducts();
    }

    public function loadProducts()
    {
        $user = Auth::user();

        if ($this->activeTab == "recommendation") {
            $this->products = Item::all();
        } else {
            $this->products = Like::where('user_id', $user->id)
                ->with('item')
                ->get();
        }
    }

    public function render()
    {
        return view('livewire.item-list');
    }
}
