<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use RuntimeException;

class ItemImg extends Component
{
    use WithFileUploads;

    public $img;
    public $photoStatus = false;
    public $preview_url;

    public function updatedImg()
    {
        try {
            $this->preview_url = $this->img->temporaryUrl();
            $this->photoStatus = true;
        } catch (RuntimeException $e) {
            $this->photoStatus = false;
        }
    }

    public function render()
    {
        return view('livewire.item-img');
    }
}
