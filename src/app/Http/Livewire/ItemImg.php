<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class ItemImg extends Component
{
    use WithFileUploads;

    public $imgs = [];

    public function updatedImg()
    {
        $this->validate([
            'imgs.*' => 'image|max:1024',
        ]);

        foreach ($$this->imgs as $img) {
            $img->store('imgs');
        }
    }

    public function render()
    {
        return view('livewire.item-img');
    }
}
