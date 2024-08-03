<div>
    <div class="sell__form--item">
        <label for="img_url" class="sell__form--label">商品の画像</label>
        @if ($imgs)
        <div class="sell__form--img">

            @foreach ($imgs as $img)
            <img src="{{ $img->temporaryUrl() }}" alt="img" class="sell__form--img-img" style="height: 100%">
            @endforeach
        </div>
        <div class="sell__form--img-reselect">
            <label for="img_url" class="sell__form--img-btn">画像を選択する</label>
            <input type="file" multiple wire:model='imgs' name="img_url[]" id="img_url" class="sell__form--img-inp">
        </div>

        @else
        <div class="sell__form--img">
            <label for="img_url" class="sell__form--img-btn">画像を選択する</label>
            <input type="file" multiple wire:model='imgs' name="img_url[]" id="img_url" class="sell__form--img-inp">
        </div>
        @endif

        @error('img_url')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>
</div>
