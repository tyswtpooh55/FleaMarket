<div>
    <div class="item__img">
        <div class="item__img--carousel">
            <img src="{{ Storage::url($currentImage->img_url) }}" alt="{{ $currentImage->name }}" class="item__img--img">
            <div class="item__img--carousel-controls">
                <button wire:click="prevImage" class="carousel-controls__btn">&lt;</button>
                <button wire:click="nextImage" class="carousel-controls__btn">&gt;</button>
            </div>
        </div>
    </div>
    <div class="item__img--thumbnails">
        @foreach ($images as $index => $image)
        <img src="{{ Storage::url($image->img_url) }}" alt="{{ $image->name }}"
            class="item__img--thumbnail {{ $index === $currentImageIndex ? 'active' : '' }}" wire:click="setImage({{ $index }})">
        @endforeach
    </div>
</div>
