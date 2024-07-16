<?php

namespace App\Http\Livewire;

use App\Models\Item;
use Livewire\Component;

class Mypage extends Component
{
    public $activeTab = 'sold';
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
        if ($this->activeTab == "sold") {
            $this->products = Item::all();
        } else {
            $this->products = Item::all();
        }
    }

    public function render()
    {
        return view('livewire.mypage');
    }
}
