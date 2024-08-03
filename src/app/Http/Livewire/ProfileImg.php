<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class ProfileImg extends Component
{
    use WithFileUploads;

    public $img;
    public $nowImgUrl;

    public function mount($nowImgUrl)
    {
        $this->nowImgUrl = $nowImgUrl;
    }

    public function updatedImg()
    {
        $this->validate([
            'img' => 'image|max:1024',
        ]);
    }

    public function render()
    {
        return view('livewire.profile-img');
    }
}
