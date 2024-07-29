<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class ProfileImg extends Component
{
    use WithFileUploads;

    public $newImgUrl;
    public $imgPreview;
    public $nowImgUrl;

    public function mount($nowImgUrl)
    {
        $this->nowImgUrl = $nowImgUrl;
    }

    public function newImgUrl()
    {
        $this->imgPreview = $this->newImgUrl->temporaryUrl();
    }

    public function render()
    {
        return view('livewire.profile-img');
    }
}
