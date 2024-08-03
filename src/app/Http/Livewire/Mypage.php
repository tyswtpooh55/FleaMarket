<?php

namespace App\Http\Livewire;

use App\Models\Item;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Mypage extends Component
{
    use WithPagination;

    public $activeTab = 'exhibit';
    protected $items;

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

        if ($this->activeTab == "exhibit") {
            //出品した商品
            $this->items = Item::where('seller_id', $user->id)
                ->with('itemImages')
                ->paginate(10);
        } else {
            //購入した商品
            $this->items = Transaction::where('buyer_id', $user->id)
                ->with(['item.itemImages'])
                ->paginate(10)
                ->through(function ($transaction) {
                    return $transaction->item;
                });
        }

    }

    public function render()
    {
        return view('livewire.mypage', [
            'items' => $this->items,
        ]);
    }
}
