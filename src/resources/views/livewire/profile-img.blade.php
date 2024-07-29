<div>
    <div class="profile__img">
        <div class="profile__img--icon">
            @if ($imgPreview)
            <img src="{{ $imgPreview }}" alt="Preview" class="profile__img--icon-img">
            @elseif ($nowImgUrl)
            <img src="{{ Storage::url($nowImgUrl) }}" alt="Profile" class="profile__img--icon-img">
            @else
            <div class="profile__img--icon-none"></div>
            @endif
        </div>
        <div class="profile__img--select">
            <label for="imgUrl" class="profile__img--select-link">画像を選択する</label>
            <input type="file" wire:model='imgUrl' name="imgUrl" id="imgUrl" class="profile__img--input">
        </div>
    </div>
</div>
