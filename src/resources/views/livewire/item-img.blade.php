<div>
    <div class="sell__form--item">
        <label for="img_url" class="sell__form--label">商品の画像</label>
        <div class="sell__form--img">
            <label for="img_url" class="sell__form--img-btn">画像を選択する</label>
            <input type="file" multiple wire:model='img' name="img_url[]" id="img_url" class="sell__form--img-inp">
            @if ($photoStatus)
                <img src="{{ $preview_url }}" alt="img" class="sell__form--img-img">
            @endif
            @error('img_url')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>
