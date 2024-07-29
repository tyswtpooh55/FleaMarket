<div>
    <div class="item__data--btn-like">
        <button wire:click="toggleLike" class="like-btn">
            <img src="{{ $isLiked ? '/images/star.yellow.png' : '/images/star.png' }}" alt="like" class="like__img"></button>
    <p class="like-count">{{ $countLikes }}</p>
    </div>
</div>
