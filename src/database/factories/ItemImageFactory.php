<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $dummyImgDir = storage_path('app/public/images/dummyImages');
        $images = glob($dummyImgDir . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);

        $randomImage = $images ? $images[array_rand($images)] : null;


        $imgUrl = $randomImage ? str_replace(storage_path('app/public/'), '', $randomImage) : null;

        return [
            'item_id' => Item::factory(),
            'img_url' => $imgUrl,
        ];
    }
}
