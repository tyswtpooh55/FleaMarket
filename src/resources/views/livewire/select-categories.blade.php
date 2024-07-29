<div>
    <div class="sell__form--item">
        <label for="category_id_1" class="sell__form--label">カテゴリー1</label>
        <select name="category_id_1" wire:model='selectedCategory1' class="sell__form--select">
            <option value="">-- 選択してください --</option>
            @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        @error('category_id_1')
        <p class="error">{{ $message }}</p>
        @enderror
    </div>
    <div class="sell__form--item">
        <label for="category_id_2" class="sell__form--label">カテゴリー2</label>
        <select name="category_id_2" wire:model='selectedCategory2'
        {{ $selectedCategory1 ? '' : 'disabled' }} class="sell__form--select">
            <option value="">-- 選択してください --</option>
            @foreach ($filteredCategories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        @error('category_id_2')
        <p class="error">{{ $message }}</p>
        @enderror
    </div>
</div>
