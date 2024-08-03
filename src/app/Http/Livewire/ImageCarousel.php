<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ImageCarousel extends Component
{

    public $images;
    public $currentImageIndex = 0;

    public function mount($images)
    {
        $this->images = $images;
    }

    public function nextImage()
    {
        if ($this->currentImageIndex < count($this->images) -1) {
            $this->currentImageIndex++;
        } else {
            $this->currentImageIndex = 0;
        }
    }

    public function prevImage()
    {
        if ($this->currentImageIndex > 0) {
            $this->currentImageIndex--;
        } else {
            $this->currentImageIndex = count($this->images) -1;
        }
    }

    public function setImage($index)
    {
        $this->currentImageIndex = $index;
    }

    public function render()
    {
        return view('livewire.image-carousel', [
            'currentImage' => $this->images[$this->currentImageIndex],
        ]);
    }
}
