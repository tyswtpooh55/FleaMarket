<?php

namespace App\Http\Livewire;

use App\Models\Item;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LikeToggle extends Component
{
    public $itemId;
    public $isLiked;
    public $countLikes;

    public function mount($itemId)
    {
        $this->itemId = $itemId;
        $this->checkIfLiked();
        $this->updateCountLikes();
    }

    public function toggleLike()
    {
        $user = Auth::user();
        $like = Like::where('user_id', $user->id)
            ->where('item_id', $this->itemId)
            ->first();

        if ($like) {
            $like->delete();
        } else {
            Like::create([
                'user_id' => $user->id,
                'item_id' => $this->itemId,
            ]);
        }

        $this->checkIfLiked();
        $this->updateCountLikes();
    }

    public function checkIfLiked()
    {
        $user = Auth::user();
        $this->isLiked = Like::where('user_id', $user->id)
            ->where('item_id', $this->itemId)
            ->exists();
    }

    public function updateCountLikes()
    {
        $this->countLikes = Like::where('item_id', $this->itemId)
            ->count();
    }

    public function render()
    {
        return view('livewire.like-toggle');
    }
}
